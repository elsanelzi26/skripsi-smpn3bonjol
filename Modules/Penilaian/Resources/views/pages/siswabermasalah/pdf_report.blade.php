<!DOCTYPE html>
<html>

<head>
    <title>Laporan Rekap Siswa Bermasalah</title>
    <style>
        body {
            font-family: helvetica, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            border: 1px solid #333;
            padding: 6px;
        }

        .table td {
            border: 1px solid #333;
            padding: 6px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .header {
            text-align: center;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .status-badge {
            font-weight: bold;
            color: #fff;
            padding: 2px 4px;
            text-align: center;
        }

        .ttd-container {
            width: 100%;
            margin-top: 40px;
        }

        .ttd-table {
            width: 100%;
            border: none;
        }

        .ttd-table td {
            border: none;
            text-align: center;
            width: 50%;
        }
    </style>
</head>

<body>

    <table class="header">
        <tr>
            <td width="15%">
                <img class="logo"
                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('template/logo_disdik_pasaman.png'))) }}"
                    height="80px">
            </td>

            <td width="70%" class="judul">
                <h2 style="font-size: 14px; margin: 0; font-weight: bold; text-transform: uppercase;">LAPORAN DATA REKAP
                    BIMBINGAN KONSELING (SISWA BERMASALAH)</h2>
                <h3 style="font-size: 12px; margin: 0; font-weight: normal;">SMP NEGERI 3 BONJOL</h3>
                <p style="margin: 4px 0;">
                    <strong>Kelas:</strong> {{ $kelas->nama_kelas }} |
                    <strong>Periode Tanggal:</strong> {{ date('d-m-Y', strtotime($tgl_mulai)) }} s/d
                    {{ date('d-m-Y', strtotime($tgl_selesai)) }}
                </p>
            </td>

            <td width="15%">
                <img class="logo"
                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('template/tut_wuri.png'))) }}">
            </td>
        </tr>
    </table>

    <hr style="border-top: 2px solid #000; margin-top: 10px;">

    <table class="table" cellpadding="5">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Siswa</th>
                <th width="12%" class="text-center">NISN</th>
                <th width="33%">Deskripsi Catatan Indikator Masalah</th>
                <th width="13%" class="text-center">Status BK</th>
                <th width="17%">Tindak Lanjut / Hasil</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekap_masalah as $index => $row)
                <tr>
                    <td class="text-center" width="5%">{{ $index + 1 }}</td>
                    <td width="20%"><strong>{{ $row['nama_siswa'] }}</strong></td>
                    <td class="text-center" width="12%">{{ $row['nisn'] }}</td>
                    <td width="33%">
                        @foreach ($row['alasan'] as $alasan)
                            • {{ $alasan }}<br>
                        @endforeach
                    </td>
                    <td class="text-center" width="13%">
                        <strong>
                            @if ($row['status_bk'] == '1')
                                Belum Diproses
                            @elseif($row['status_bk'] == '2')
                                Dipanggil BK
                            @elseif($row['status_bk'] == '3i')
                                Selesai
                            @else
                                {{ $row['status_bk'] }}
                            @endif
                        </strong>
                    </td>
                    <td width="17%">
                        {{ $row['catatan_tindak_lanjut'] ?: '-' }}
                    </td>
                </tr>
            @endforeach

            @if (count($rekap_masalah) == 0)
                <tr>
                    <td colspan="6" class="text-center" style="color: green; font-weight: bold;">
                        🎉 Luar Biasa! Tidak ada data siswa bermasalah pada kelas dan periode ini.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <br><br>

    <div class="ttd-container">
        <table class="ttd-table">
            <tr>
                <td>
                    Mengetahui,<br>
                    Kepala Sekolah SMPN 3 Bonjol<br><br><br><br>
                    ( _______________________ )<br>
                    NIP. ........................................
                </td>
                <td>
                    Bonjol, {{ date('d-m-Y') }}<br>
                    Guru Bimbingan Konseling<br><br><br><br>
                    ( _______________________ )<br>
                    NIP. ........................................
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
