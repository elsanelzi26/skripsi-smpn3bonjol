<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\KelasModel;
use Modules\DataMaster\Entities\MataPelajaranModel;
use Modules\DataMaster\Entities\SiswaModel;
use Modules\DataMaster\Entities\TahunAjaranModel;
use Modules\Penilaian\Entities\PenilaianModel;
use TCPDF;

class PenilaianController extends Controller
{
    // PenilaianController.php

    public function index(Request $request)
    {
        // Mengambil kelas yang aktif berdasarkan tahun ajaran yang aktif
        $data_kelas = KelasModel::with('tahun_ajaran')
            ->where('status_kelas', 1)
            ->whereHas('tahun_ajaran', function ($q) {
                $q->where('status_aktif', 1);
            })
            ->get();

        $data_mapel = MataPelajaranModel::all();

        // Mengambil data tahun ajaran / semester yang aktif
        $data_tahun_ajaran = TahunAjaranModel::where('status_aktif', 1)->get();

        return view('penilaian::pages.kelolapenilaian.index', compact('data_mapel', 'data_kelas', 'data_tahun_ajaran'));
    }

    // Method AJAX untuk load siswa dan form nilai (Gantikan atau sesuaikan route penilaian.getSiswa)
    public function getSiswa(Request $request)
    {
        $id_kelas = $request->id_kelas;
        $id_mapel = $request->id_mapel;
        $id_tahun_ajaran = $request->id_tahun_ajaran;

        // Ambil data siswa berdasarkan kelas
        $siswa = SiswaModel::where('id_kelas', $id_kelas)->get();

        // Mapping data siswa dan cek apakah sudah ada nilai sebelumnya (opsional namun direkomendasikan)
        $data = $siswa->map(function ($item) use ($id_mapel, $id_tahun_ajaran) {
            // Cek ke database tb_penilaian / PenilaianModel jika guru ingin edit nilai yang sudah ada
            $nilai = PenilaianModel::where('id_siswa', $item->id_siswa)
                ->where('id_mapel', $id_mapel)
                ->where('id_tahun_ajaran', $id_tahun_ajaran)
                ->first();

            return [
                'id_siswa'    => $item->id_siswa,
                'nama_siswa'  => $item->nama_siswa,
                'nisn'        => $item->nisn,
                'nilai_tugas' => $nilai ? $nilai->nilai_tugas : '',
                'nilai_uts'   => $nilai ? $nilai->nilai_uts : '',
                'nilai_uas'   => $nilai ? $nilai->nilai_uas : '',
                'is_final'    => $nilai ? $nilai->is_final : 0,
            ];
        });

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $id_mapel = $request->id_mapel;
        $id_tahun_ajaran = $request->id_tahun_ajaran;
        $siswa_ids = $request->siswa_id; // Array id siswa

        if (empty($siswa_ids)) {
            return response()->json(['success' => false, 'message' => 'Tidak ada data siswa untuk disimpan.']);
        }

        $pegawai_id = auth()->user()->id_pegawai ?? 1;

        foreach ($siswa_ids as $siswa_id) {
            // Ambil nilai masing-masing siswa berdasarkan input name array-key nya
            $nilai_tugas = $request->nilai_tugas[$siswa_id] ?? null;
            $nilai_uh    = $request->nilai_uh[$siswa_id] ?? null;
            $nilai_uts   = $request->nilai_uts[$siswa_id] ?? null;
            $nilai_uas   = $request->nilai_uas[$siswa_id] ?? null;
            $is_final    = $request->is_final[$siswa_id] ?? 0;

            // Query simpan atau update ke tabel tb_penilaian
            $penilaian = PenilaianModel::updateOrCreate(
                [
                    'id_siswa'        => $siswa_id,
                    'id_mapel'        => $id_mapel,
                    'id_tahun_ajaran' => $id_tahun_ajaran,
                    'id_pegawai'      => $pegawai_id,
                ],
                [
                    'nilai_tugas' => $nilai_tugas,
                    'nilai_uh'    => $nilai_uh,
                    'nilai_uts'   => $nilai_uts,
                    'nilai_uas'   => $nilai_uas,
                    'is_final'    => $is_final,
                    'updated_at'  => now()
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Semua nilai siswa berhasil disimpan!']);
    }

    // 1. Menampilkan Halaman Rekap & Proses Filter via AJAX/Method GET
    public function rekap(Request $request)
    {
        $data_kelas = KelasModel::where('status_kelas', 1)->get();
        $data_mapel = MataPelajaranModel::all();
        $data_tahun_ajaran = TahunAjaranModel::all(); // Ini berisi semester juga

        // Menangkap filter jika ada
        $id_kelas = $request->id_kelas;
        $id_mapel = $request->id_mapel;
        $id_tahun_ajaran = $request->id_tahun_ajaran;

        $rekap_nilai = [];

        if ($id_kelas && $id_mapel && $id_tahun_ajaran) {
            // Ambil data nilai digabung dengan data siswa
            $scores = PenilaianModel::join('tb_siswa', 'tb_penilaian.id_siswa', '=', 'tb_siswa.id_siswa')
                ->where('tb_siswa.id_kelas', $id_kelas)
                ->where('tb_penilaian.id_mapel', $id_mapel)
                ->where('tb_penilaian.id_tahun_ajaran', $id_tahun_ajaran)
                ->select('tb_siswa.nama_siswa', 'tb_siswa.nisn', 'tb_penilaian.*')
                ->get();

            // Proses Kalkulasi Rata-rata, Huruf, dan Predikat
            foreach ($scores as $score) {
                // Hitung berdasarkan bobot persentase
                $bobot_tugas = $score->nilai_tugas * 0.10; // 10%
                $bobot_uh    = $score->nilai_uh    * 0.20; // 20%
                $bobot_uts   = $score->nilai_uts   * 0.30; // 30%
                $bobot_uas   = $score->nilai_uas   * 0.40; // 40%

                // Jumlahkan semua bobot lalu bulatkan 2 angka di belakang koma
                $rata_rata = round($bobot_tugas + $bobot_uh + $bobot_uts + $bobot_uas, 2);

                // Logika menentukan Huruf & Predikat
                if ($rata_rata >= 85) {
                    $huruf = 'A';
                    $predikat = 'Sangat Baik';
                } elseif ($rata_rata >= 75) {
                    $huruf = 'B';
                    $predikat = 'Baik';
                } elseif ($rata_rata >= 60) {
                    $huruf = 'C';
                    $predikat = 'Cukup';
                } else {
                    $huruf = 'D';
                    $predikat = 'Kurang';
                }

                $rekap_nilai[] = [
                    'nama_siswa'  => $score->nama_siswa,
                    'nisn'        => $score->nisn,
                    'nilai_tugas' => $score->nilai_tugas,
                    'nilai_uh' => $score->nilai_uh,
                    'nilai_uts'   => $score->nilai_uts,
                    'nilai_uas'   => $score->nilai_uas,
                    'rata_rata'   => $rata_rata,
                    'huruf'       => $huruf,
                    'predikat'    => $predikat
                ];
            }
        }

        return view('penilaian::pages.kelolapenilaian.rekap', compact(
            'data_kelas',
            'data_mapel',
            'data_tahun_ajaran',
            'rekap_nilai',
            'request'
        ));
    }

    public function exportPdf(Request $request)
    {
        // Ambil data filter yang sama dari request url
        $id_kelas = $request->id_kelas;
        $id_mapel = $request->id_mapel;
        $id_tahun_ajaran = $request->id_tahun_ajaran;
        // dd($id_tahun_ajaran);

        // Ambil info detail untuk judul laporan
        $kelas = KelasModel::find($id_kelas);
        $mapel = MataPelajaranModel::find($id_mapel);
        $ta = TahunAjaranModel::find($id_tahun_ajaran);

        $scores = PenilaianModel::join('tb_siswa', 'tb_penilaian.id_siswa', '=', 'tb_siswa.id_siswa')
            ->where('tb_siswa.id_kelas', $id_kelas)
            ->where('tb_penilaian.id_mapel', $id_mapel)
            ->where('tb_penilaian.id_tahun_ajaran', $id_tahun_ajaran)
            ->select('tb_siswa.nama_siswa', 'tb_siswa.nisn', 'tb_penilaian.*')
            ->get();

        $rekap_nilai = [];
        foreach ($scores as $score) {
            // Kalkulasi dibagi 4 karena ada Tugas, UH, UTS, dan UAS
            // Hitung berdasarkan bobot persentase
            $bobot_tugas = $score->nilai_tugas * 0.10; // 10%
            $bobot_uh    = $score->nilai_uh    * 0.20; // 20%
            $bobot_uts   = $score->nilai_uts   * 0.30; // 30%
            $bobot_uas   = $score->nilai_uas   * 0.40; // 40%

            // Jumlahkan semua bobot lalu bulatkan 2 angka di belakang koma
            $rata_rata = round($bobot_tugas + $bobot_uh + $bobot_uts + $bobot_uas, 2);

            if ($rata_rata >= 85) {
                $huruf = 'A';
                $predikat = 'Sangat Baik';
            } elseif ($rata_rata >= 75) {
                $huruf = 'B';
                $predikat = 'Baik';
            } elseif ($rata_rata >= 60) {
                $huruf = 'C';
                $predikat = 'Cukup';
            } else {
                $huruf = 'D';
                $predikat = 'Kurang';
            }

            $rekap_nilai[] = [
                'nama_siswa' => $score->nama_siswa,
                'nisn' => $score->nisn,
                'nilai_tugas' => $score->nilai_tugas,
                'nilai_uh' => $score->nilai_uh,
                'nilai_uts' => $score->nilai_uts,
                'nilai_uas' => $score->nilai_uas,
                'rata_rata' => $rata_rata,
                'huruf' => $huruf,
                'predikat' => $predikat
            ];
        }

        // return view('penilaian::pages.kelolapenilaian.pdf_rekap', compact('rekap_nilai', 'kelas', 'mapel', 'ta'));

        // 1. Render file view blade menjadi string HTML murni
        $html = view('penilaian::pages.kelolapenilaian.pdf_rekap', compact('rekap_nilai', 'kelas', 'mapel', 'ta'))->render();

        // 2. Inisialisasi Objek TCPDF (Gunakan orientasi 'P' atau 'L' sesuai kebutuhan)
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // 3. Atur Metadata Dokumen
        $pdf->SetCreator('Sistem Penilaian');
        $pdf->SetAuthor('Guru / Walas');
        $pdf->SetTitle('Rekap Nilai ' . $kelas->nama_kelas);
        $pdf->SetSubject('Laporan Nilai');

        // Remove default header/footer bawaan TCPDF (opsional, biar halaman bersih)
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Atur Margin (Kiri, Atas, Kanan) dalam milimeter
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 15);

        // Set Font standar
        $pdf->SetFont('helvetica', '', 10);

        // 3. Buka halaman baru dan tulis string HTML tadi ke dalam PDF
        $pdf->AddPage('P');
        // set opacity sebelum gambar
        $pdf->SetAlpha(0.2);

        $pdf->Image(
            public_path('template/tut_wuri.png'),
            45,   // X
            80,   // Y
            120,  // Width
            120,  // Height
            'PNG'
        );

        // kembalikan opacity normal supaya teks tidak ikut transparan
        $pdf->SetAlpha(1);
        $pdf->writeHTML($html, true, false, true, false, '');

        // 5. Output file langsung download ke browser
        $filename = 'Rekap_Nilai_' . $kelas->nama_kelas . '_' . $mapel->nama_mapel . '.pdf';

        return response($pdf->Output($filename, 'D'))
            ->header('Content-Type', 'application/pdf');
    }

    // Tambahan Perangkingan
    public function rekapPerangkingan(Request $request)
    {
        $data_kelas = KelasModel::where('status_kelas', 1)->get();
        $data_tahun_ajaran = TahunAjaranModel::get();

        $rekap_nilai = [];
        $data_mapel = [];

        if ($request->filled('id_kelas') && $request->filled('id_tahun_ajaran')) {
            $id_kelas = $request->id_kelas;
            $id_tahun_ajaran = $request->id_tahun_ajaran;

            // Ambil daftar nama mapel aktif untuk kolom tabel (misal ada 11 mapel)
            $data_mapel = MataPelajaranModel::where('status_mapel', 1)->get();
            $jumlah_mapel = $data_mapel->count() > 0 ? $data_mapel->count() : 1;

            // Ambil siswa berdasarkan kelas dan tahun ajaran
            $data_siswa = SiswaModel::where('id_kelas', $id_kelas)
                ->where('id_tahun_ajaran', $id_tahun_ajaran)
                ->get();

            foreach ($data_siswa as $siswa) {
                $nilai_per_mapel = [];
                $total_rata_rata_mapel = 0;

                foreach ($data_mapel as $mapel) {
                    $nilai = PenilaianModel::where('id_siswa', $siswa->id_siswa)
                        ->where('id_mapel', $mapel->id_mapel)
                        ->where('id_tahun_ajaran', $id_tahun_ajaran)
                        ->first();

                    if ($nilai) {
                        // Rata-rata per mapel = (Tugas + UH + UTS + UAS) / 4
                        $rata_mapel = ($nilai->nilai_tugas + $nilai->nilai_uh + $nilai->nilai_uts + $nilai->nilai_uas) / 4;
                    } else {
                        $rata_mapel = 0;
                    }

                    $nilai_per_mapel[$mapel->id_mapel] = round($rata_mapel, 2);
                    $total_rata_rata_mapel += $rata_mapel;
                }

                // Rata-rata gabungan akhir
                $rata_rata_akhir = $total_rata_rata_mapel / $jumlah_mapel;

                $rekap_nilai[] = [
                    'nama_siswa'  => $siswa->nama_siswa,
                    'nisn'        => $siswa->nisn,
                    'nilai_mapel' => $nilai_per_mapel, // Disimpan berdasarkan id_mapel
                    'rata_rata'   => round($rata_rata_akhir, 2)
                ];
            }

            // Urutkan dari rata-rata tertinggi ke terendah
            usort($rekap_nilai, function ($a, $b) {
                return $b['rata_rata'] <=> $a['rata_rata'];
            });
        }

        return view('penilaian::pages.kelolapenilaian.rekap-perangkingan', compact('data_kelas', 'data_tahun_ajaran', 'rekap_nilai', 'data_mapel'));
    }

    public function rekapPerangkinganExportPdf(Request $request)
    {
        // 1. Ambil data filter dari request url
        $id_kelas = $request->id_kelas;
        $id_tahun_ajaran = $request->id_tahun_ajaran;

        // 2. Ambil info detail untuk judul laporan
        $kelas = KelasModel::find($id_kelas);
        $ta = TahunAjaranModel::find($id_tahun_ajaran);

        // 3. Ambil daftar nama mapel aktif (Sama seperti fungsi rekapPerangkingan)
        $data_mapel = MataPelajaranModel::where('status_mapel', 1)->get();
        $jumlah_mapel = $data_mapel->count() > 0 ? $data_mapel->count() : 1;

        // 4. Ambil siswa berdasarkan kelas dan tahun ajaran
        $data_siswa = SiswaModel::where('id_kelas', $id_kelas)
            ->where('id_tahun_ajaran', $id_tahun_ajaran)
            ->get();

        $rekap_nilai = [];
        foreach ($data_siswa as $siswa) {
            $nilai_per_mapel = [];
            $total_rata_rata_mapel = 0;

            foreach ($data_mapel as $mapel) {
                $nilai = PenilaianModel::where('id_siswa', $siswa->id_siswa)
                    ->where('id_mapel', $mapel->id_mapel)
                    ->where('id_tahun_ajaran', $id_tahun_ajaran)
                    ->first();

                if ($nilai) {
                    // Rata-rata per mapel = (Tugas + UH + UTS + UAS) / 4
                    $rata_mapel = ($nilai->nilai_tugas + $nilai->nilai_uh + $nilai->nilai_uts + $nilai->nilai_uas) / 4;
                } else {
                    $rata_mapel = 0;
                }

                $nilai_per_mapel[$mapel->id_mapel] = round($rata_mapel, 2);
                $total_rata_rata_mapel += $rata_mapel;
            }

            // Rata-rata gabungan akhir seluruh mapel
            $rata_rata_akhir = $total_rata_rata_mapel / $jumlah_mapel;

            $rekap_nilai[] = [
                'nama_siswa'  => $siswa->nama_siswa,
                'nisn'        => $siswa->nisn,
                'nilai_mapel' => $nilai_per_mapel,
                'rata_rata'   => round($rata_rata_akhir, 2)
            ];
        }

        // 5. Urutkan dari rata-rata tertinggi ke terendah (Ranking)
        usort($rekap_nilai, function ($a, $b) {
            return $b['rata_rata'] <=> $a['rata_rata'];
        });

        // 6. Render file view blade menjadi string HTML murni
        // Catatan: variabel $mapel dihapus dari compact karena diganti $data_mapel
        $html = view('penilaian::pages.kelolapenilaian.pdf_rekap_perangkingan', compact('rekap_nilai', 'kelas', 'data_mapel', 'ta'))->render();

        // 7. Inisialisasi Objek TCPDF dengan orientasi 'L' (Landscape) agar muat banyak kolom mapel
        $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

        // Atur Metadata Dokumen
        $pdf->SetCreator('Sistem Penilaian');
        $pdf->SetAuthor('Guru / Walas');
        $pdf->SetTitle('Rekap Perangkingan Nilai ' . $kelas->nama_kelas);
        $pdf->SetSubject('Laporan Nilai Perangkingan');

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Atur Margin dan Auto Page Break
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 15);

        $pdf->SetFont('helvetica', '', 9); // Ukuran font diperkecil sedikit ke 9 agar pas di mode landscape

        // Buka halaman baru dengan orientasi Landscape ('L')
        $pdf->AddPage('L');

        // Set watermark Tut Wuri dengan opacity transparan
        $pdf->SetAlpha(0.08);
        // Sesuaikan posisi koordinat X dan Y karena layout sekarang Landscape
        $pdf->Image(
            public_path('template/tut_wuri.png'),
            110,   // X (Tengah untuk Landscape A4)
            45,    // Y
            80,    // Width
            80,    // Height
            'PNG'
        );

        // Kembalikan opacity normal supaya teks tidak ikut transparan
        $pdf->SetAlpha(1);

        // Tulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // 8. Output file langsung download ke browser
        $filename = 'Rekap_Perangkingan_Kelas_' . $kelas->nama_kelas . '.pdf';

        return response($pdf->Output($filename, 'D'))
            ->header('Content-Type', 'application/pdf');
    }
}
