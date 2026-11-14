<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\KelasModel;
use Modules\DataMaster\Entities\SiswaModel;
use Modules\DataMaster\Entities\TahunAjaranModel;
use Yajra\DataTables\Facades\DataTables;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SiswaModel::with(['kelas','tahun_ajaran'])->get();

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
                ->make(true);
        }
        $data_kelas = KelasModel::where('status_kelas', 1)->get();
        $data_tahun_ajaran = TahunAjaranModel::where('status_aktif', 1)->get();

        return view('datamaster::pages.siswa.index', compact('data_kelas', 'data_tahun_ajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required',
            'nisn' => 'required',
            'nama_siswa' => 'required',
            'jk' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'email' => 'required',
            'no_hp' => 'required',
            'id_kelas'        => 'required',
            'id_tahun_ajaran' => 'required',
            'status_siswa' => 'required',
        ]);

        // dd($request->all());

       $siswa = SiswaModel::updateOrCreate(
            ['id_siswa' => $request->id_siswa],
            [
                'nik'               => $request->nik ?? '',
                'nisn'     => $request->nisn ?? '',
                'nama_siswa'    => $request->nama_siswa ?? '',
                'jk'               => $request->jk ?? '',
                'tempat_lahir'     => $request->tempat_lahir ?? '',
                'tanggal_lahir'    => $request->tanggal_lahir ?? '',
                'alamat'           => $request->alamat ?? '',
                'no_hp'            => $request->no_hp ?? '',
                'email'            => $request->email ?? '',
                'id_kelas'  => $request->id_kelas,
                'id_tahun_ajaran'   => $request->id_tahun_ajaran,
                'status_siswa'   => $request->status_siswa ?? '',
            ]
        );

        return response()->json(['success' => 'Data Berhasil Disimpan'], 201);
    }

    public function edit($id)
    {
        $siswa = SiswaModel::find($id);

        if (!$siswa) return response()->json(['message' => 'Not Found'], 404);

        return response()->json([
            'id_siswa'  => $siswa->id_siswa,
            'nik'     => $siswa->nik ?? '',
            'nisn'      => $siswa->nisn ?? '',
            'nama_siswa'  => $siswa->nama_siswa,
            'jk'     => $siswa->jk ?? '',
            'tempat_lahir'      => $siswa->tempat_lahir ?? '',
            'tanggal_lahir'  => $siswa->tanggal_lahir,
            'alamat'     => $siswa->alamat ?? '',
            'no_hp'      => $siswa->no_hp ?? '',
            'email'  => $siswa->email,
            'id_kelas'     => $siswa->id_kelas ?? '',
            'id_tahun_ajaran'      => $siswa->id_tahun_ajaran ?? '',
            'status_siswa'      => $siswa->status_siswa ?? '',

        ]);
    }

    public function delete(Request $request)
    {
        $siswa = SiswaModel::find($request->id);
        if ($siswa) {
            $siswa->delete();
            return response()->json(['success' => 'Data Berhasil Dihapus']);
        }
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }
}
