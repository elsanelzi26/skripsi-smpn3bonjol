<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Absensi\Entities\AbsensiModel;
use Modules\DataMaster\Entities\MataPelajaranModel;
use Modules\DataMaster\Entities\OrtuModel;
use Modules\DataMaster\Entities\SiswaModel;
use Modules\Penilaian\Entities\PenilaianModel;
use Modules\Penilaian\Entities\PrestasiModel;

class MonitoringOrangTuaController extends Controller
{
    // Mengambil ID Siswa yang terikat dengan akun orang tua yang sedang login
    // private function getIdSiswaDinamis()
    // {
    //     return auth()->user()->id_siswa ?? 1;
    // }
    private function getIdSiswaDinamis()
    {
        // Ambil id_ortu dari user yang sedang login
        $id_ortu = auth()->user()->id_ortu;

        if ($id_ortu) {
            // Cari data di OrtuModel berdasarkan id_ortu, lalu ambil field id_siswa
            $ortu = OrtuModel::where('id_ortu', $id_ortu)->first();

            if ($ortu) {
                return $ortu->id_siswa;
            }
        }

        // Fallback/Nilai cadangan jika id_ortu tidak ditemukan atau data ortu tidak ada
        return 1;
    }

    public function index()
    {
        $id_siswa = $this->getIdSiswaDinamis();
        $siswa = SiswaModel::find($id_siswa);

        // Ambil daftar mapel untuk drop-down filter nilai
        $data_mapel = MataPelajaranModel::all();

        return view('penilaian::pages.monitoring_ortu.index', compact('siswa', 'data_mapel'));
    }

    /**
     * Jalur 1: Opsi Absensi + Grafik + Cek Notifikasi Alpha (Versi Eloquent)
     */
    public function getAbsensi(Request $request)
    {
        $request->validate([
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        $id_siswa = $this->getIdSiswaDinamis();
        $tgl_mulai = $request->tanggal_mulai;
        $tgl_selesai = $request->tanggal_selesai;

        // 1. Query Rekap Absensi Eloquent untuk Rincian Tabel
        $data_absensi = AbsensiModel::where('id_siswa', $id_siswa)
            ->whereBetween('tanggal', [$tgl_mulai, $tgl_selesai])
            ->get();

        // 2. Olah Data Grafik Menggunakan Fitur Collection bawaan Eloquent (Tanpa DB::raw & Tanpa groupBy SQL)
        // Cara ini jauh lebih cepat dan murni memanfaatkan object collection Laravel
        $rekap_grafik = $data_absensi->groupBy('status_absensi')->map(function ($row) {
            return $row->count();
        }); // Output otomatis berupa array key-value: {"Alpha": 4, "Hadir": 20}

        // 3. Logika Decision: Cek notifikasi batas aman Alpha
        $jumlah_alpha = $rekap_grafik['Alpha'] ?? 0;
        $batas_maksimal_alpha = 3;
        $notifikasi_peringatan = null;

        if ($jumlah_alpha >= $batas_maksimal_alpha) {
            $notifikasi_peringatan = "⚠️ Peringatan Penting! Ketidakhadiran (Alpa) anak Anda dalam periode ini telah mencapai " . $jumlah_alpha . " kali. Jumlah ini telah melewati batas toleransi maksimun sekolah (" . $batas_maksimal_alpha . " kali). Harap segera lakukan konfirmasi ke pihak sekolah atau Wali Kelas.";
        }

        return response()->json([
            'data_tabel' => $data_absensi,
            'data_grafik' => [
                'labels' => $rekap_grafik->keys(),
                'dataset' => $rekap_grafik->values(),
            ],
            'notifikasi' => $notifikasi_peringatan
        ]);
    }

    /**
     * Jalur 2: Opsi Nilai Akademik dengan Eager Loading Relasi Model (Bukan Join)
     */
    public function getNilai(Request $request)
    {
        $request->validate([
            'id_mapel' => 'required',
            'semester' => 'required' // Menangkap input 'Ganjil' atau 'Genap'
        ]);

        $id_siswa = $this->getIdSiswaDinamis();

        // Menggunakan Eager Loading untuk me-load relasi mapel dan tahunAjaran
        $data_nilai = PenilaianModel::with(['mapel', 'tahun_ajaran'])
            ->where('id_siswa', $id_siswa)
            ->where('id_mapel', $request->id_mapel)
            // ◄ FILTER BERDASARKAN KOLOM DI TABEL RELASI (Tahun Ajaran)
            ->whereHas('tahun_ajaran', function ($q) use ($request) {
                $q->where('semester', $request->semester);
            })
            ->get();

        // Hitung nilai akhir menggunakan collection transform
        $data_nilai->transform(function ($n) {
            $nilai_tugas = (float)($n->nilai_tugas ?? 0);
            $nilai_uh    = (float)($n->nilai_uh ?? 0);
            $nilai_uts   = (float)($n->nilai_uts ?? 0);
            $nilai_uas   = (float)($n->nilai_uas ?? 0);

            $n->nilai_akhir = ($nilai_tugas * 0.1) + ($nilai_uh * 0.2) + ($nilai_uts * 0.3) + ($nilai_uas * 0.4);

            $kkm = $n->mapel->kkm ?? 75;
            $n->status_kelulusan = $n->nilai_akhir >= $kkm ? 'Tuntas' : 'Tidak Tuntas';

            return $n;
        });

        return response()->json($data_nilai);
    }

    /**
     * Jalur 3: Opsi Daftar Semua Prestasi Anak (Murni Eloquent)
     */
    public function getPrestasi()
    {
        $id_siswa = $this->getIdSiswaDinamis();

        $data_prestasi = PrestasiModel::with('jenis_lomba')
            ->where('id_siswa', $id_siswa)
            ->orderBy('tanggal_penghargaan', 'desc')
            ->get();

        return response()->json($data_prestasi);
    }
}
