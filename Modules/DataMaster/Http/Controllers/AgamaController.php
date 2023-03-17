<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Modules\DataMaster\Entities\AgamaModel;
use Illuminate\Contracts\Support\Renderable;

class AgamaController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(AgamaModel::query())->toJson();
        }
        return view('datamaster::pages.agama.index');
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
        $request->validate([
            'nama_agama' => 'required|max:50',
        ]);

        if($request->id_agama != null){
            $agama = AgamaModel::find($request->id_agama);
            if(! $agama){
                abort(404);
            } 
            $agama->update([
                "nama_agama" => $request->nama_agama
            ]);
            return response()->json([
                'success' => 'Data Berhasil Diupdate',
            ], 201);
        } else {
            AgamaModel::create([
                "nama_agama" => $request->nama_agama
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
        $agama = AgamaModel::find($id);

        if(! $agama){
            abort(404);
        }
        return $agama;
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
        $agama = AgamaModel::where('id_agama',$request->id)->delete();

        return response()->json([
            'success' => 'Data Berhasil Dihapus',
        ], 201);
    }
}
