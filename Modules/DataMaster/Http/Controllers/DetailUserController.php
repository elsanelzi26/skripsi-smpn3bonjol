<?php

namespace Modules\DataMaster\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Modules\DataMaster\Entities\AgamaModel;
use Modules\DataMaster\Entities\DetailUser;
use Illuminate\Contracts\Support\Renderable;
use Modules\DataMaster\Entities\PendidikanModel;
use Modules\DataMaster\Entities\JenisKelaminModel;

class DetailUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DetailUser::select('tb_detail_user.*','tb_user.*','tb_jenis_kelamin.nama_jenis_kelamin','tb_pendidikan.nama_pendidikan','tb_agama.nama_agama')
            ->join('tb_user','tb_detail_user.id_user','=','tb_user.id_user')
            ->join('tb_jenis_kelamin','tb_detail_user.id_jenis_kelamin','=','tb_jenis_kelamin.id_jenis_kelamin')
            ->join('tb_pendidikan','tb_detail_user.id_pendidikan','=','tb_pendidikan.id_pendidikan')
            ->join('tb_agama','tb_detail_user.id_agama','=','tb_agama.id_agama')
            ->get();
            return DataTables::of($data)->make(true);
        }
      
        $jeniskelamin = JenisKelaminModel::all();
        $pendidikan = PendidikanModel::all();
        $agama = AgamaModel::all();

        return view('datamaster::pages.detailuser.index', compact('jeniskelamin','pendidikan','agama'));
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
        // dd($request->all());

        $request->validate([
        'nama_lengkap' => 'required|max:150',
        'nip' => 'required|unique:tb_user,username',
        'jenis_kelamin' => 'required',
        'pendidikan' => 'required',
        'agama' => 'required',
        'role' => 'required',
        'password' => 'required|min:6',
        'nomor_telepon' => 'required|max:15',
        'alamat' => 'required'
        ]);

        // $password = hash('sha512', md5($r->password));

        $user = User::insertGetId([
            "username" => $request->nip,
            "password" => \Hash::make($request->password),
            "email" => $request->email,
            "role" => $request->role,
        ]);

        DetailUser::create([
            "id_user" => $user,
            "nama_lengkap" => $request->nama_lengkap,
            "id_jenis_kelamin" => $request->jenis_kelamin,
            "id_pendidikan" => $request->pendidikan,
            "id_agama" => $request->agama,
            "nomor_telepon" => $request->nomor_telepon,
            "alamat" => $request->alamat
        ]);

        // $request->validate([
        //     'nama_lengkap' => 'required|max:150',
        //     'nip' => 'required|unique:tb_user,username,' . $request->id_user . ',id_user',
        //     'jenis_kelamin' => 'required',
        //     'pendidikan' => 'required',
        //     'agama' => 'required',
        //     'role' => 'required',
        //     'password' => 'required|min:6',
        //     'nomor_telepon' => 'required|max:15',
        //     'alamat' => 'required'
        // ]);


        // $request->session()->flash('success', 'Data Berhasil ditambahkan');
        Alert::success('Data Berhasil', 'Data Berhasil ditambahkan');
        return redirect()->route('detailuser.index');
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
        $detailuser = DetailUser::join('tb_user','tb_detail_user.id_user','=','tb_user.id_user')
        ->where('tb_detail_user.id_user','=',$id)->first();

        $jenis_kelamin = JenisKelaminModel::select('id_jenis_kelamin','nama_jenis_kelamin')->get();
        $pendidikan = PendidikanModel::select('id_pendidikan','nama_pendidikan')->get();
        $agama = AgamaModel::select('id_agama','nama_agama')->get();

        if(! $detailuser){
            abort(404);
        }

        return response([
            'detailuser' => $detailuser,
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
        $detailuser = DetailUser::where('id_user',$request->id)->first();
        $user = User::where('id_user', $detailuser->id_user)->first();
        $deletedetailuser = $detailuser->delete();
        $deleteuser = $user->delete();
        return response()->json([
            'success' => 'Data Berhasil Dihapus',
        ], 201);
    }
}
