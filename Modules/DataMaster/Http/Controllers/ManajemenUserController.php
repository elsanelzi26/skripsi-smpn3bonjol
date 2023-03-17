<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Modules\DataMaster\Entities\AgamaModel;
use Illuminate\Contracts\Support\Renderable;
use Modules\DataMaster\Entities\PendidikanModel;
use Modules\DataMaster\Entities\JenisKelaminModel;
use Modules\DataMaster\Entities\ManajemenUserModel;

class ManajemenUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ManajemenUserModel::select('tb_manajemen_user.*','tb_jenis_kelamin.nama_jenis_kelamin','tb_pendidikan.nama_pendidikan','tb_agama.nama_agama')
            ->join('tb_jenis_kelamin','tb_manajemen_user.id_jenis_kelamin','=','tb_jenis_kelamin.id_jenis_kelamin')
            ->join('tb_pendidikan','tb_manajemen_user.id_pendidikan','=','tb_pendidikan.id_pendidikan')
            ->join('tb_agama','tb_manajemen_user.id_agama','=','tb_agama.id_agama')
            ->get();
            return DataTables::of($data)->make(true);
        }
        $jeniskelamin = JenisKelaminModel::all();
        $pendidikan = PendidikanModel::all();
        $agama = AgamaModel::all();

        return view('datamaster::pages.manajemenuser.index', compact('jeniskelamin','pendidikan','agama'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('datamaster::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        dd($request->all());
        if($request->id_user != null){
            $request->validate([
                'nama_user' => 'required|max:150',
                'nip' => 'required|unique:tb_manajemen_user,nip,' . $request->id_user . ',id_user',
                'jenis_kelamin' => 'required',
                'pendidikan' => 'required',
                'agama' => 'required',
                'role' => 'required',
                'password' => 'required|min:6',
                'status_aktif' => 'required'
            ]);

            $manajemenuser = ManajemenUserModel::find($request->id_user);
            if(! $manajemenuser){
                abort(404);
            } 
            $manajemenuser->update([
                "nama_user" => $request->nama_user,
                "nip" => $request->nip,
                "password" => bcrypt($request->password),
                "id_jenis_kelamin" => $request->jenis_kelamin,
                "id_pendidikan" => $request->pendidikan,
                "id_agama" => $request->agama,
                "role" => $request->role,
                "status_aktif" => $request->status_aktif
            ]);
            return response()->json([
                'success' => 'Data Berhasil Diupdate',
            ], 201);
        } else {
            $request->validate([
                'nama_user' => 'required|max:150',
                'nip' => 'required|unique:tb_manajemen_user,nip',
                'jenis_kelamin' => 'required',
                'pendidikan' => 'required',
                'agama' => 'required',
                'role' => 'required',
                'password' => 'required|min:6',
                'status_aktif' => 'required'
            ]);

            ManajemenUserModel::create([
                "nama_user" => $request->nama_user,
                "nip" => $request->nip,
                "password" => bcrypt($request->password),
                "id_jenis_kelamin" => $request->jenis_kelamin,
                "id_pendidikan" => $request->pendidikan,
                "id_agama" => $request->agama,
                "role" => $request->role,
                "status_aktif" => $request->status_aktif
            ]);

            return response()->json([
                'success' => 'Data Berhasil Disimpan',
            ], 201);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('datamaster::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $manajemenuser = ManajemenUserModel::find($id);
        $jenis_kelamin = JenisKelaminModel::select('id_jenis_kelamin','nama_jenis_kelamin')->get();
        $pendidikan = PendidikanModel::select('id_pendidikan','nama_pendidikan')->get();
        $agama = AgamaModel::select('id_agama','nama_agama')->get();

        if(! $manajemenuser){
            abort(404);
        }

        return response([
            'manajemenuser' => $manajemenuser,
            'jeniskelamin' => $jenis_kelamin,
            'pendidikan' => $pendidikan,
            'agama' => $agama,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request)
    {
        $manajemenuser = ManajemenUserModel::where('id_user',$request->id)->delete();

        return response()->json([
            'success' => 'Data Berhasil Dihapus',
        ], 201);
    }
}
