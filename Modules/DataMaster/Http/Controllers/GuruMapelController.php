<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\GuruMapelModel;
use Modules\DataMaster\Entities\KelasModel;
use Modules\DataMaster\Entities\MataPelajaranModel;
use Modules\DataMaster\Entities\PegawaiModel;
use Modules\DataMaster\Entities\TahunAjaranModel;
use Yajra\DataTables\Facades\DataTables;

class GuruMapelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = GuruMapelModel::with(['pegawai','mapel','kelas','tahun_ajaran'])->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama_pegawai', function ($row) {
                    return $row->pegawai->nama_pegawai ?? '-';
                })
                ->addColumn('nama_mapel', function ($row) {
                    return $row->mapel->nama_mapel ?? '-';
                })
                ->addColumn('nama_kelas', function ($row) {
                    return $row->kelas->nama_kelas ?? '-';
                })
                ->addColumn('tahun_ajaran', function ($row) {
                    return $row->tahun_ajaran->tahun_ajaran ?? '-';
                })
                ->make(true);
        }
        $data_pegawai = PegawaiModel::with('user')
        ->where('status_pegawai', 1)
        ->whereHas('user', function ($q) {
            $q->where('id_role', 4); // Get Guru Mapel
        })
        ->get();
        $data_mapel = MataPelajaranModel::where('status_mapel', 1)->get();
        $data_kelas = KelasModel::where('status_kelas', 1)->get();
        $data_tahun_ajaran = TahunAjaranModel::where('status_aktif', 1)->get();

        return view('datamaster::pages.gurumapel.index',compact('data_pegawai','data_mapel','data_kelas','data_tahun_ajaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required',
            'id_mapel' => 'required',
            'id_kelas'        => 'required',
            'id_tahun_ajaran' => 'required',
        ]);

        $guru_mapel = GuruMapelModel::updateOrCreate(
            ['id_guru_mapel' => $request->id_guru_mapel],
            [
                'id_pegawai'  => $request->id_pegawai,
                'id_mapel'   => $request->id_mapel,
                'id_kelas'  => $request->id_kelas,
                'id_tahun_ajaran'   => $request->id_tahun_ajaran,
            ]
        );

        return response()->json(['success' => 'Data Berhasil Disimpan'], 201);
    }

    public function edit($id)
    {
        $guru_mapel = GuruMapelModel::find($id);

        if (!$guru_mapel) return response()->json(['message' => 'Not Found'], 404);

        return response()->json([
            'id_guru_mapel'  => $guru_mapel->id_guru_mapel,
            'id_pegawai'     => $guru_mapel->id_pegawai ?? '',
            'id_mapel'      => $guru_mapel->id_mapel ?? '',
            'id_kelas'     => $guru_mapel->id_kelas ?? '',
            'id_tahun_ajaran'      => $guru_mapel->id_tahun_ajaran ?? '',
        ]);
    }

    public function delete(Request $request)
    {
        $guru_mapel = GuruMapelModel::find($request->id);
        if ($guru_mapel) {
            $guru_mapel->delete();
            return response()->json(['success' => 'Data Berhasil Dihapus']);
        }
        return response()->json(['error' => 'Data tidak ditemukan'], 404);
    }
}
