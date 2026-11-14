<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\KelasModel;
use Modules\DataMaster\Entities\PegawaiModel;
use Modules\DataMaster\Entities\TahunAjaranModel;
use Yajra\DataTables\Facades\DataTables;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data =KelasModel::get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_kelas', function ($row) {
                    return $row->nama_kelas ?? '-';
                })
                ->addColumn('tingkat', function ($row) {
                    return $row->tingkat ?? '-';
                })
                ->addColumn('nama_walas', function ($row) {
                    return $row->walas->nama_pegawai ?? '-';
                })
                ->addColumn('tahun_ajaran', function ($row) {
                    return $row->tahun_ajaran->tahun_ajaran ?? '-';
                })
                ->addColumn('status_alert', function ($row) {

                    if ($row->status_kelas == 1) {
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
                    return $row->status_kelas ?? '-';
                })
                ->rawColumns([
                    'status_alert'
                ])
                ->make(true);
        }
        $data_pegawai = PegawaiModel::with('user')
        ->where('status_pegawai', 1)
        ->whereHas('user', function ($q) {
            $q->where('id_role', 3); // Guru BK
        })
        ->get();
        $data_tahun_ajaran = TahunAjaranModel::where('status_aktif', 1)->get();

        return view('datamaster::pages.kelas.index',compact('data_pegawai','data_tahun_ajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas'       => 'required',
            'tingkat'          => 'required',
            'id_walas'         => 'required',
            'id_tahun_ajaran'  => 'required',
        ]);

        $kelas = KelasModel::find($request->id_kelas);

        if (!$kelas) {
            $kelas = new KelasModel();
        }


         $data = [
            'nama_kelas'      => $request->nama_kelas,
            'tingkat'         => $request->tingkat,
            'id_walas'        => $request->id_walas,
            'id_tahun_ajaran' => $request->id_tahun_ajaran,
        ];

        // hanya saat simpan baru
        if (empty($request->id_kelas)) {
            $data['status_kelas'] = 1;
        }

        $kelas = KelasModel::updateOrCreate(
            ['id_kelas' => $request->id_kelas],
            $data
        );

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ], 201);
    }

     public function edit($id)
    {
        $kelas = KelasModel::with('walas')->find($id);

        if (!$kelas) {

            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([

            'id_kelas'      => $kelas->id_kelas ?? '',
            'nama_kelas'     => $kelas->nama_kelas ?? '',
            'tingkat'        => $kelas->tingkat ?? '',
            'id_walas'         => $kelas->id_walas ?? '-',
            'id_tahun_ajaran'  => $kelas->id_tahun_ajaran ?? '-',
            'status_kelas'  => $kelas->status_kelas ?? '',
        ]);
    }

    public function delete(Request $request)
    {
        $kelas= KelasModel::find($request->id);
        if ($kelas) {
            $kelas->delete();
            return response()->json(['success' => 'Data Berhasil Dihapus']);
        }
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    public function updateStatus(Request $request, $id)
    {
        $kelas = KelasModel::findOrFail($id);
        $kelas->update([
            'status_kelas' => $request->status_kelas
        ]);

        return response()->json([
            'message' => $request->status_kelas == 'Aktif'
                ? 'Kelas berhasil diaktifkan'
                : 'Kelas berhasil dinonaktifkan'
        ]);
    }
}
