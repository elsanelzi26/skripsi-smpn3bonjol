<?php

namespace Modules\DataMaster\Http\Controllers;

use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Support\Renderable;
use Modules\DataMaster\Entities\UserPemohonModel;
use Modules\DataMaster\Entities\DataPermohonanModel;

class AjukanPermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $id_user_pemohon = auth()->user()->id_user;
        if ($request->ajax()) {
            $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
            ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
            ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
            ->where('tb_user.id_user', $id_user_pemohon)
            ->get();
            return DataTables::of($data)->make(true);
        }

        return view('datamaster::pages.ajukanpermohonan.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $id_user_pemohon = auth()->user()->id_user;
        $datauserpemohon = UserPemohonModel::where('id_user',$id_user_pemohon)->first();
        $provinces = Province::all();
        return view('datamaster::pages.ajukanpermohonan.create', compact('datauserpemohon','provinces'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $originalName_ktp = uniqid(rand(), true).'_'. $request->ktp->getClientOriginalName();
        $originalName_sppt_pbb = uniqid(rand(), true).'_'. $request->sppt_pbb->getClientOriginalName();
        $originalName_bukti_kepemilikan = uniqid(rand(), true).'_'. $request->bukti_kepemilikan->getClientOriginalName();
        $originalName_denah_lokasi = uniqid(rand(), true).'_'. $request->denah_lokasi->getClientOriginalName();
        $originalName_lembar_bidang_tanah = uniqid(rand(), true).'_'. $request->lembar_bidang_tanah->getClientOriginalName();



        // $originalName_ktp = md5($request->ktp->getClientOriginalName().time());
        // $originalName_sppt_pbb = md5($request->sppt_pbb->getClientOriginalName().time());
        // $originalName_bukti_kepemilikan = md5($request->bukti_kepemilikan->getClientOriginalName().time());
        // $originalName_denah_lokasi = md5($request->denah_lokasi->getClientOriginalName().time());
        // $originalName_lembar_bidang_tanah = md5($request->lembar_bidang_tanah->getClientOriginalName().time());

      
        $filename_ktp =   $originalName_ktp . "." . $request->ktp->getClientOriginalExtension();
        $filename_sppt_pbb =   $originalName_sppt_pbb . "." . $request->sppt_pbb->getClientOriginalExtension();
        $filename_bukti_kepemilikan =   $originalName_bukti_kepemilikan . "." . $request->bukti_kepemilikan->getClientOriginalExtension();
        $filename_denah_lokasi =  $originalName_denah_lokasi . "." . $request->denah_lokasi->getClientOriginalExtension();
        $filename_lembar_bidang_tanah =   $originalName_lembar_bidang_tanah . "." . $request->lembar_bidang_tanah->getClientOriginalExtension();

        date_default_timezone_set('Asia/Jakarta');
        $tanggal_pemohon = date('j-m-Y');
        $id_user_pemohon = auth()->user()->id_user;
    
        if($request->id_provinsi == null){
            $request->validate([
                'nama_pemilik_tanah' => 'required|max:150',
                'nama_pemilik_bangunan' => 'required|max:150',
                'alamat_lokasi' => 'required',
                'provinsi' => 'required',
                'kabupaten' => 'required',
                'kecamatan' => 'required',
                'kelurahan' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'luas_tanah_yang_dimohon' => 'required|numeric',
                'luas_bangunan_yang_dimohon' => 'required|numeric',
                'nama_usaha' => 'required|max:150',
                'modal_usaha' => 'required',
                'skala_usaha' => 'required',
                'tingkat_resiko' => 'required',
                'ktp' => 'required|mimes:pdf||max:2097152',
                'sppt_pbb' => 'required|mimes:pdf||max:2097152',
                'bukti_kepemilikan' => 'required|mimes:pdf||max:2097152',
                'denah_lokasi' => 'required|mimes:pdf||max:2097152',
                'lembar_bidang_tanah' => 'required|mimes:pdf||max:2097152',
            ]);

            DataPermohonanModel::create([
                "id_user_pemohon" => $request->id_user_pemohon,
                "nama_pemilik_tanah" => $request->nama_pemilik_tanah,
                "nama_pemilik_bangunan" => $request->nama_pemilik_bangunan,
                "alamat_lokasi" => $request->alamat_lokasi,
                "provinsi" => $request->provinsi,
                "kabupaten" => $request->kabupaten,
                "kecamatan" => $request->kecamatan,
                "kelurahan" => $request->kelurahan,
                "rt" => $request->rt,
                "rw" => $request->rw,
                "luas_tanah_yang_dimohon" => $request->luas_tanah_yang_dimohon,
                "luas_bangunan_yang_dimohon" => $request->luas_bangunan_yang_dimohon,
                "nama_usaha" => $request->nama_usaha,
                "modal_usaha" => $request->modal_usaha,
                "skala_usaha" => $request->skala_usaha,
                "tingkat_resiko" => $request->tingkat_resiko,
                "ktp" => $filename_ktp,
                "sppt_dan_pbb" => $filename_sppt_pbb,
                "bukti_kepemilikan" => $filename_bukti_kepemilikan,
                "denah_lokasi" => $filename_denah_lokasi,
                "lembar_bidang_tanah" => $filename_lembar_bidang_tanah,
                "status_permohonan" => 1,
                "tanggal_pemohon" => $tanggal_pemohon,
                "tanggal_terbit" => '',
                "keterangan" => '',
                "isi_disposisi" => ''
            ]);
        } else {
            $request->validate([
                'nama_pemilik_tanah' => 'required|max:150',
                'nama_pemilik_bangunan' => 'required|max:150',
                'alamat_lokasi' => 'required',
                'id_provinsi' => 'required',
                'id_kabupaten' => 'required',
                'id_kecamatan' => 'required',
                'id_kelurahan' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'luas_tanah_yang_dimohon' => 'required|numeric',
                'luas_bangunan_yang_dimohon' => 'required|numeric',
                'nama_usaha' => 'required|max:150',
                'modal_usaha' => 'required',
                'skala_usaha' => 'required',
                'tingkat_resiko' => 'required',
                'ktp' => 'required|mimes:pdf||max:2097152',
                'sppt_pbb' => 'required|mimes:pdf||max:2097152',
                'bukti_kepemilikan' => 'required|mimes:pdf||max:2097152',
                'denah_lokasi' => 'required|mimes:pdf||max:2097152',
                'lembar_bidang_tanah' => 'required|mimes:pdf||max:2097152',

            ]);

            DataPermohonanModel::create([
                "id_user_pemohon" => $request->id_user_pemohon,
                "nama_pemilik_tanah" => $request->nama_pemilik_tanah,
                "nama_pemilik_bangunan" => $request->nama_pemilik_bangunan,
                "alamat_lokasi" => $request->alamat_lokasi,
                "provinsi" => $request->id_provinsi,
                "kabupaten" => $request->id_kabupaten,
                "kecamatan" => $request->id_kecamatan,
                "kelurahan" => $request->id_kelurahan,
                "rt" => $request->rt,
                "rw" => $request->rw,
                "luas_tanah_yang_dimohon" => $request->luas_tanah_yang_dimohon,
                "luas_bangunan_yang_dimohon" => $request->luas_bangunan_yang_dimohon,
                "nama_usaha" => $request->nama_usaha,
                "modal_usaha" => $request->modal_usaha,
                "skala_usaha" => $request->skala_usaha,
                "tingkat_resiko" => $request->tingkat_resiko,
                "ktp" => $filename_ktp,
                "sppt_dan_pbb" => $filename_sppt_pbb,
                "bukti_kepemilikan" => $filename_bukti_kepemilikan,
                "denah_lokasi" => $filename_denah_lokasi,
                "lembar_bidang_tanah" => $filename_lembar_bidang_tanah,
                "status_permohonan" => 1,
                "tanggal_pemohon" => $tanggal_pemohon,
                "tanggal_terbit" => '',
                "keterangan" => '',
                "isi_disposisi" => ''
            ]);
        }

        $request->ktp->storeAs('public/ktp', $filename_ktp);
        $request->sppt_pbb->storeAs('public/sppt_pbb', $filename_sppt_pbb);
        $request->bukti_kepemilikan->storeAs('public/bukti_kepemilikan', $filename_bukti_kepemilikan);
        $request->denah_lokasi->storeAs('public/denah_lokasi', $filename_denah_lokasi);
        $request->lembar_bidang_tanah->storeAs('public/lembar_bidang_tanah', $filename_lembar_bidang_tanah);
        // $request->file('file_rka')->move('image/FILE RKA', $filename);
        
        Alert::success('Sukses', 'Data Berhasil diajukan');
        return redirect()->route('ajukanpermohonan.index');
    }

    public function getwilayah()
    {
        $datauserpemohon = UserPemohonModel::where('id_user',2)->first();
        $provinces = Province::all();

        return response([
            'datauserpemohon' => $datauserpemohon,
            'provinces' => $provinces,
        ]);
    }

    public function getprovinsi(){
        $provinces = Province::all();
        return $provinces;
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

    public function getkabupatensamauser(Request $request){
        $id_provinsi = $request->id_provinsi;
        $kabupatens = Regency::where('province_id',$id_provinsi)->get();

        return $kabupatens;
    }

    public function getkecamatansamauser(Request $request){
        $id_kabupaten = $request->id_kabupaten;
        $kecamatans = District::where('regency_id',$id_kabupaten)->get();

        return $kecamatans;
    }

    public function getkelurahansamauser(Request $request){
        $id_kecamatan = $request->id_kecamatan;
        $kelurahans = Village::where('district_id',$id_kecamatan)->get();

        return $kelurahans;
    }

    // Admin 
    public function validasipermohonanadmin(Request $request)
    {
        if ($request->ajax()) {
            $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
            ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
            ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
            ->get();
            return DataTables::of($data)->make(true);
        }

        return view('datamaster::pages.permohonan.validasi_permohonan');
    }

    public function prosesvalidasipermohonan(Request $request)
    {
        //    dd($request->all());

        $request->validate([
            'status_permohonan' => 'required',
        ]);
        if($request->status_permohonan == 3){
            $request->validate([
                'keterangan' => 'required',
            ]);
            $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id_data_permohonan)->update([
                "status_permohonan" => $request->status_permohonan,
                "keterangan" => $request->keterangan,
            ]);
        } else {
            $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id_data_permohonan)->update([
                "status_permohonan" => $request->status_permohonan,
                "keterangan" => '',
            ]);
        }

        Alert::success('Sukses', 'Data Permohonan Berhasil Divalidasi');
        return redirect()->route('validasipermohonanadmin.index');
    }

    public function prosesteruskanpermohonan(Request $request)
    {
        $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id)->update([
            "status_permohonan" => 4
        ]);


        return response()->json([
            'success' => 'Data Permohonan Berhasil Diteruskan',
        ], 201);
    }

    // Kasie
    public function disposisipermohonankasie(Request $request){
        if ($request->ajax()) {
            $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
            ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
            ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
            ->where('status_permohonan', '!=', 1)
            ->where('status_permohonan', '!=', 2)
            ->where('status_permohonan', '!=', 3)
            ->get();
            return DataTables::of($data)->make(true);
        }

        return view('datamaster::pages.permohonan.kasie_lihat_permohonan');
    }

    public function prosesdisposisipermohonankasie(Request $request){
        // dd($request->all());
        $request->validate([
            'status_permohonan' => 'required',
        ]);
        if($request->status_permohonan == 6){
            $request->validate([
                'keterangan' => 'required',
            ]);
            $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id_data_permohonan)->update([
                "status_permohonan" => $request->status_permohonan,
                "keterangan" => $request->keterangan,
            ]);
        } else {
            $request->validate([
                'isi_disposisi' => 'required',
            ]);
            $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id_data_permohonan)->update([
                "status_permohonan" => $request->status_permohonan,
                "isi_disposisi" => $request->isi_disposisi,
            ]);
        }

        Alert::success('Sukses', 'Data Permohonan Berhasil Didisposisi');
        return redirect()->route('disposisipermohonankasie.index');
        
    }

     // Kabid
     public function disposisipermohonankabid(Request $request){
        if ($request->ajax()) {
            $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
            ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
            ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
            ->where('status_permohonan', '!=', 1)
            ->where('status_permohonan', '!=', 2)
            ->where('status_permohonan', '!=', 3)
            ->where('status_permohonan', '!=', 4)
            ->where('status_permohonan', '!=', 6)
            ->get();
            return DataTables::of($data)->make(true);
        }

        return view('datamaster::pages.permohonan.kabid_lihat_permohonan');
    }

    public function prosesdisposisipermohonankabid(Request $request){
        // dd($request->all());
        $request->validate([
            'status_permohonan' => 'required',
        ]);
        if($request->status_permohonan == 8){
            $request->validate([
                'keterangan' => 'required',
            ]);
            $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id_data_permohonan)->update([
                "status_permohonan" => $request->status_permohonan,
                "keterangan" => $request->keterangan,
                "isi_disposisi" => '',
            ]);
        } else {
            $request->validate([
                'isi_disposisi' => 'required',
            ]);
            $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id_data_permohonan)->update([
                "status_permohonan" => $request->status_permohonan,
                "isi_disposisi" => $request->isi_disposisi,
            ]);
        }

        Alert::success('Sukses', 'Data Permohonan Berhasil Didisposisi');
        return redirect()->route('disposisipermohonankabid.index');
        
    }

     // Kadis
     public function disposisipermohonankadis(Request $request){
        if ($request->ajax()) {
            $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
            ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
            ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
            ->where('status_permohonan', '!=', 1)
            ->where('status_permohonan', '!=', 2)
            ->where('status_permohonan', '!=', 3)
            ->where('status_permohonan', '!=', 4)
            ->where('status_permohonan', '!=', 5)
            ->where('status_permohonan', '!=', 6)
            ->where('status_permohonan', '!=', 8)
            ->get();
            return DataTables::of($data)->make(true);
        }

        return view('datamaster::pages.permohonan.kadis_lihat_permohonan');
    }

    public function prosesdisposisipermohonankadis(Request $request){
        // dd($request->all());
        $request->validate([
            'status_permohonan' => 'required',
        ]);
        if($request->status_permohonan == 10){
            $request->validate([
                'keterangan' => 'required',
            ]);
            $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id_data_permohonan)->update([
                "status_permohonan" => $request->status_permohonan,
                "keterangan" => $request->keterangan,
                "isi_disposisi" => '',
            ]);
        } else {
            $request->validate([
                'isi_disposisi' => 'required',
            ]);
            $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id_data_permohonan)->update([
                "status_permohonan" => $request->status_permohonan,
                "isi_disposisi" => $request->isi_disposisi,
            ]);
        }

        Alert::success('Sukses', 'Data Permohonan Berhasil Didisposisi');
        return redirect()->route('disposisipermohonankadis.index');
        
    }

    // Terbitkan Permohonan
    public function prosesterbitkanpermohonan(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            'status_permohonan' => 'required',
        ]);
        if($request->status_permohonan == 12){
            $request->validate([
                'keterangan' => 'required',
            ]);
            $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id_data_permohonan)->update([
                "status_permohonan" => $request->status_permohonan,
                "keterangan" => $request->keterangan,
                "isi_disposisi" => '',
                "tanggal_terbit" => '-',
            ]);
            Alert::success('Sukses', 'Data Permohonan Tidak Diterbitkan');
            return redirect()->route('disposisipermohonankadis.index');
        } else {
            date_default_timezone_set('Asia/Jakarta');
            $tanggal_penerbitan = date('d-m-Y');
            $datapermohonan = DataPermohonanModel::where('id_data_permohonan',$request->id_data_permohonan)->update([
                "status_permohonan" => $request->status_permohonan,
                "tanggal_terbit" => $tanggal_penerbitan,
            ]);

            Alert::success('Sukses', 'Data Permohonan Berhasil Diterbitkan');
            return redirect()->route('disposisipermohonankadis.index');
        } 
    }

}
