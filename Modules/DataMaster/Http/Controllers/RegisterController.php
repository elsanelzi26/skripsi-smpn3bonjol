<?php

namespace Modules\DataMaster\Http\Controllers;

use App\Models\User;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Contracts\Support\Renderable;
use Modules\DataMaster\Entities\UserPemohonModel;


class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $provinces = Province::all();
        return view('datamaster::pages.auth.register', compact('provinces'));
    }

    public function getkabupaten(Request $request){
        $id_provinsi = $request->id_provinsi;
        $kabupatens = Regency::where('province_id',$id_provinsi)->get();

        $option = "<option value=''>---PILIH KABUPATEN---</option>";
        foreach($kabupatens as $kabupaten){
            $option .= "<option value=$kabupaten->id>$kabupaten->name</option>";
        }

        echo $option;
    }

    public function getkecamatan(Request $request){
        $id_kabupaten = $request->id_kabupaten;
        $kecamatans = District::where('regency_id',$id_kabupaten)->get();

        $option = "<option value=''>---PILIH KECAMATAN---</option>";
        foreach($kecamatans as $kecamatan){
            $option .= "<option value=$kecamatan->id>$kecamatan->name</option>";
        }

        echo $option;
    }

    public function getkelurahan(Request $request){
        $id_kecamatan = $request->id_kecamatan;
        $kelurahans = Village::where('district_id',$id_kecamatan)->get();

        $option = "<option value=''>---PILIH KELURAHAN---</option>";
        foreach($kelurahans as $kelurahan){
            $option .= "<option value=$kelurahan->id>$kelurahan->name</option>";
        }

        echo $option;
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
            'nama_pemohon' => 'required|max:150',
            'nik' => 'required|min:16|numeric|unique:tb_user_pemohon,nik',
            'npwp' => 'required|unique:tb_user_pemohon,npwp',
            'alamat_pemohon' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'telepon' => 'required|max:15',
            'email' => 'required|email:rfc,dns|unique:tb_user,email',
            'username' => 'required|unique:tb_user,username',
            'password' => 'min:6|required_with:confirm_password|same:confirm_password|max:8',
            'confirm_password' => 'required_with:password|same:password|min:6',
            'g-recaptcha-response' => 'required|captcha'
         
        ]);

        if($request->password == $request->confirm_password){
            $user = User::insertGetId([
                "username" => $request->username,
                "password" => \Hash::make($request->password),
                "email" => $request->email,
                "role" => 5,
            ]);

            if($user == TRUE){
                UserPemohonModel::create([
                    "id_user" => $user,
                    "nama_pemohon" => $request->nama_pemohon,
                    "nik" => $request->nik,
                    "npwp" => $request->npwp,
                    "alamat_pemohon" => $request->alamat_pemohon,
                    "provinsi" => $request->provinsi,
                    "kabupaten" => $request->kabupaten,
                    "kecamatan" => $request->kecamatan,
                    "kelurahan" => $request->kelurahan,
                    "rt" => $request->rt,
                    "rw" => $request->rw,
                    "nomor_telepon" => $request->telepon,
                ]);
        
                // return response()->json([
                //     'success' => 'Data Berhasil Disimpan',
                // ], 201);

                Alert::success('Sukses', 'Data Berhasil diajukan');
                return view('datamaster::pages.auth.login');

            } else {
                return response()->json([
                    'error' => 'Data Gagal Disimpan',
                ], 201);
            }

        } else {
            return response()->json([
                'error' => 'Data Gagal Disimpan',
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
        return view('datamaster::edit');
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
}
