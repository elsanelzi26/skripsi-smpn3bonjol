<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Support\Renderable;
use Modules\DataMaster\Entities\PendidikanModel;

class PendidikanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(PendidikanModel::query())->toJson();
        }
        return view('datamaster::pages.pendidikan.index');
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
            'nama_pendidikan' => 'required|max:50',
        ]);

        if($request->id_pendidikan != null){
            $pendidikan = PendidikanModel::find($request->id_pendidikan);
            if(! $pendidikan){
                abort(404);
            } 
            $pendidikan->update([
                "nama_pendidikan" => $request->nama_pendidikan
            ]);
            return response()->json([
                'success' => 'Data Berhasil Diupdate',
            ], 201);
        } else {
            PendidikanModel::create([
                "nama_pendidikan" => $request->nama_pendidikan
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
        $pendidikan = PendidikanModel::find($id);

        if(! $pendidikan){
            abort(404);
        }
        return $pendidikan;
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
        $pendidikan = PendidikanModel::where('id_pendidikan',$request->id)->delete();

        return response()->json([
            'success' => 'Data Berhasil Dihapus',
        ], 201);
    }
}
