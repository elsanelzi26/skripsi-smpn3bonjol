<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\JenisLombaModel;
use Yajra\DataTables\Facades\DataTables;

class JenisLombaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Murni Eloquent dengan Eager Loading
            $data = JenisLombaModel::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_jenis_lomba', function ($row) {
                    return $row->nama_jenis_lomba ?? '-';
                })
                ->addColumn('keterangan', function ($row) {
                    return $row->keterangan ?? '-';
                })
                ->make(true);
        }
        return view('datamaster::pages.jenislomba.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis_lomba' => 'required',
            'keterangan'     => 'required',
        ]);

        $jenislomba = JenisLombaModel::updateOrCreate(
            ['id_jenis_lomba' => $request->id_jenis_lomba],
            [
                'nama_jenis_lomba'  => $request->nama_jenis_lomba,
                'keterangan'   => $request->keterangan,
            ]
        );

        return response()->json(['success' => 'Data Berhasil Disimpan'], 201);
    }

    public function edit($id)
    {
        $jenislomba = JenisLombaModel::find($id);

        if (!$jenislomba) return response()->json(['message' => 'Not Found'], 404);

        return response()->json([
            'id_jenis_lomba'  => $jenislomba->id_jenis_lomba,
            'nama_jenis_lomba'     => $jenislomba->nama_jenis_lomba ?? '',
            'keterangan'      => $jenislomba->keterangan ?? '',
        ]);
    }

    public function delete(Request $request)
    {
        $jenislomba = JenisLombaModel::find($request->id);
        if ($jenislomba) {
            $jenislomba->delete();
            return response()->json(['success' => 'Data Berhasil Dihapus']);
        }
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }
}
