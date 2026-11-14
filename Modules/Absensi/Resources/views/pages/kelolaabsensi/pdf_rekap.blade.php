<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekapitulasi Absensi Siswa</title>
    <style>
        @page {
            margin: 15px; /* Memberikan ruang agar margin TCPDF sinkron */
        }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #222;
            position: relative;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 70px;
        }

        .judul {
            text-align: center;
        }

        .judul h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .judul h2 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .garis {
            border-top: 2px solid #000;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            border: none;
            text-align: left;
            padding: 2px 0;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
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
            text-align: center;
            vertical-align: middle;
        }

        .text-left {
            text-align: left;
        }

        /* --- AREA TANDA TANGAN --- */
        .ttd-container {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .ttd-container td {
            border: none; 
            vertical-align: top;
            text-align: center;
            font-size: 11px;
            line-height: 1.5;
        }

        .space-ttd {
            height: 60px; /* Jarak ruang tanda tangan fisik */
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td width="15%" align="left">
                <img class="logo" src="{{ asset('template/logo_disdik_pasaman.png')}}">
            </td>
            
            <td width="70%" class="judul">
                <h2>LAPORAN REKAPITULASI ABSENSI SISWA</h2>
            </td>

            <td width="15%" align="right">
                <img class="logo" src="{{ asset('template/tut_wuri.png') }}">
            </td>
        </tr>
    </table>
    <br><br>

    <div class="garis"></div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Kelas</strong></td>
            <td width="35%">: {{ $kelas->nama_kelas ?? '-' }}</td>
            <td width="18%"><strong>Mata Pelajaran</strong></td>
            <td width="32%">: {{ $mapel ? $mapel->nama_mapel : 'Semua Mata Pelajaran' }}</td>
        </tr>
        <tr>
            <td width="15%"><strong>Tahun Ajaran</strong></td>
            <td width="35%">: {{ $ta->tahun_ajaran ?? '-' }} ({{ $ta->semester ?? '-' }})</td>
            <td width="18%"><strong>Periode Tanggal</strong></td>
            <td width="32%">: {{ $tgl_mulai ? \Carbon\Carbon::parse($tgl_mulai)->format('d/m/Y') : 'Awal' }} s/d {{ $tgl_selesai ? \Carbon\Carbon::parse($tgl_selesai)->format('d/m/Y') : 'Akhir' }}</td>
        </tr>
    </table>
      <br><br>

    <table class="table" cellpadding="4">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%" class="text-left">Nama Siswa</th>
                <th width="15%">NISN</th>
                <th width="8%">Hadir</th>
                <th width="8%">Izin</th>
                <th width="8%">Sakit</th>
                <th width="8%">Alpha</th>
                <th width="18%">Persentase Hadir</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekap as $index => $row)
            <tr>
                <td width="5%">{{ $index + 1 }}</td>
                <td width="30%" class="text-left">{{ $row->nama_siswa }}</td>
                <td width="15%">{{ $row->nisn ?? '-' }}</td>
                <td width="8%">{{ $row->total_hadir }}</td>
                <td width="8%">{{ $row->total_izin }}</td>
                <td width="8%">{{ $row->total_sakit }}</td>
                <td width="8%">{{ $row->total_alpha }}</td>
                <td width="18%"><strong>{{ $row->persentase_hadir }}%</strong></td>
            </tr>
            @empty
            <tr>
                <td colspan="8">Tidak ada data rekapitulasi absensi pada parameter ini.</td>
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
                <u><strong>................................................</strong></u><br>
                NIP. ........................................
            </td>
            
            <td width="10%"></td>
            
            <td width="45%">
                Pasaman, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}<br>
                Mengetahui,<br>
                <strong>Kepala Sekolah</strong>
                <div class="space-ttd"></div>
                  <br><br>
                <u><strong>................................................</strong></u><br>
                NIP. ........................................
            </td>
        </tr>
    </table>

</body>
</html>