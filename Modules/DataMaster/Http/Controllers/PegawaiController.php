<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Modules\DataMaster\Entities\OrtuModel;
use Modules\DataMaster\Entities\PegawaiModel;
use Modules\DataMaster\Entities\UsersModel;
use Modules\DataMaster\Entities\RoleModel;

class PegawaiController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = PegawaiModel::with('user');

            return DataTables::eloquent($data)

                ->addIndexColumn()

                ->addColumn('username', function ($row) {
                    return $row->user->username ?? '-';
                })
                ->addColumn('email', function ($row) {
                    return $row->user->email ?? '-';
                })

                ->addColumn('nama_role', function ($row) {
                    return $row->user->role->nama_role ?? '-';
                })

                ->make(true);
        }

        $role = RoleModel::whereNotIn('id_role', [6])->get();

        return view('datamaster::pages.pegawai.index', compact('role'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nip'             => 'required',
    //         'nama_pegawai'    => 'required',
    //         'jk'              => 'required',
    //         'tempat_lahir'    => 'required',
    //         'tanggal_lahir'   => 'required',
    //         'alamat'          => 'required',
    //         'no_hp'           => 'required',
    //         'email'           => 'required',
    //         'username'        => 'required',
    //     ]);

    //     // 1. SIMPAN Pegawai
    //     $pegawai = PegawaiModel::updateOrCreate(
    //         ['id_pegawai' => $request->id_pegawai],
    //         [
    //             'nip'             => $request->nip,
    //             'nama_pegawai'    => $request->nama_pegawai,
    //             'jk'              => $request->jk,
    //             'tempat_lahir'    => $request->tempat_lahir,
    //             'tanggal_lahir'   => $request->tanggal_lahir,
    //             'alamat'          => $request->alamat,
    //             'no_hp'           => $request->no_hp,
    //             'status_pegawai'  => 1 // Default Aktif
    //         ]
    //     );

    //     // cek user lama
    //     $user = UsersModel::where('id_pegawai', $pegawai->id_pegawai)->first();

    //     // set password
    //     if ($request->filled('password')) {
    //         $password = Hash::make($request->password);
    //     } elseif (!$user || empty($user->password)) {
    //         // user baru → password default
    //         $password = Hash::make('12345678');
    //     } else {
    //         // user lama → pakai password lama
    //         $password = $user->password;
    //     }

    //     // 2. SIMPAN USER Pegawai
    //     $user = UsersModel::updateOrCreate(
    //         ['id_pegawai' => $pegawai->id_pegawai],
    //         [
    //             'id_pegawai' => $pegawai->id_pegawai,
    //             'id_ortu'    => null,
    //             'username'   => $request->username,
    //             'email'      => $request->email,
    //             'password'   => $password,
    //             'id_role'    => $request->role,
    //             'status'     => 1, // Default Aktif
    //         ]
    //     );

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Data berhasil disimpan'
    //     ], 201);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'nip'             => 'required',
            'nama_pegawai'    => 'required',
            'jk'              => 'required',
            'tempat_lahir'    => 'required',
            'tanggal_lahir'   => 'required',
            'alamat'          => 'required',
            'no_hp'           => 'required',
            'email'           => 'required',
            'username'        => 'required',
        ]);

        // CEK MODE TAMBAH / EDIT
        $isNewPegawai = empty($request->id_pegawai);

        // SIMPAN PEGAWAI
        $pegawaiData = [
            'nip'             => $request->nip,
            'nama_pegawai'    => $request->nama_pegawai,
            'jk'              => $request->jk,
            'tempat_lahir'    => $request->tempat_lahir,
            'tanggal_lahir'   => $request->tanggal_lahir,
            'alamat'          => $request->alamat,
            'no_hp'           => $request->no_hp,
        ];

        // hanya saat tambah baru
        if ($isNewPegawai) {
            $pegawaiData['status_pegawai'] = 1;
        }

        $pegawai = PegawaiModel::updateOrCreate(
            ['id_pegawai' => $request->id_pegawai],
            $pegawaiData
        );

        // CEK USER LAMA
        $user = UsersModel::where('id_pegawai', $pegawai->id_pegawai)->first();

        // PASSWORD
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        } elseif (!$user || empty($user->password)) {
            $password = Hash::make('12345678');
        } else {
            $password = $user->password;
        }

        // DATA USER
        $userData = [
            'id_pegawai' => $pegawai->id_pegawai,
            'id_ortu'    => null,
            'username'   => $request->username,
            'email'      => $request->email,
            'password'   => $password,
            'id_role'    => $request->role,
        ];

        // hanya saat tambah baru
        if ($isNewPegawai) {
            $userData['status'] = 'Aktif';
        }

        // SIMPAN USER
        UsersModel::updateOrCreate(
            ['id_pegawai' => $pegawai->id_pegawai],
            $userData
        );

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ], 201);
    }

    public function edit($id)
    {
        // ambil user + relasi pegawai
        $user = UsersModel::with('pegawai')->find($id);

        if (!$user) {

            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([

            'id_user'      => $user->id_user,
            'username'     => $user->username,
            'email'        => $user->email,
            'role'         => $user->id_role,
            'status_user'  => $user->status,


            'id_pegawai'       => $user->pegawai->id_pegawai ?? '',
            'nip'              => $user->pegawai->nip ?? '',
            'nama_pegawai'     => $user->pegawai->nama_pegawai ?? '',
            'jk'               => $user->pegawai->jk ?? '',
            'tempat_lahir'     => $user->pegawai->tempat_lahir ?? '',
            'tanggal_lahir'    => $user->pegawai->tanggal_lahir ?? '',
            'alamat'           => $user->pegawai->alamat ?? '',
            'no_hp'            => $user->pegawai->no_hp ?? '',
            'status_pegawai'   => $user->pegawai->status_pegawai ?? '',
        ]);
    }

    public function delete(Request $request)
    {
        $user = UsersModel::find($request->id);
        $pegawai = PegawaiModel::where('id_user', $request->id)->delete();
        if ($user) {
            // Karena menggunakan SoftDeletes di Model, ini akan mengisi kolom deleted_at
            $user->delete();
            return response()->json(['success' => 'Data Berhasil Dihapus']);
        }
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    public function updateStatus(Request $request, $id)
    {
        $pegawai = PegawaiModel::findOrFail($id);
        $udpate_pegawai = $pegawai->update([
            'status_pegawai' => $request->status_pegawai
        ]);

        // update status user
        if ($udpate_pegawai && $pegawai->user) {

            $pegawai->user->update([
                'status' => $request->status_pegawai == 1
                    ? 'Aktif'
                    : 'NonAktif'
            ]);
        }
        return response()->json([
            'message' => $request->status_pegawai == 'Aktif'
                ? 'Pegawai berhasil diaktifkan'
                : 'Pegawai berhasil dinonaktifkan'
        ]);
    }
}
