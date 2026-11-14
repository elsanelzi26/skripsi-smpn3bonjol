<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Rekap Perangkingan Nilai</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #000;
        }

        .header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .judul {
            text-align: center;
        }

        .judul h2 {
            font-size: 16px;
            margin: 0;
            font-weight: bold;
        }

        .logo {
            width: 60px;
        }

        .garis {
            border-top: 2px solid #000;
            margin-top: 5px;
            margin-bottom: 15px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-table td {
            font-size: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: #EAEAEA;
            font-weight: bold;
            text-align: center;
            border: 1px solid #000;
            padding: 5px;
        }

        .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }

        .text-left {
            text-align: left;
        }

        .bg-warning {
            background-color: #FFF2CC;
            /* Pengganti table-warning di bootstrap */
            font-weight: bold;
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
    </style>
</head>

<body>

    <table class="header">
        <tr>
             <td width="15%">
                <img class="logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('template/logo_disdik_pasaman.png'))) }}" height="80px">
            </td>
            
            <td width="70%" class="judul">
                <h2>LAPORAN REKAPITULASI & PERANGKINGAN NILAI SISWA</h2>
            </td>

            <td width="15%">
                <img class="logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('template/tut_wuri.png'))) }}">
            </td>
        </tr>
    </table>

    <div class="garis"></div>

    <table class="info-table" width="100%">
        <tr>
            <td width="15%"><strong>Kelas</strong></td>
            <td width="35%">: {{ $kelas->nama_kelas }}</td>
            <td width="15%"><strong>Tahun Ajaran</strong></td>
            <td width="35%">: {{ $ta->tahun_ajaran }}</td>
        </tr>
        <tr>
            <td><strong>Semester</strong></td>
            <td>: {{ $ta->semester }}</td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table class="table" cellpadding="3">
        <thead>
            <tr>
                <th width="3%" style="font-size: 6px;">No</th>
                <th width="9%" style="font-size: 6px;">NISN</th>
                <th width="15%" style="font-size: 6px;">Nama Siswa</th>
                @foreach ($data_mapel as $mapel)
                    <th width="6%" style="font-size: 6px;">{{ $mapel->nama_mapel }}</th>
                @endforeach
                <th width="6%" style="font-size: 6px;">Rata-rata</th>
                <th width="6%" style="font-size: 6px;">Ranking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap_nilai as $index => $row)
                <tr>
                    <td width="3%">{{ $index + 1 }}</td>
                    <td width="9%">{{ $row['nisn'] }}</td>
                    <td width="15%" class="text-left"><strong>{{ $row['nama_siswa'] }}</strong></td>

                    @foreach ($data_mapel as $mapel)
                        <td width="6%">{{ $row['nilai_mapel'][$mapel->id_mapel] ?? 0 }}</td>
                    @endforeach

                    <td width="6%" class="bg-warning">{{ $row['rata_rata'] }}</td>

                    <td width="6%"><strong>{{ $index + 1 }}</strong></td>
                </tr>
            @endforeach
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

</body>

</html>
