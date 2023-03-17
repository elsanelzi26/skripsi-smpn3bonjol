<?php

namespace Modules\DataMaster\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;
use Modules\DataMaster\Entities\JabatanModel;
use Modules\DataMaster\Transformers\JabatanResource;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = JabatanModel::latest()->get();
        return response()->json([JabatanResource::collection($data), 'jabatans fetched.']);
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
        $validator = Validator::make($request->all(),[
            'nama_jabatan' => 'required',
            'keterangan' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }

        $jabatan = JabatanModel::create([
            'nama_jabatan' => $request->nama_jabatan,
            'keterangan' => $request->keterangan
         ]);
        
        return response()->json(['Jabatan created successfully.', new JabatanResource($jabatan)]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $jabatan = JabatanModel::find($id);
        if (is_null($jabatan)) {
            return response()->json('Data not found', 404); 
        }
        return response()->json([new JabatanResource($jabatan)]);
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
        $validator = Validator::make($request->all(),[
            'nama_jabatan' => 'required|max:255',
            'keterangan' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());       
        }


        $jabatan = JabatanModel::find($id);

        $jabatan->nama_jabatan = $request->nama_jabatan;
        $jabatan->keterangan = $request->keterangan;
        $jabatan->save();
        
        return response()->json(['Jabatan updated successfully.', new JabatanResource($jabatan)]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $jabatan = JabatanModel::findOrFail($id);
        $jabatan->delete();

        return response()->json('Jabatan deleted successfully');

    }
}
