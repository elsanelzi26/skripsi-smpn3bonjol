<?php

namespace Modules\Absensi\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Absensi\Entities\AbsensiModel;
use Modules\DataMaster\Entities\KelasModel;
use Modules\DataMaster\Entities\MataPelajaranModel;
use Modules\DataMaster\Entities\SiswaModel;
use Modules\DataMaster\Entities\TahunAjaranModel;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use TCPDF;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $data_kelas = KelasModel::with('tahun_ajaran')
            ->where('status_kelas', 1)
            ->whereHas('tahun_ajaran', function ($q) {
                $q->where('status_aktif', 1);
            })
            ->get();
        $data_mapel = MataPelajaranModel::all();
        $data_siswa = SiswaModel::all();

        return view('absensi::pages.kelolaabsensi.index', compact('data_mapel', 'data_kelas', 'data_siswa'));
    }

    public function getSiswa(Request $request)
    {
        $tahunAjaranAktif = TahunAjaranModel::where('status_aktif', 1)->first();
        $siswa = SiswaModel::where('id_kelas', $request->id_kelas)
            ->where('id_tahun_ajaran', $tahunAjaranAktif->id_tahun_ajaran)
            // ->orderBy('nama_siswa')
            ->get();

        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        // 1. Validasi input utama
        $request->validate([
            'tanggal'   => 'required|date',
            'id_kelas'  => 'required',
            'id_mapel'  => 'required',
            'id_siswa'  => 'required|array',
            'status'    => 'required|array',
        ]);

        try {
            $tanggal = $request->tanggal;
            $id_kelas = $request->id_kelas;
            $id_mapel = $request->id_mapel;

            $pegawai_id = auth()->user()->id_pegawai ?? 1;
            $tahun_aktif = TahunAjaranModel::where('status_aktif', 1)
                ->orderBy('id_tahun_ajaran', 'desc')
                ->first();

            // Jika ditemukan di database, ambil id-nya. Jika tidak ada, fallback ke angka 1
            $tahun_ajaran_id = $tahun_aktif ? $tahun_aktif->id_tahun_ajaran : 1;

            // Looping data siswa untuk disimpan ke database
            foreach ($request->id_siswa as $id_siswa) {
                // Ambil status absen berdasarkan id_siswa masing-masing
                $status_absensi = $request->status[$id_siswa] ?? null;

                if ($status_absensi) {
                    // Gunakan updateOrCreate untuk menghindari duplikasi absensi siswa di hari & mapel yang sama
                    AbsensiModel::updateOrCreate(
                        [
                            'tanggal'         => $tanggal,
                            'id_siswa'        => $id_siswa,
                            'id_mapel'        => $id_mapel,
                        ],
                        [
                            'id_kelas'        => $id_kelas,
                            'id_pegawai'      => $pegawai_id,
                            'id_tahun_ajaran' => $tahun_ajaran_id,
                            'status_absensi'  => $status_absensi,
                            'keterangan'      => $request->keterangan ?? '-', // Default strip jika kosong
                        ]
                    );
                }
            }

            // 3. Kembalikan respon sukses berbentuk JSON ke Ajax
            return response()->json([
                'success' => true,
                'message' => 'Data absensi berhasil disimpan!',
                // 'redirect_url' => route('absensi.rekap') 

            ]);
        } catch (Exception $e) {
            // Jika ada error database/sistem
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rekap(Request $request)
    {
        if ($request->ajax()) {
            $data = AbsensiModel::with(['pegawai', 'mapel', 'kelas', 'tahun_ajaran', 'siswa'])->get();

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
                ->addColumn('nama_siswa', function ($row) {
                    return $row->siswa->nama_siswa ?? '-';
                })
                ->addColumn('nisn_siswa', function ($row) {
                    return $row->siswa->nisn_siswa ?? '-';
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal ?? '-';
                })
                ->addColumn('status_absensi', function ($row) {
                    return $row->status_absensi ?? '-';
                })
                ->addColumn('keterangan', function ($row) {
                    return $row->keterangan ?? '-';
                })
                ->make(true);
        }

        $data_kelas = KelasModel::with('tahun_ajaran')
            ->where('status_kelas', 1)
            ->whereHas('tahun_ajaran', function ($q) {
                $q->where('status_aktif', 1);
            })
            ->get();
        $data_mapel = MataPelajaranModel::all();
        $data_siswa = SiswaModel::all();

        return view('absensi::pages.kelolaabsensi.rekap', compact('data_mapel', 'data_kelas', 'data_siswa'));
    }

    public function getRekap(Request $request)
    {
        // Ambil data filter dari request Ajax
        $id_kelas    = $request->id_kelas;
        $tgl_mulai   = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;
        $id_mapel    = $request->id_mapel;

        // Ambil tahun ajaran aktif dari database sebagai filter utama tambahan (opsional tapi aman)
        $tahun_aktif = TahunAjaranModel::where('status_aktif', 1)
            ->orderBy('id_tahun_ajaran', 'desc')
            ->first();
        $tahun_ajaran_id = $tahun_aktif ? $tahun_aktif->id_tahun_ajaran : null;

        try {
            // Query rekap menggunakan Eloquent murni (Sudah diperbaiki)
            $rekap = SiswaModel::select('tb_siswa.id_siswa', 'tb_siswa.nama_siswa', 'tb_siswa.nisn')
                ->selectRaw("SUM(CASE WHEN tb_absensi.status_absensi = 'Hadir' THEN 1 ELSE 0 END) as total_hadir")
                ->selectRaw("SUM(CASE WHEN tb_absensi.status_absensi = 'Izin' THEN 1 ELSE 0 END) as total_izin")
                ->selectRaw("SUM(CASE WHEN tb_absensi.status_absensi = 'Sakit' THEN 1 ELSE 0 END) as total_sakit")
                ->selectRaw("SUM(CASE WHEN tb_absensi.status_absensi = 'Alpha' THEN 1 ELSE 0 END) as total_alpha")

                // Kondisi filter digabung ke dalam Left Join agar siswa yang kosong absensinya tetap muncul
                ->leftJoin('tb_absensi', function ($join) use ($tgl_mulai, $tgl_selesai, $id_kelas, $id_mapel, $tahun_ajaran_id) {
                    $join->on('tb_siswa.id_siswa', '=', 'tb_absensi.id_siswa')
                        ->whereBetween('tb_absensi.tanggal', [$tgl_mulai, $tgl_selesai])
                        ->where('tb_absensi.id_kelas', $id_kelas);

                    // Jika id_mapel dipilih, filter di dalam join
                    if ($id_mapel) {
                        $join->where('tb_absensi.id_mapel', $id_mapel);
                    }

                    // Jika tahun_ajaran_id ada, filter di dalam join
                    if ($tahun_ajaran_id) {
                        $join->where('tb_absensi.id_tahun_ajaran', $tahun_ajaran_id);
                    }
                })

                // Filter utama untuk memastikan hanya mengambil siswa di kelas tersebut
                ->where('tb_siswa.id_kelas', $id_kelas)

                // Grouping & Ordering
                ->groupBy('tb_siswa.id_siswa', 'tb_siswa.nama_siswa', 'tb_siswa.nisn')
                ->orderBy('tb_siswa.nama_siswa', 'asc')
                ->get();

            // Tambahkan kalkulasi persentase untuk setiap siswa
            $rekap->transform(function ($item) {
                $total_hari = $item->total_hadir + $item->total_izin + $item->total_sakit + $item->total_alpha;

                // Jika total_hari > 0 dihitung persentasenya, jika 0 (belum absen sama sekali) set jadi 0%
                $item->persentase_hadir = $total_hari > 0
                    ? round(($item->total_hadir / $total_hari) * 100, 1)
                    : 0;

                return $item;
            });

            // Kembalikan data dalam bentuk JSON response ke Ajax
            return response()->json($rekap);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Gagal memuat rekap: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportPdf(Request $request)
    {
        // Jika id_kelas tidak dikirim, hentikan proses agar tidak menghasilkan PDF kosong
        if (!$request->has('id_kelas') || empty($request->id_kelas)) {
            return redirect()->back()->with('error', 'Gagal mengeksport data. Parameter kelas tidak ditemukan.');
        }

        // 1. Ambil data filter yang sama dari request (seperti getRekap)
        $id_kelas    = $request->id_kelas;
        $tgl_mulai   = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;
        $id_mapel    = $request->id_mapel;

        // Ambil tahun ajaran aktif dari database jika tidak dikirim via request
        $tahun_aktif = TahunAjaranModel::where('status_aktif', 1)
            ->orderBy('id_tahun_ajaran', 'desc')
            ->first();
        $tahun_ajaran_id = $tahun_aktif ? $tahun_aktif->id_tahun_ajaran : null;

        // Ambil info detail untuk judul laporan (Menggunakan where->first untuk mengantisipasi string mismatch dari URL)
        $kelas = KelasModel::where('id_kelas', $id_kelas)->first();
        $mapel = $id_mapel ? MataPelajaranModel::where('id_mapel', $id_mapel)->first() : null;
        $ta    = TahunAjaranModel::where('id_tahun_ajaran', $tahun_ajaran_id)->first();

        // 2. Jalankan Query Rekap Absensi yang sama persis dengan getRekap
        $rekap = SiswaModel::select('tb_siswa.id_siswa', 'tb_siswa.nama_siswa', 'tb_siswa.nisn')
            ->selectRaw("SUM(CASE WHEN tb_absensi.status_absensi = 'Hadir' THEN 1 ELSE 0 END) as total_hadir")
            ->selectRaw("SUM(CASE WHEN tb_absensi.status_absensi = 'Izin' THEN 1 ELSE 0 END) as total_izin")
            ->selectRaw("SUM(CASE WHEN tb_absensi.status_absensi = 'Sakit' THEN 1 ELSE 0 END) as total_sakit")
            ->selectRaw("SUM(CASE WHEN tb_absensi.status_absensi = 'Alpha' THEN 1 ELSE 0 END) as total_alpha")
            ->leftJoin('tb_absensi', function ($join) use ($tgl_mulai, $tgl_selesai, $id_kelas, $id_mapel, $tahun_ajaran_id) {
                $join->on('tb_siswa.id_siswa', '=', 'tb_absensi.id_siswa')
                    ->whereBetween('tb_absensi.tanggal', [$tgl_mulai, $tgl_selesai])
                    ->where('tb_absensi.id_kelas', $id_kelas);

                if ($id_mapel) {
                    $join->where('tb_absensi.id_mapel', $id_mapel);
                }

                if ($tahun_ajaran_id) {
                    $join->where('tb_absensi.id_tahun_ajaran', $tahun_ajaran_id);
                }
            })
            ->where('tb_siswa.id_kelas', $id_kelas)
            ->groupBy('tb_siswa.id_siswa', 'tb_siswa.nama_siswa', 'tb_siswa.nisn')
            ->orderBy('tb_siswa.nama_siswa', 'asc')
            ->get();

        // 3. Tambahkan kalkulasi persentase untuk setiap siswa
        $rekap->transform(function ($item) {
            $total_hari = $item->total_hadir + $item->total_izin + $item->total_sakit + $item->total_alpha;

            // Jika total_hari > 0 dihitung persentasenya, jika 0 (belum absen sama sekali) set jadi 0%
            $item->persentase_hadir = $total_hari > 0
                ? round(($item->total_hadir / $total_hari) * 100, 1)
                : 0;

            return $item;
        });

        // 4. Render file view blade menjadi string HTML murni
        $html = view('absensi::pages.kelolaabsensi.pdf_rekap', compact('rekap', 'kelas', 'mapel', 'ta', 'tgl_mulai', 'tgl_selesai'))->render();

        // 5. Inisialisasi Objek TCPDF (Ditambahkan tanda \ di depan TCPDF)
        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Atur Metadata Dokumen
        $pdf->SetCreator('Sistem Absensi');
        $pdf->SetAuthor('Guru / Walas');
        $pdf->SetTitle('Rekap Absensi ' . ($kelas ? $kelas->nama_kelas : ''));
        $pdf->SetSubject('Laporan Absensi');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(15, 15, 15);
        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->SetFont('helvetica', '', 10);

        $pdf->AddPage('P');

        // Watermark background
        $pdf->SetAlpha(0.2);
        $pdf->Image(
            public_path('template/tut_wuri.png'),
            45,   // X
            80,   // Y
            120,  // Width
            120,  // Height
            'PNG'
        );
        $pdf->SetAlpha(1);

        // Tulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // 6. Nama file dinamis berdasarkan filter
        $nama_kelas = $kelas ? $kelas->nama_kelas : 'Kelas';
        $nama_mapel = $mapel ? '_' . $mapel->nama_mapel : '';
        $filename = 'Rekap_Absensi_' . $nama_kelas . $nama_mapel . '.pdf';

        return response($pdf->Output($filename, 'D'))
            ->header('Content-Type', 'application/pdf');
    }
}
