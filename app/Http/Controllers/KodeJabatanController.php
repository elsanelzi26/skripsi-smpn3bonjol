<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KodeJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
       $url = 'https://e-kinerja.payakumbuhkota.go.id/api/simpeg/dataSimpeg';
       $dataSimpeg = json_decode(file_get_contents($url));
       $tampung_data = [];
       for($i=0; $i<count($dataSimpeg); $i++){
            array_push($tampung_data,$dataSimpeg[$i]->nama_organisasi);
       }
        //    return count($tampung_data);
        //    return count(array_unique($tampung_data));

        //    return array_unique($tampung_data);
        // return $tampung_data;

        $data_kode_jabatan = array_unique($tampung_data);
        return $data_kode_jabatan;

        // $arr = $tampung_data;
        
        // $unique = array_unique($arr); 
        // $dupes = array_diff_key( $arr, $unique ); 

        // return $dupes;
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
