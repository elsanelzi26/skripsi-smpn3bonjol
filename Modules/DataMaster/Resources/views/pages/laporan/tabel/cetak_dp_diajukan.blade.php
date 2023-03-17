<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Cetak Laporan Permohonan Diajukan Per Tanggal</title>
</head>

<body>
    <table class="table table-bordered" width="100%" cellspacing="0" border="1" style="text-align: center;">
        <thead style="background-color:grey">
            <tr>
                <tr>
                    <th>No</th>
                    <th>Nama Pemohon</th>
                    <th>NIK</th>
                    <th>NPWP</th>
                    <th>Alamat</th>
                    <th>Tanggal Permohonan</th>
                    <th>Status Permohonan</th>
                </tr>
            </tr>
        </thead>
        <tbody>
            @foreach ($permohonandiajukanpertanggal as $i=>$d)
                <tr style="font-size:15px;">
                    <td>{{$i+1}}</td>
                    <td>{{$d->nama_pemohon}}</td>
                    <td>{{$d->nik}}</td>
                    <td>{{$d->npwp}}</td>
                    <td>{{$d->alamat_pemohon}}</td>
                    <td>{{$d->tanggal_pemohon}}</td>
                    <td>{{$d->status_permohonan}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
   
    <table width="100%" style="margin-top:10px;">
        <tr>
            <td width="70%"></td>
            <td width="30%">
                <h5 style="font-size:15px;" class="mb-5">Payakumbuh, <?= date('d - m - Y', time()); ?><br>Penanggung Jawab</h5>
                <br><br><br>
                <p style="margin-top: -10px;">(.....................................)</p>
            </td>
        </tr>
    </table>

    <script>
        window.print();
    </script>

</body>

</html>