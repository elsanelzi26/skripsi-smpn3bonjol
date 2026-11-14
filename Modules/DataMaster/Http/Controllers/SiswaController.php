<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\KelasModel;
use Modules\DataMaster\Entities\SiswaModel;
use Modules\DataMaster\Entities\TahunAjaranModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Modules\DataMaster\Entities\OrtuModel;
use Modules\DataMaster\Entities\usersModel;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SiswaModel::with(['kelas', 'tahun_ajaran'])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nik', function ($row) {
                    return $row->nik ?? '-';
                })
                ->addColumn('nisn', function ($row) {
                    return $row->nisn ?? '-';
                })
                ->addColumn('nama_siswa', function ($row) {
                    return $row->nama_siswa ?? '-';
                })
                ->addColumn('jk', function ($row) {
                    return $row->jk == 1 ? 'Laki-laki' : 'Perempuan';
                })
                ->addColumn('ttl', function ($row) {
                    $tempat = $row->tempat_lahir ?? '-';
                    $tanggal = $row->tanggal_lahir
                        ? date('d-m-Y', strtotime($row->tanggal_lahir))
                        : '-';

                    return $tempat . ', ' . $tanggal;
                })
                ->addColumn('alamat', function ($row) {
                    return $row->alamat ?? '-';
                })
                ->addColumn('no_hp', function ($row) {
                    return $row->no_hp ?? '-';
                })
                ->addColumn('email', function ($row) {
                    return $row->email ?? '-';
                })
                ->addColumn('nama_kelas', function ($row) {
                    return $row->kelas->nama_kelas ?? '-';
                })
                ->addColumn('tahun_ajaran', function ($row) {
                    return $row->tahun_ajaran->tahun_ajaran ?? '-';
                })
                ->addColumn('status_alert', function ($row) {

                    if ($row->status_siswa == 1) {
                        return '
                            <span class="badge badge-success"
                                style="font-size:11px;padding:4px 8px;">
                               AKTIF
                            </span>
                        ';
                    }

                    return '
                        <span class="badge badge-danger"
                            style="font-size:11px;padding:4px 8px;">
                            TIDAK AKTIF
                        </span>
                    ';
                })
                ->addColumn('status_siswa', function ($row) {
                    return $row->status_siswa ?? '-';
                })
                ->rawColumns([
                    'status_alert'
                ])
                ->make(true);
        }
        $data_kelas = KelasModel::where('status_kelas', 1)->get();
        $data_tahun_ajaran = TahunAjaranModel::where('status_aktif', 1)->get();

        return view('datamaster::pages.siswa.index', compact('data_kelas', 'data_tahun_ajaran'));
    }

    public function store(Request $request)
    {
        // Validasi input form gabungan
        $request->validate([
            'nik'               => 'required',
            'nisn'              => 'required',
            'nama_siswa'        => 'required',
            'jk'                => 'required',
            'id_kelas'          => 'required',
            'id_tahun_ajaran'   => 'required',
            'nama_ayah'         => 'required',
            'nama_ibu'          => 'required',
            'no_hp_ortu'        => 'required',
            'username_ortu'     => 'required',
        ]);

        DB::beginTransaction();

        try {
            // 1. Simpan atau Update data Siswa
            $siswa = SiswaModel::updateOrCreate(
                ['id_siswa' => $request->id_siswa],
                [
                    'nik'             => $request->nik,
                    'nisn'            => $request->nisn,
                    'nama_siswa'      => $request->nama_siswa,
                    'jk'              => $request->jk,
                    'tempat_lahir'    => $request->tempat_lahir ?? '',
                    'tanggal_lahir'   => $request->tanggal_lahir,
                    'alamat'          => $request->alamat_siswa ?? '',
                    'no_hp'           => $request->no_hp ?? '',
                    'email'           => $request->email ?? '',
                    'id_kelas'        => $request->id_kelas,
                    'id_tahun_ajaran' => $request->id_tahun_ajaran,
                    'status_siswa'    => $request->status_siswa ?? 1, // Default status_siswa = 1
                ]
            );

            // 2. Simpan atau Update data Orang Tua tied to id_siswa
            $ortu = OrtuModel::updateOrCreate(
                ['id_siswa' => $siswa->id_siswa],
                [
                    'nama_ayah' => $request->nama_ayah,
                    'nama_ibu'  => $request->nama_ibu,
                    'no_hp'     => $request->no_hp_ortu,
                    'alamat'    => $request->alamat_ortu ?? $request->alamat_siswa,
                ]
            );

            // 3. Management User Login Orang Tua
            $userOld = usersModel::where('id_ortu', $ortu->id_ortu)->first();

            if ($request->filled('password_ortu')) {
                $password = Hash::make($request->password_ortu);
            } elseif (!$userOld || empty($userOld->password)) {
                $password = Hash::make('12345678'); // Password default user baru
            } else {
                $password = $userOld->password;
            }

            // 4. Simpan atau Update tabel Users
            UsersModel::updateOrCreate(
                ['id_ortu' => $ortu->id_ortu],
                [
                    'id_pegawai' => NULL,
                    'username'   => $request->username_ortu,
                    'email'      => NULL,
                    'password'   => $password,
                    'id_role'    => 6, // Role Orang Tua
                    'status'     => 'Aktif' // Default status_user = Aktif
                ]
            );

            DB::commit();
            return response()->json(['success' => 'Data Berhasil Disimpan'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $siswa = SiswaModel::find($id);
        if (!$siswa) return response()->json(['message' => 'Not Found'], 404);

        $ortu = OrtuModel::where('id_siswa', $siswa->id_siswa)->first();
        $user = $ortu ? UsersModel::where('id_ortu', $ortu->id_ortu)->first() : null;

        return response()->json([
            // Data Siswa
            'id_siswa'         => $siswa->id_siswa,
            'nik'              => $siswa->nik ?? '',
            'nisn'             => $siswa->nisn ?? '',
            'nama_siswa'       => $siswa->nama_siswa,
            'jk'               => $siswa->jk ?? '',
            'tempat_lahir'     => $siswa->tempat_lahir ?? '',
            'tanggal_lahir'    => $siswa->tanggal_lahir,
            'alamat_siswa'     => $siswa->alamat ?? '',
            'no_hp_siswa'      => $siswa->no_hp ?? '',
            'email'            => $siswa->email,
            'id_kelas'         => $siswa->id_kelas ?? '',
            'id_tahun_ajaran'  => $siswa->id_tahun_ajaran ?? '',
            'status_siswa'     => $siswa->status_siswa ?? '',

            // Data Ortu
            'id_ortu'          => $ortu ? $ortu->id_ortu : '',
            'nama_ayah'        => $ortu ? $ortu->nama_ayah : '',
            'nama_ibu'         => $ortu ? $ortu->nama_ibu : '',
            'no_hp_ortu'       => $ortu ? $ortu->no_hp : '',
            'alamat_ortu'      => $ortu ? $ortu->alamat : '',

            // Data Akun User
            'username_ortu'    => $user ? $user->username : '',
            'status_user'      => $user ? $user->status : 'Aktif',
        ]);
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $siswa = SiswaModel::find($request->id);
            if ($siswa) {
                $ortu = OrtuModel::where('id_siswa', $siswa->id_siswa)->first();
                if ($ortu) {
                    UsersModel::where('id_ortu', $ortu->id_ortu)->delete();
                    $ortu->delete();
                }
                $siswa->delete();
                DB::commit();
                return response()->json(['success' => 'Data Berhasil Dihapus']);
            }
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Gagal menghapus data'], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_siswa' => 'required|in:0,1'
        ]);

        // Jalankan Database Transaction agar kedua tabel aman terupdate bersamaan
        DB::beginTransaction();

        try {
            // 1. Cari data siswa
            $siswa = SiswaModel::find($id);

            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data siswa tidak ditemukan'
                ], 404);
            }

            // 2. Update status di tabel siswa
            $siswa->status_siswa = $request->status_siswa;
            $siswa->save();

            // 3. Cari data orang tua berdasarkan id_siswa
            $ortu = OrtuModel::where('id_siswa', $siswa->id_siswa)->first();

            if ($ortu) {
                // Tentukan status string untuk tabel users ('Aktif' atau 'Nonaktif')
                $statusUser = $request->status_siswa == 1 ? 'Aktif' : 'Nonaktif';

                // 4. Update status di tabel users berdasarkan id_ortu
                UsersModel::where('id_ortu', $ortu->id_ortu)->update([
                    'status' => $statusUser
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Status siswa dan akun orang tua berhasil diperbarui'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status: ' . $e->getMessage()
            ], 500);
        }
    }
}
