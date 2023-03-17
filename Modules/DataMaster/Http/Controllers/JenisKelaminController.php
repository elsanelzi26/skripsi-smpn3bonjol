<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Support\Renderable;
use Modules\DataMaster\Entities\JenisKelaminModel;

class JenisKelaminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(JenisKelaminModel::query())->toJson();
        }
        return view('datamaster::pages.jeniskelamin.index');
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
            'nama_jenis_kelamin' => 'required|max:20',
        ]);

        if($request->id_jenis_kelamin != null){
            $jeniskelamin = JenisKelaminModel::find($request->id_jenis_kelamin);
            if(! $jeniskelamin){
                abort(404);
            } 
            $jeniskelamin->update([
                "nama_jenis_kelamin" => $request->nama_jenis_kelamin
            ]);
            return response()->json([
                'success' => 'Data Berhasil Diupdate',
            ], 201);
        } else {
            JenisKelaminModel::create([
                "nama_jenis_kelamin" => $request->nama_jenis_kelamin
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
        $jeniskelamin = JenisKelaminModel::find($id);

        if(! $jeniskelamin){
            abort(404);
        }
        return $jeniskelamin;
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
        $jeniskelamin = JenisKelaminModel::where('id_jenis_kelamin',$request->id)->delete();

        return response()->json([
            'success' => 'Data Berhasil Dihapus',
        ], 201);
    }
}
