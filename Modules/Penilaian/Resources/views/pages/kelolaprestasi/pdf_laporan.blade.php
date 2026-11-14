<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Prestasi Siswa</title>

    <style>
        @page {
            /* Batas aman kertas A4: atas, kanan, bawah, kiri */
            /* Margin bawah diatur 60px untuk memberikan ruang kosong khusus bagi footer cetak */
            margin: 40px 40px 60px 40px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 0;
            position: relative;
        }

        /* --- WATERMARK BACKGROUND --- */
        body::before {
            content: "";
            position: fixed;
            top: 50%;
            left: 50%;
            width: 350px;
            height: 350px;
            transform: translate(-50%, -50%);
            background-image: url("data:image/png;base64,{{ base64_encode(file_get_contents(public_path('template/tut_wuri.png'))) }}");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            opacity: 0.08;
            z-index: -1;
        }

        /* --- KOP / HEADER SURAT --- */
        .header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .header td {
            vertical-align: middle;
        }

        .logo {
            width: 80px;
        }

        .judul {
            text-align: center;
        }

        .judul h2 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            line-height: 1.4;
        }

        .judul h3 {
            margin-top: 5px;
            margin-bottom: 0;
            font-size: 11px;
            font-weight: normal;
        }

        .garis {
            border-top: 2px solid #000;
            margin-bottom: 25px; /* Jarak otomatis dari kop ke tabel */
        }

        /* --- TABEL UTAMA --- */
        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 35px; /* Jarak otomatis dari tabel ke tanda tangan */
        }

        .table th {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            font-weight: bold;
            background-color: #EAEAEA;
        }

        .table td {
            border: 1px solid #000;
            padding: 5px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        /* --- AREA TANDA TANGAN --- */
        .ttd-container {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid; /* Mencegah tanda tangan terpotong halaman */
        }

        .ttd-container td {
            border: none; 
            vertical-align: top;
            text-align: center;
            font-size: 11px;
            line-height: 1.5;
        }

        .space-ttd {
            height: 100px; /* Ruang kosong untuk tanda tangan fisik */
        }

        /* --- KUNCI DI DASAR MUTLAK HALAMAN A4 --- */
        .cetak-info {
            position: fixed; 
            bottom: -45px; /* Memaksa teks duduk di zona margin paling bawah kertas */
            left: 0;
            right: 0;
            width: 100%;
            text-align: right;
            font-size: 10px;
            color: #555;
            border-top: 1px dashed #ddd; /* Garis batas tipis di atas info cetak */
            padding-top: 4px;
        }
    </style>
</head>

<body>

    <table class="header">
        <tr>
            <td width="15%">
                <img class="logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('template/logo_disdik_pasaman.png'))) }}" height="80px">
            </td>
            
            <td width="70%" class="judul">
                <h2>LAPORAN REKAPITULASI PRESTASI SISWA</h2>
                <h3>
                    Ruang Lingkup Tingkat Lomba :
                    <strong>{{ strtoupper($tingkat_judul) }}</strong>
                </h3>
            </td>

            <td width="15%">
                <img class="logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('template/tut_wuri.png'))) }}">
            </td>
        </tr>
    </table>
    <br><br>

    <div class="garis"></div>

    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="22%">Nama Siswa</th>
                <th width="13%">NISN</th>
                <th width="32%">Nama Lomba / Penghargaan</th>
                <th width="10%">Kategori</th>
                <th width="9%">Tingkat</th>
                <th width="9%">Juara</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan_data as $index => $row)
                <tr>
                    <td class="text-center" width="5%">{{ $index + 1 }}</td>
                    <td class="text-left" width="22%">{{ $row->siswa->nama_siswa ?? '-' }}</td>
                    <td class="text-center" width="13%">{{ $row->siswa->nisn ?? '-' }}</td>
                    <td class="text-left" width="32%">
                        {{ $row->jenis_lomba->nama_jenis_lomba ?? '-' }}
                        @if ($row->keterangan)
                            <br>
                            <small><i>Keterangan: {{ $row->keterangan }}</i></small>
                        @endif
                    </td>
                    <td class="text-center" width="10%">{{ $row->jenis_lomba->keterangan ?? '-' }}</td>
                    <td class="text-center" width="9%">{{ $row->tingkat }}</td>
                    <td class="text-center" width="9%"><strong>{{ $row->peringkat }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:15px;">
                        Tidak ada data prestasi siswa yang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <br><br>

    <table class="ttd-container">
        <tr>
            <td width="45%">
                <br><br>
                Mengetahui,<br>
                <strong>Wali Kelas</strong>
                <div class="space-ttd"></div>
                <br><br>
                <u><strong>....................</strong></u><br>
                NIP. ........................
            </td>
            
            <td width="10%"></td>
            
            <td width="45%">
                Pasaman, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}<br>
                Mengetahui,<br>
                <strong>Kepala Sekolah</strong>
                <div class="space-ttd"></div>
                <br><br>
                <u><strong>....................</strong></u><br>
                NIP. .....................
            </td>
        </tr>
    </table>
   
    {{-- <div class="cetak-info">
        Dicetak pada : {{ \Carbon\Carbon::now()->format('d-m-Y H:i:s') }}
    </div> --}}

</body>

</html>