<?php

namespace Modules\DataMaster\Http\Controllers;

use App\Models\District;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Support\Renderable;
use Modules\DataMaster\Entities\DataPermohonanModel;

class LaporanTableController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    // Data Permohonan Diajukan
    public function indexdatapermohonandiajukan(Request $request)
    {
       
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $tgl_awal = date("j-m-Y", strtotime($tanggal_awal));
        $tgl_akhir = date("j-m-Y", strtotime($tanggal_akhir));

        if ($request->ajax()) {
           if(!empty($request->tanggal_awal)){
                $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
                ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
                ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
                ->where('status_permohonan', 1)
                ->where('tanggal_pemohon', '>=', $tgl_awal)
                ->where('tanggal_pemohon', '<=', $tgl_akhir)
                ->get();
           } else {
                $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
                ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
                ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
                ->where('status_permohonan', 1)
                ->get();
           }
           return DataTables::of($data)->make(true);
        }

        $datapermohonan = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
        ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
        ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
        ->where('status_permohonan', 1)
        ->get();

        return view('datamaster::pages.laporan.tabel.dp_diajukan', compact('datapermohonan'));


      


       
        
        // if ($request->ajax()) {
        //     $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
        //     ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
        //     ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
        //     ->where('status_permohonan', 1)
        //     ->get();
        //     return DataTables::of($data)->make(true);
        // }
        
    }

    public function searchdatapermohonandiajukan(Request $request){
        // dd($request->all());
        $tanggal_awal = $request->tanggal_awal;
        $tanggal_akhir = $request->tanggal_akhir;

        $tgl_awal = date("j-m-Y", strtotime($tanggal_awal));
        $tgl_akhir = date("j-m-Y", strtotime($tanggal_akhir));

        if ($request->ajax()) {
            $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
            ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
            ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
            ->where('status_permohonan', 1)
            ->where('tanggal_pemohon', '>=', $tgl_awal)
            ->where('tanggal_pemohon', '<=', $tgl_akhir)
            // ->whereBetween('tgl_order', [$r->tanggal_awal, $r->tanggal_akhir])
            ->get();
            return DataTables::of($data)->make(true);
        }

        return view('datamaster::pages.laporan.tabel.dp_diajukan');
    }

    // public function cetakPermohonanDiajukan($tanggalAwal, $tanggalAkhir, Request $request){
    //     // dd("Tanggal Awal : " . $tanggalAwal, "Tanggal Akhir" . $tanggalAkhir);
    //     return view('datamaster::pages.laporan.tabel.cetak_dp_diajukan');
    // }

    public function cetakPermohonanDiajukan()
    {
        $datapermohonan = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
        ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
        ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
        ->where('status_permohonan', 1)
        ->get();

        $pdf = PDF::loadView('datamaster::pages.laporan.tabel.cetak_dp_diajukan', ['permohonandiajukanpertanggal' => $datapermohonan]);
        return $pdf->stream('Laporan-Data-Permohonan-Diajukan-Per-Tanggal.pdf');
    }


    // Data Permohonan Diterbitkan
    public function indexdatapermohonanditerbitkan(Request $request)
    {
        if ($request->ajax()) {
            $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
            ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
            ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
            ->where('tanggal_terbit','!=', '')
            ->where('status_permohonan','!=', 12)
            ->get();
            return DataTables::of($data)->make(true);
        }
        return view('datamaster::pages.laporan.tabel.dp_diterbitkan');
    }

    // public function searchdatapermohonanditerbitkan(Request $request){
    //     // dd($request->all());
    //     $tanggal_awal = $request->tanggal_awal;
    //     $tanggal_akhir = $request->tanggal_akhir;

    //     $tgl_awal = date("j-m-Y", strtotime($tanggal_awal));
    //     $tgl_akhir = date("j-m-Y", strtotime($tanggal_akhir));

    //     if ($request->ajax()) {
    //         $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
    //         ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
    //         ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
    //         ->where('tanggal_pemohon', '>=', $tgl_awal)
    //         ->where('tanggal_pemohon', '<=', $tgl_akhir)
    //         // ->whereBetween('tgl_order', [$r->tanggal_awal, $r->tanggal_akhir])
    //         ->get();
    //         return DataTables::of($data)->make(true);
    //     }

    //     return view('datamaster::pages.laporan.tabel.dp_diterbitkan');
    // }


    // Data Permohonan Berdasarkan Jenis Skala dan Tingkat Resiko
    public function indexdatapermohonanjenisskala_tingkatresiko(Request $request)
    {
        if ($request->ajax()) {
            $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
            ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
            ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
            ->get();
            return DataTables::of($data)->make(true);
        }

        return view('datamaster::pages.laporan.tabel.dp_jenis_skala_tingkat_resiko');
    }

     // Data Permohonan Berdasarkan Kecamatan dan Kelurahan
     public function indexdatapermohonankecamatan_kelurahan(Request $request)
     {
         if ($request->ajax()) {
             $data = DataPermohonanModel::select('tb_data_permohonan.*','tb_user_pemohon.*','tb_user.*')
             ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
             ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
             ->get();
             return DataTables::of($data)->make(true);
         }
 
         $kecamatans = District::all();
         return view('datamaster::pages.laporan.tabel.dp_kecamatan_kelurahan', compact('kecamatans'));
     }

    public function showdetaildatapermohonan($id){
        return view('datamaster::pages.laporan.detail.dp_diajukan');
    }

    public function frame($id_skpd,$filename){
        if(file_exists(storage_path("PPID2/{$id_skpd}/{$filename}"))) {
          return response()->file(storage_path("PPID2/{$id_skpd}/{$filename}"));
          }else{
            // return response()->file(public_path('medigo/images/includes/file3.jpg'));
          return view('layout.not_found');
          } 
    }
}
