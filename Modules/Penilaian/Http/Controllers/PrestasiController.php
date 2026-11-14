<?php

namespace Modules\Penilaian\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\DataMaster\Entities\JenisLombaModel;
use Modules\DataMaster\Entities\SiswaModel;
use Modules\Penilaian\Entities\PrestasiModel;
use TCPDF;

class PrestasiController extends Controller
{
    public function index()
    {
        $data_prestasi = PrestasiModel::with(['siswa', 'jenis_lomba'])
            ->orderBy('tanggal_penghargaan', 'desc')
            ->get();

        // Mengambil data pendukung 
        $data_siswa = SiswaModel::all();
        $data_jenis_lomba = JenisLombaModel::all();

        return view('penilaian::pages.kelolaprestasi.index', compact('data_prestasi', 'data_siswa', 'data_jenis_lomba'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'            => 'required',
            'jenis_lomba_id'      => 'required',
            'tingkat'             => 'required',
            'peringkat'           => 'required',
            'tanggal_penghargaan' => 'required|date',
        ]);

        PrestasiModel::create([
            'id_siswa'            => $request->siswa_id,
            'id_jenis_lomba'      => $request->jenis_lomba_id,
            'tingkat'             => $request->tingkat,
            'peringkat'           => $request->peringkat,
            'tanggal_penghargaan' => $request->tanggal_penghargaan,
            'keterangan'          => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Prestasi siswa berhasil disimpan!');
    }
    public function edit($id)
    {
        $prestasi = PrestasiModel::findOrFail($id);
        return response()->json($prestasi);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id_prestasi'         => 'required',
            'siswa_id'            => 'required',
            'jenis_lomba_id'      => 'required',
            'tingkat'             => 'required',
            'peringkat'           => 'required',
            'tanggal_penghargaan' => 'required|date',
        ]);

        // Cari data lalu update menggunakan object-oriented Eloquent
        $prestasi = PrestasiModel::findOrFail($request->id_prestasi);
        $prestasi->update([
            'id_siswa'            => $request->siswa_id,
            'id_jenis_lomba'      => $request->jenis_lomba_id,
            'tingkat'             => $request->tingkat,
            'peringkat'           => $request->peringkat,
            'tanggal_penghargaan' => $request->tanggal_penghargaan,
            'keterangan'          => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data prestasi berhasil diperbarui!');
    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        if (!$id) {
            return response()->json([
                'success' => false,
                'message' => 'ID data tidak ditemukan.'
            ]);
        }

        // Proses hapus menggunakan Eloquent
        $deleted = PrestasiModel::destroy($id);

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Data prestasi siswa berhasil dihapus.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus data dari database.'
        ]);
    }

    public function cetakPdf(Request $request)
    {
        // Ambil query dasar Eloquent beserta relasinya
        $query = PrestasiModel::with(['siswa', 'jenis_lomba']);

        // Jika user memilih filter tingkat tertentu sebelum klik cetak
        if ($request->filled('filter_tingkat')) {
            $query->where('tingkat', $request->filter_tingkat);
        }

        $laporan_data = $query->orderBy('tanggal_penghargaan', 'desc')->get();
        $tingkat_judul = $request->filter_tingkat ?? 'Semua Tingkat';

        // return view('penilaian::pages.kelolaprestasi.pdf_laporan', compact('laporan_data', 'tingkat_judul'));

        // 1. Render file view blade menjadi string HTML murni
        $html = view('penilaian::pages.kelolaprestasi.pdf_laporan', compact('laporan_data', 'tingkat_judul'))->render();

        // 2. Inisialisasi TCPDF (Orientasi 'L' = Landscape agar tabel muat panjang kesamping)
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Atur Metadata Dokumen
        $pdf->SetCreator('Sistem Informasi Sekolah');
        $pdf->SetAuthor('Wali Kelas / Guru');
        $pdf->SetTitle('Laporan Prestasi Siswa - ' . $tingkat_judul);

        // Hilangkan default header/footer bawaan TCPDF agar tampilan bersih
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Atur Margin (Kiri = 15mm, Atas = 15mm, Kanan = 15mm)
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 15);

        // Set Font default
        $pdf->SetFont('helvetica', '', 11);

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


        // 4. Unduh file otomatis ke browser
        $filename = 'Laporan_Prestasi_Siswa_' . str_replace('/', '_', $tingkat_judul) . '.pdf';

        return response($pdf->Output($filename, 'D'))
            ->header('Content-Type', 'application/pdf');
    }
}
