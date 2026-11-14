<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\MataPelajaranModel;
use Yajra\DataTables\Facades\DataTables;

class MataPelajaranController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Murni Eloquent dengan Eager Loading
            $data = MataPelajaranModel::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_mapel', function ($row) {
                    return $row->nama_mapel ?? '-';
                })
                ->addColumn('kode_mapel', function ($row) {
                    return $row->kode_mapel ?? '-';
                })
                ->addColumn('kkm', function ($row) {
                    return $row->kkm ?? '-';
                })
                ->addColumn('status_alert', function ($row) {

                    if ($row->status_mapel == 1) {
                        return '
                            <span class="badge badge-success"
                                style="font-size:11px;padding:4px 8px;">
                               AKTIF
                            </span>
                        ';
                    }

                    return '
                        <span class="badge badge-danger"
                            style="font-size:11px;padding:4px 8px;">
                            TIDAK AKTIF
                        </span>
                    ';
                })
                ->addColumn('status_aktif', function ($row) {
                    return $row->status_mapel ?? '-';
                })
                ->rawColumns([
                    'status_alert'
                ])
                ->make(true);
        }
        return view('datamaster::pages.mapel.index');
    }


       public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'kode_mapel' => 'required',
            'kkm'        => 'required',
        ]);

        $data = [
            'nama_mapel'  => $request->nama_mapel,
            'kode_mapel'   => $request->kode_mapel,
            'kkm'  => $request->kkm,
        ];

        // hanya saat simpan baru
        if (empty($request->id_mapel)) {
            $data['status_mapel'] = 1;
        }

        $mapel = MataPelajaranModel::updateOrCreate(
            ['id_mapel' => $request->id_mapel],
            $data
        );

        return response()->json([
            'success' => 'Data Berhasil Disimpan'
        ], 201);
    }


    public function edit($id)
    {
        $mapel = MataPelajaranModel::find($id);

        if (!$mapel) return response()->json(['message' => 'Not Found'], 404);

        return response()->json([
            'id_mapel'  => $mapel->id_mapel,
            'nama_mapel'     => $mapel->nama_mapel ?? '',
            'kode_mapel'      => $mapel->kode_mapel ?? '',
            'kkm'     => $mapel->kkm ?? '',
            'status_mapel'      => $mapel->status_mapel ?? '',
        ]);
    }

    public function delete(Request $request)
    {
        $mapel = MataPelajaranModel::find($request->id);
        if ($mapel) {
            $mapel->delete();
            return response()->json(['success' => 'Data Berhasil Dihapus']);
        }
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    public function updateStatus(Request $request, $id)
    {
        $mapel = MataPelajaranModel::findOrFail($id);
        $mapel->update([
            'status_mapel' => $request->status_mapel
        ]);

        return response()->json([
            'message' => $request->status_mapel == 'Aktif'
                ? 'Mata Pelajaran berhasil diaktifkan'
                : 'Mata Pelajaran berhasil dinonaktifkan'
        ]);
    }
}
