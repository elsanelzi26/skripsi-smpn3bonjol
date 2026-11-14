<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\OrtuModel;
use Modules\DataMaster\Entities\SiswaModel;
use Modules\DataMaster\Entities\usersModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class OrtuController extends Controller
{
     public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = OrtuModel::with(['siswa','user'])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_siswa', function ($row) {
                    return $row->siswa->nama_siswa ?? '-';
                })
                ->addColumn('nama_ayah', function ($row) {
                    return $row->nama_ayah ?? '-';
                })
                ->addColumn('nama_ibu', function ($row) {
                    return $row->nama_ibu ?? '-';
                })
                ->addColumn('no_hp', function ($row) {
                    return $row->no_hp ?? '-';
                })
                ->addColumn('alamat', function ($row) {
                    return $row->alamat ?? '-';
                })
                ->make(true);
        }
        $data_siswa = SiswaModel::all();

        return view('datamaster::pages.ortu.index', compact('data_siswa'));
    }

      public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required',
            'nama_ayah' => 'required',
            'nama_ibu'  => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'username'        => 'required',
            'status_user'     => 'required',
        ]);

        // 1. SIMPAN Ortu
        $ortu = OrtuModel::updateOrCreate(
            ['id_ortu' => $request->id_ortu],
            [
                'id_siswa'  => $request->id_siswa,
                'nama_ayah'   => $request->nama_ayah,
                'nama_ibu'  => $request->nama_ibu,
                'no_hp'   => $request->no_hp,
                'alamat'   => $request->alamat,
            ]
        );

        // cek user lama
        $user = UsersModel::where('id_ortu', $ortu->id_ortu)->first();

        // set password
        if ($request->filled('password')) {
            $password = Hash::make($request->password);
        } elseif (!$user || empty($user->password)) {
            // user baru → password default
            $password = Hash::make('12345678');
        } else {
            // user lama → pakai password lama
            $password = $user->password;
        }

        // 2. SIMPAN USER Ortu
        $user = UsersModel::updateOrCreate(
            ['id_ortu' => $ortu->id_ortu],
            [
                'id_pegawai' => NULL,
                'id_ortu'    => $ortu->id_ortu,
                'username'   => $request->username,
                'email'      => NULL,
                'password'   => $password,
                'id_role'    => 6, // Roel Ortu
                'status'     => $request->status_user
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ], 201);
    }

    public function edit($id)
    {
        // ambil user + relasi pegawai
        $ortu = OrtuModel::with('user')->find($id);

        if (!$ortu) {

            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([

            'id_user'      => $ortu->user->id_user,
            'username'     => $ortu->user->username,
            'status_user'  => $ortu->user->status,
            'id_ortu'       => $ortu->id_ortu ?? '',
            'id_siswa'       => $ortu->id_siswa ?? '',
            'nama_ayah'     => $ortu->nama_ayah ?? '',
            'nama_ibu'      => $ortu->nama_ibu ?? '',
            'alamat'        => $ortu->alamat ?? '',
            'no_hp'         => $ortu->no_hp ?? '',
        ]);
    }

    public function delete(Request $request)
    {
        $ortu = OrtuModel::find($request->id);
        if ($ortu) {
            $ortu->delete();
            return response()->json(['success' => 'Data Berhasil Dihapus']);
        }
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }
}
