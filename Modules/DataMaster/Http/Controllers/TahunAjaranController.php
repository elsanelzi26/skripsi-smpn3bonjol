<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\TahunAjaranModel;
use Yajra\DataTables\Facades\DataTables;

class TahunAjaranController extends Controller
{
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = TahunAjaranModel::get();

    //         return DataTables::of($data)
    //             ->addIndexColumn()
    //             ->addColumn('tahun_ajaran', function ($row) {
    //                 return $row->tahun_ajaran ?? '-';
    //             })
    //             ->addColumn('semester', function ($row) {
    //                 return $row->semester ?? '-';
    //             })
    //             ->addColumn('tanggal_mulai', function ($row) {
    //                 return $row->tanggal_mulai
    //                     ? date('d-m-Y', strtotime($row->tanggal_mulai))
    //                     : '-';
    //             })

    //             ->addColumn('tanggal_selesai', function ($row) {
    //                 return $row->tanggal_selesai
    //                     ? date('d-m-Y', strtotime($row->tanggal_selesai))
    //                     : '-';
    //             })
    //             ->addColumn('status_aktif', function ($row) {
    //                 if($row->status_aktif == 1){
    //                     $status_aktif = 'Aktif';
    //                 } else{
    //                      $status_aktif = 'Non Aktif';
    //                 }
    //                 return $status_aktif ?? '-';
    //             })
    //             ->make(true);
    //     }
    //     return view('datamaster::pages.tahunajaran.index');
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            // ambil semua data
            $data = TahunAjaranModel::orderBy('id_tahun_ajaran', 'desc')->get();

            // id tahun ajaran terbaru
            $latestId = $data->first()?->id_tahun_ajaran;

            // mapping flag
            $data->transform(function ($item) use ($latestId) {

                // tahun_ajaran terbaru
                $item->is_terbaru =
                    $item->id_tahun_ajaran == $latestId;

                // expired jika lewat tanggal_selesai
                $item->is_expired =
                    now()->gt(\Carbon\Carbon::parse($item->tanggal_selesai));

                return $item;
            });

            return DataTables::of($data)
                ->addIndexColumn()
                 ->addColumn('tahun_ajaran', function ($row) {
                    return $row->tahun_ajaran ?? '-';
                })
                ->addColumn('semester', function ($row) {
                    return $row->semester ?? '-';
                })
                ->addColumn('tanggal_mulai', function ($row) {
                    return $row->tanggal_mulai
                        ? date('d-m-Y', strtotime($row->tanggal_mulai))
                        : '-';
                })

                ->addColumn('tanggal_selesai', function ($row) {
                    return $row->tanggal_selesai
                        ? date('d-m-Y', strtotime($row->tanggal_selesai))
                        : '-';
                })

                ->addColumn('periode', function ($row) {

                    if ($row->tanggal_mulai && $row->tanggal_selesai) {
                        return date('d-m-Y', strtotime($row->tanggal_mulai))
                            . ' <span class="text-primary font-weight-bold">s/d</span> ' .
                            date('d-m-Y', strtotime($row->tanggal_selesai));
                    }

                    return '-';
                })

                ->addColumn('status_alert', function ($row) {

                    if ($row->status_aktif == 1) {
                        return '
                            <span class="badge badge-success"
                                style="font-size:11px;padding:4px 8px;">
                                DIBUKA
                            </span>
                        ';
                    }

                    return '
                        <span class="badge badge-danger"
                            style="font-size:11px;padding:4px 8px;">
                            DITUTUP
                        </span>
                    ';
                })

                ->addColumn('status_aktif', function ($row) {
                    return $row->status_aktif ?? '-';
                })

                // kirim flag ke DataTables JS
                ->addColumn('is_terbaru', function ($row) {
                    return $row->is_terbaru;
                })

                ->addColumn('is_expired', function ($row) {
                    return $row->is_expired;
                })

                ->rawColumns([
                    'tahun_ajaran',
                    'semester',
                    'periode',
                    'status_alert'
                ])

                ->make(true);
        }

        return view('datamaster::pages.tahunajaran.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran'     => 'required',
            'semester'         => 'required',
            'tanggal_mulai'    => 'required',
            'tanggal_selesai'  => 'required',
        ]);

        $data = [
            'tahun_ajaran'    => $request->tahun_ajaran,
            'semester'        => $request->semester,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ];

        // hanya saat simpan baru
        if (empty($request->id_tahun_ajaran)) {
            $data['status_aktif'] = 1;
        }

        $tahun_ajaran = TahunAjaranModel::updateOrCreate(
            ['id_tahun_ajaran' => $request->id_tahun_ajaran],
            $data
        );

        return response()->json([
            'success' => 'Data Berhasil Disimpan'
        ], 201);
    }

    public function edit($id)
    {
        $tahun_ajaran = TahunAjaranModel::find($id);

        if (!$tahun_ajaran) return response()->json(['message' => 'Not Found'], 404);

        return response()->json([
            'id_tahun_ajaran'  => $tahun_ajaran->id_tahun_ajaran,
            'tahun_ajaran'     => $tahun_ajaran->tahun_ajaran ?? '',
            'semester'         => $tahun_ajaran->semester ?? '',
            'tanggal_mulai'    => $tahun_ajaran->tanggal_mulai,
            'tanggal_selesai'  => $tahun_ajaran->tanggal_selesai,
            'status_aktif'     => $tahun_ajaran->status_aktif ?? '',
        ]);
    }

    public function delete(Request $request)
    {
        $tahun_ajaran = TahunAjaranModel::find($request->id);
        if ($tahun_ajaran) {
            $tahun_ajaran->delete();
            return response()->json(['success' => 'Data Berhasil Dihapus']);
        }
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }

    public function updateStatus(Request $request, $id)
    {
        $tahunAjaran = TahunAjaranModel::findOrFail($id);
        $tahunAjaran->update([
            'status_aktif' => $request->status_aktif
        ]);

        return response()->json([
            'message' => $request->status_aktif == 'Aktif'
                ? 'Tahun ajaran berhasil diaktifkan'
                : 'Tahun ajaran berhasil dinonaktifkan'
        ]);
    }
}
