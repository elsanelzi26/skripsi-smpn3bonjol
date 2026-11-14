@extends('layouts.master')
@section('title', 'Rekap Absensi')

@section('content')

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Rekap Absensi Siswa</h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Rekap Absensi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-title">
                                    <h4>Filter Rekap Absensi</h4>
                                </div>

                                <div class="card-body" style="margin-top:20px">
                                    <form id="formFilterRekap">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Dari Tanggal</label>
                                                    <input type="date" class="form-control" name="tgl_mulai"
                                                        id="tgl_mulai" value="{{ date('Y-m-01') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Sampai Tanggal</label>
                                                    <input type="date" class="form-control" name="tgl_selesai"
                                                        id="tgl_selesai" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Kelas</label>
                                                    <select class="form-control" name="id_kelas" id="id_kelas">
                                                        <option value="">-- Pilih Kelas --</option>
                                                        @foreach ($data_kelas as $item)
                                                            <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Mata Pelajaran</label>
                                                    <select class="form-control" name="id_mapel" id="id_mapel">
                                                        <option value="">-- Semua Mapel --</option>
                                                        @foreach ($data_mapel as $item)
                                                            <option value="{{ $item->id_mapel }}">{{ $item->nama_mapel }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mb-4 mt-2">
                                            <button type="button" class="btn btn-sm btn-primary px-4"
                                                id="btnTampilkanRekap">
                                                <i class="ti-search"></i> Tampilkan Rekap
                                            </button>
                                        </div>
                                    </form>

                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="mb-0">Hasil Rekapitulasi Absensi</h5>

                                        <!-- Tombol cetak mengirimkan parameter filter yang sama ke route PDF -->
                                        <a href="{{ route('absensi.exportPdf', request()->all()) }}"
                                            class="btn btn-danger btn-sm" id="btn-export-pdf">
                                            <i class="ti-printer"></i> Cetak / Export PDF
                                        </a>
                                    </div>


                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th width="5%" rowspan="2" class="align-middle">No</th>
                                                    <th rowspan="2" class="align-middle text-left">Nama Siswa</th>
                                                    <th rowspan="2" class="align-middle">NISN</th>
                                                    <th colspan="4">Total Rekapitulasi</th>
                                                    <th rowspan="2" class="align-middle" width="10%">% Hadir</th>
                                                </tr>
                                                <tr>
                                                    <th width="10%" class="text-success">Hadir</th>
                                                    <th width="10%" class="text-info">Izin</th>
                                                    <th width="10%" class="text-warning">Sakit</th>
                                                    <th width="10%" class="text-danger">Alpha</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableRekapSiswa">
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted">
                                                        Silahkan tentukan filter dan klik Tampilkan Rekap
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#btnTampilkanRekap').click(function() {
                let id_kelas = $('#id_kelas').val();
                let tgl_mulai = $('#tgl_mulai').val();
                let tgl_selesai = $('#tgl_selesai').val();
                let id_mapel = $('#id_mapel').val();

                if (id_kelas == '') {
                    alert('Pilih kelas terlebih dahulu');
                    return;
                }

                $.ajax({
                    url: "{{ route('absensi.getRekap') }}", // Arahkan ke route data rekap Anda
                    type: "GET",
                    data: {
                        id_kelas: id_kelas,
                        tgl_mulai: tgl_mulai,
                        tgl_selesai: tgl_selesai,
                        id_mapel: id_mapel
                    },
                    beforeSend: function() {
                        $('#tableRekapSiswa').html(`
                            <tr>
                                <td colspan="7" class="text-center">
                                    <i class="ti-reload rotate-anime"></i> Memuat data rekap...
                                </td>
                            </tr>
                        `);
                    },
                    success: function(response) {
                        let html = '';

                        if (response.length === 0) {
                            html = `
                                    <tr>
                                        <td colspan="8" class="text-center text-danger"> Data rekap tidak ditemukan untuk filter ini.
                                        </td>
                                    </tr>
                                `;
                        } else {
                            $.each(response, function(index, item) {
                                html += `
                                        <tr>
                                            <td>${index + 1}</td>
                                            <td class="text-left">${item.nama_siswa}</td>
                                            <td>${item.nisn}</td>
                                            <td class="text-success font-weight-bold">${item.total_hadir}</td>
                                            <td class="text-info font-weight-bold">${item.total_izin}</td>
                                            <td class="text-warning font-weight-bold">${item.total_sakit}</td>
                                            <td class="text-danger font-weight-bold">${item.total_alpha}</td>
                                            <td class="text-primary font-weight-bold" style="background-color: #f8f9fa;">
                                                ${item.persentase_hadir}%
                                            </td>
                                        </tr>
                                    `;
                            });
                        }

                        $('#tableRekapSiswa').html(html);
                    },
                    error: function(xhr) {
                        // Jika error, sesuaikan pesan colspan ke 8
                        $('#tableRekapSiswa').html(
                            `<tr><td colspan="8" class="text-center text-danger">Gagal memuat data.</td></tr>`
                        );
                        console.log(xhr.responseText);
                    }
                });
            });

        });
    </script>

    <script>
        $('#btn-export-pdf').click(function(e) {
            e.preventDefault();

            let id_kelas = $('#id_kelas').val();
            let tgl_mulai = $('#tgl_mulai').val();
            let tgl_selesai = $('#tgl_selesai').val();
            let id_mapel = $('#id_mapel').val();

            if (id_kelas == '') {
                alert('Silakan tentukan filter kelas terlebih dahulu sebelum mencetak PDF.');
                return;
            }

            // Menggunakan route name Laravel yang sudah digenerate aman oleh Blade
            let baseUrl = "{{ route('absensi.exportPdf') }}";

            // Gabungkan dengan query string
            let fullUrl = baseUrl +
                `?id_kelas=${id_kelas}&tgl_mulai=${tgl_mulai}&tgl_selesai=${tgl_selesai}&id_mapel=${id_mapel}`;

            // Buka PDF di tab baru
            window.open(fullUrl, '_blank');
        });
    </script>
@endsection
