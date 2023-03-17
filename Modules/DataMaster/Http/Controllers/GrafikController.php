<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\DataMaster\Entities\DataPermohonanModel;

class GrafikController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function indexdatapermohonandiajukan()
    {
        $record = DataPermohonanModel::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(tb_data_permohonan.created_at) as day_name"), \DB::raw("DAY(tb_data_permohonan.created_at) as day"), \DB::raw("MONTHNAME(tb_data_permohonan.created_at) as month_name"))
        ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
        ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
        ->where('status_permohonan', 1)
        ->whereYear('tb_data_permohonan.created_at', date('Y'))
        // ->where('tb_data_permohonan.created_at', '<', Carbon::today()->subDay(6))
        ->groupBy('day_name','day','month_name')
        ->orderBy('day')
        ->get();

        // dd($record);
            
        $data = [];
            
        foreach($record as $row) {
            $data['label'][] = $row->month_name;
            $data['data'][] = (int) $row->count;
        }
        
        $data['chart_data'] = json_encode($data);

        // dd($data);
        return view('datamaster::pages.laporan.grafik.indexpermohonandiajukan', $data);
    }

    public function indexdatapermohonanditerbitkan()
    {
        $record = DataPermohonanModel::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(tb_data_permohonan.created_at) as day_name"), \DB::raw("DAY(tb_data_permohonan.created_at) as day"), \DB::raw("MONTHNAME(tb_data_permohonan.created_at) as month_name"))
        ->join('tb_user_pemohon','tb_user_pemohon.id_user_pemohon','=','tb_data_permohonan.id_user_pemohon')
        ->join('tb_user','tb_user.id_user','=','tb_user_pemohon.id_user')
        ->where('status_permohonan', 1)
        ->whereYear('tb_data_permohonan.created_at', date('Y'))
        // ->where('tb_data_permohonan.created_at', '<', Carbon::today()->subDay(6))
        ->groupBy('day_name','day','month_name')
        ->orderBy('day')
        ->get();

        // dd($record);
            
        $data = [];
            
        foreach($record as $row) {
            $data['label'][] = $row->month_name;
            $data['data'][] = (int) $row->count;
        }
        
        $data['chart_data'] = json_encode($data);

        // dd($data);
        return view('datamaster::pages.laporan.grafik.indexpermohonanditerbitkan', $data);
    }

    public function indexdatapermohonanperkecamatan()
    {
        $record = DataPermohonanModel::select(\DB::raw("COUNT(*) as count"), \DB::raw("districts.name as kecamatan_name"))
        ->join('districts','districts.id','=','tb_data_permohonan.kecamatan')
        ->whereYear('tb_data_permohonan.created_at', date('Y'))
        ->groupBy('kecamatan','kecamatan_name')
        ->orderBy('id')
        ->get();

        // dd($record);
            
        $data = [];
            
        foreach($record as $row) {
            $data['label'][] = $row->kecamatan_name;
            $data['data'][] = (int) $row->count;
        }
        
        $data['chart_data'] = json_encode($data);

        // dd($data);
        return view('datamaster::pages.laporan.grafik.indexpermohonanperkecamatan', $data);
    }


}
