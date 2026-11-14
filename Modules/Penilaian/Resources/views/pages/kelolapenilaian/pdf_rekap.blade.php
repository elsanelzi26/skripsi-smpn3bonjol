<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">

    <style>
        @page {
            margin: 0;
        }
         body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #000;
            position: relative;
        }

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

        .header {
            width: 100%;
            border-collapse: collapse;
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

        .judul h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .judul h2 {
            margin-top: 8px;
            font-size: 12px;
            font-weight: normal;
        }

        .garis {
            border-top: 2px solid #000;
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
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

        .footer {
            margin-top: 10px;
            text-align: right;
            font-size: 10px;
        }
    </style>
    <title>Laporan Rekap Nilai</title>
    <style>
        body { font-family: helvetica, sans-serif; font-size: 11px; color: #333; }
        .table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .table th { background-color: #f2f2f2; font-weight: bold; text-align: center; border: 1px solid #333; padding: 6px; }
        .table td { border: 1px solid #333; padding: 6px; text-align: center; }
        .text-left { text-align: left; }
        .header { text-align: center; line-height: 1.5; margin-bottom: 20px; }
    </style>
</head>
<body>
    <table class="header">
        <tr>
             <td width="15%">
                <img class="logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('template/logo_disdik_pasaman.png'))) }}" height="80px">
            </td>
            
            <td width="70%" class="judul">
                <h2>LAPORAN REKAPITULASI NILAI SISWA</h2>
            </td>

            <td width="15%">
                <img class="logo" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('template/tut_wuri.png'))) }}">
            </td>
        </tr>
    </table>

    <div class="garis"></div>

    <div class="header">
      
        <table width="100%" style="margin-top: 10px; border: none;">
            <tr>
                <td width="15%" style="border:none; text-align:left;"><strong>Kelas</strong></td>
                <td width="35%" style="border:none; text-align:left;">: {{ $kelas->nama_kelas }}</td>
                <td width="20%" style="border:none; text-align:left;"><strong>Mata Pelajaran</strong></td>
                <td width="30%" style="border:none; text-align:left;">: {{ $mapel->nama_mapel }}</td>
            </tr>
            <tr>
                <td style="border:none; text-align:left;"><strong>Tahun Ajaran</strong></td>
                <td style="border:none; text-align:left;">: {{ $ta->tahun_ajaran }}</td>
                <td style="border:none; text-align:left;"><strong>Semester</strong></td>
                <td style="border:none; text-align:left;">: {{ $ta->semester }}</td>
            </tr>
        </table>
    </div>

    <br><br>

    <table class="table" cellpadding="4">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%" class="text-left">Nama Siswa</th>
                <th width="12%">NISN</th>
                <th width="8%">Tugas</th>
                <th width="8%">UH</th>
                <th width="8%">UTS</th>
                <th width="8%">UAS</th>
                <th width="10%">Rata-rata</th>
                <th width="6%">Huruf</th>
                <th width="10%">Predikat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap_nilai as $index => $row)
            <tr>
                <td width="5%">{{ $index + 1 }}</td>
                <td width="25%" class="text-left">{{ $row['nama_siswa'] }}</td>
                <td width="12%">{{ $row['nisn'] }}</td>
                <td width="8%">{{ $row['nilai_tugas'] }}</td>
                <td width="8%">{{ $row['nilai_uh'] }}</td>
                <td width="8%">{{ $row['nilai_uts'] }}</td>
                <td width="8%">{{ $row['nilai_uas'] }}</td>
                <td width="10%"><strong>{{ $row['rata_rata'] }}</strong></td>
                <td width="6%">{{ $row['huruf'] }}</td>
                <td width="10%">{{ $row['predikat'] }}</td>
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