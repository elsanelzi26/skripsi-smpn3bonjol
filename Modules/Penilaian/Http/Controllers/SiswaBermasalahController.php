<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\KelasModel;
use Modules\DataMaster\Entities\SiswaModel;
use Modules\Penilaian\Entities\RekapMasalahModel;
use TCPDF;

class SiswaBermasalahController extends Controller
{
    public function index(Request $request)
    {
        $data_kelas = KelasModel::where('status_kelas', 1)->get();
        $rekap_masalah = [];

        if ($request->filled('id_kelas') && $request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {

            $tgl_mulai = $request->tanggal_mulai;
            $tgl_selesai = $request->tanggal_selesai;

            // Tarik data siswa beserta relasi absensi dan penilaian
            $data_siswa = SiswaModel::where('id_kelas', $request->id_kelas)
                ->with([
                    'absensi' => function ($q) use ($tgl_mulai, $tgl_selesai) {
                        $q->where('status_absensi', 'Alpha')
                            ->whereBetween('tanggal', [$tgl_mulai, $tgl_selesai]);
                    },
                    'penilaian.mapel'
                ])->get();

            // Memproses data dengan koleksi Eloquent
            $rekap_masalah = $this->prosesAnalisisSiswa($data_siswa);

            // PROSES SIMPAN OTOMATIS KE TABEL REKAP_MASALAH_SISWA
            // foreach ($rekap_masalah as $item) {
            //     // Perbaikan: Jangan timpa variabel $rekap_masalah dengan objek model!
            //     RekapMasalahModel::updateOrCreate(
            //         [
            //             'id_siswa'         => $item['id_siswa'],
            //             'tanggal_analisis' => date('Y-m-d'),
            //             'periode_mulai'    => $tgl_mulai,
            //             'periode_selesai'  => $tgl_selesai,
            //         ],
            //         [
            //             'id_kelas'        => $request->id_kelas,
            //             'catatan_masalah' => implode("\n", $item['alasan']),
            //             'status_bk'       => '1' // Disamakan dengan enum/teks di Blade
            //         ]
            //     );
            // }
            foreach ($rekap_masalah as $item) {

                $rekap = RekapMasalahModel::firstOrNew([
                    'id_siswa'         => $item['id_siswa'],
                    'tanggal_analisis' => date('Y-m-d'),
                    'periode_mulai'    => $tgl_mulai,
                    'periode_selesai'  => $tgl_selesai,
                ]);

                $rekap->id_kelas = $request->id_kelas;
                $rekap->catatan_masalah = implode("\n", $item['alasan']);

                // hanya isi default jika data baru
                if (!$rekap->exists) {
                    $rekap->status_bk = '1';
                }

                $rekap->save();
            }
        }

        return view('penilaian::pages.siswabermasalah.index', compact('data_kelas', 'rekap_masalah', 'request'));
    }

    public function cetakPdf(Request $request)
    {
        $id_kelas = $request->id_kelas;
        $tgl_mulai = $request->tanggal_mulai;
        $tgl_selesai = $request->tanggal_selesai;

        $kelas = KelasModel::find($id_kelas);

        $data_siswa = SiswaModel::where('id_kelas', $id_kelas)
            ->with([
                'absensi' => function ($q) use ($tgl_mulai, $tgl_selesai) {
                    $q->where('status_absensi', 'Alpha')
                        ->whereBetween('tanggal', [$tgl_mulai, $tgl_selesai]);
                },
                'penilaian.mapel'
            ])->get();

        $rekap_masalah = $this->prosesAnalisisSiswa($data_siswa);

        $html = view('penilaian::pages.siswabermasalah.pdf_report', compact('rekap_masalah', 'kelas', 'tgl_mulai', 'tgl_selesai'))->render();

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetTitle('Laporan Siswa Bermasalah');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->SetFont('helvetica', '', 11);

        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');

        return response($pdf->Output('Laporan_Siswa_Bermasalah.pdf', 'D'))
            ->header('Content-Type', 'application/pdf');
    }

    private function prosesAnalisisSiswa($data_siswa)
    {
        $hasil_rekap = [];

        foreach ($data_siswa as $siswa) {
            $is_bermasalah = false;
            $alasan_masalah = [];

            // Indikator A: Hitung jumlah Alpha (Gunakan pengaman jika null)
            $jumlah_alpha = $siswa->absensi ? $siswa->absensi->count() : 0;
            if ($jumlah_alpha >= 3) {
                $is_bermasalah = true;
                $alasan_masalah[] = "Ketidakhadiran: Alpa sebanyak " . $jumlah_alpha . " kali.";
            }

            // Indikator B: Ambil nilai akademik
            $mapel_di_bawah_kktp = [];
            if ($siswa->penilaian) {
                foreach ($siswa->penilaian as $n) {
                    $nilai_tugas = (float) ($n->nilai_tugas ?? 0);
                    $nilai_uh    = (float) ($n->nilai_uh ?? 0);
                    $nilai_uts   = (float) ($n->nilai_uts ?? 0);
                    $nilai_uas   = (float) ($n->nilai_uas ?? 0);

                    $nilai_akhir = ($nilai_tugas * 0.1) + ($nilai_uh * 0.2) + ($nilai_uts * 0.3) + ($nilai_uas * 0.4);
                    $kkm_mapel = $n->mapel->kkm ?? 75;

                    if ($nilai_akhir < $kkm_mapel) {
                        $nama_mapel = $n->mapel->nama_mapel ?? 'Mapel';
                        $mapel_di_bawah_kktp[] = $nama_mapel . " (Nilai: " . round($nilai_akhir, 2) . " | KKM: " . $kkm_mapel . ")";
                    }
                }
            }

            if (count($mapel_di_bawah_kktp) > 0) {
                $is_bermasalah = true;
                $alasan_masalah[] = "Akademik: Nilai di bawah KKM pada mapel " . implode(', ', $mapel_di_bawah_kktp);
            }

            if ($is_bermasalah) {
                // Perbaikan: Gunakan id_siswa sesuai primary key tabel murni milikmu
                $data_db = RekapMasalahModel::where('id_siswa', $siswa->id_siswa)
                    ->where('tanggal_analisis', date('Y-m-d'))
                    ->first();

                $hasil_rekap[] = [
                    'id_siswa'               => $siswa->id_siswa, // Kolom PK yang benar
                    'nama_siswa'             => $siswa->nama_siswa,
                    'nisn'                   => $siswa->nisn,
                    'jumlah_alpha'           => $jumlah_alpha,
                    'alasan'                 => $alasan_masalah,
                    'status_bk'              => $data_db->status_bk ?? '1',
                    'catatan_tindak_lanjut'  => $data_db->catatan_tindak_lanjut ?? ''
                ];
            }
        }

        return $hasil_rekap;
    }

    public function updateStatus(Request $request)
    {

        // 1. Validasi input yang dikirim dari modal form di Blade
        $request->validate([
            'id_siswa' => 'required',
            'tanggal_analisis' => 'required|date',
            'status_bk' => 'required|in:1,2,3',
            'catatan_tindak_lanjut' => 'nullable|string'
        ]);

        // 2. Cari data rekap di database dan update status beserta catatannya
        $rekap = RekapMasalahModel::where('id_siswa', $request->id_siswa)
            ->where('id_siswa', $request->id_siswa)
            ->where('tanggal_analisis', $request->tanggal_analisis)
            ->first();

        if ($rekap) {

            $rekap->status_bk = $request->status_bk;
            $rekap->catatan_tindak_lanjut = $request->catatan_tindak_lanjut;
            $rekap->save();
            return redirect()->back()->with('success', 'Status pembinaan BK berhasil diperbarui!');
        }

        return redirect()->back()->with('error', 'Data analisis hari ini tidak ditemukan, silakan klik tombol analisis ulang.');
    }
}
