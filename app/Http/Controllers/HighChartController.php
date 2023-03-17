<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Modules\DataMaster\Entities\AgamaModel;
use Modules\DataMaster\Entities\PendidikanModel;
use Modules\DataMaster\Entities\UserPemohonModel;
use Modules\DataMaster\Entities\JenisKelaminModel;

class HighChartController extends Controller
{
    public function handleChart()
    {
        $userData = UserPemohonModel::select(DB::raw("COUNT(*) as count"))
                    ->whereYear('created_at', date('Y'))
                    ->groupBy(\DB::raw("Month(created_at)"))
                    ->pluck('count');
        
        // dd($userData);
          
        return view('home', compact('userData'));
    }

    public function barchart(){
        $agama = AgamaModel::all();
        $jenis_kelamin = JenisKelaminModel::all();
        $pendidikan = PendidikanModel::all();
    	$agama_count = count($agama);    	
    	$jenis_kelamin_count = count($jenis_kelamin);
    	$pendidikan_count = count($pendidikan);

        // dd($agama_count, $jenis_kelamin_count, $pendidikan_count);
    	
    	return view('pages.barchart',compact('agama_count','jenis_kelamin_count','pendidikan_count'));
    }

    public function chart(){
     
        $record = UserPemohonModel::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
                ->where('created_at', '<', Carbon::today()->subDay(6))
                ->groupBy('day_name','day')
                ->orderBy('day')
                ->get();
        
        // dd($record);
            
        $data = [];
            
        foreach($record as $row) {
            $data['label'][] = $row->day_name;
            $data['data'][] = (int) $row->count;
        }
     
        // $data['label'][] = [10,15];
        // $data['data'][] = [20,35];

         $data['chart_data'] = json_encode($data);

        // dd($data);
        // return view('chart-js', $data);
        return view('pages.charjs', $data);
    }
}
