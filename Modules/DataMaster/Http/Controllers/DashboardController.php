<?php

namespace Modules\DataMaster\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Absensi\Entities\AbsensiModel;
use Modules\DataMaster\Entities\JenisLombaModel;
use Modules\DataMaster\Entities\KelasModel;
use Modules\DataMaster\Entities\MataPelajaranModel;
use Modules\DataMaster\Entities\PegawaiModel;
use Modules\DataMaster\Entities\RoleModel;
use Modules\DataMaster\Entities\SiswaModel;
use Modules\DataMaster\Entities\TahunAjaranModel;
use Modules\Penilaian\Entities\PenilaianModel;
use Modules\Penilaian\Entities\PrestasiModel;
use Modules\Penilaian\Entities\RekapMasalahModel;

class DashboardController extends Controller
{
    public function index()
    {
        $count_role         = RoleModel::count();
        $count_tahun_ajaran = TahunAjaranModel::count();
        $count_pegawai      = PegawaiModel::count();
        $count_siswa        = SiswaModel::count();
        $count_kelas        = KelasModel::count();
        $count_mapel        = MataPelajaranModel::count();
        $count_lomba        = JenisLombaModel::count();
        $count_monitoring   = 1; // Default 1 karena cuma 1 anak per akun ortu
        $count_absensi      = AbsensiModel::count();
        $count_penilaian    = PenilaianModel::count();
        $count_prestasi     = PrestasiModel::count();
        $count_rekap_siswa_bermasalah = RekapMasalahModel::count();

        return view('datamaster::dashboard.index', compact(
            'count_role',
            'count_tahun_ajaran',
            'count_pegawai',
            'count_siswa',
            'count_kelas',
            'count_mapel',
            'count_lomba',
            'count_monitoring',
            'count_absensi',
            'count_penilaian',
            'count_prestasi',
            'count_rekap_siswa_bermasalah'
        ));
    }

   
}
