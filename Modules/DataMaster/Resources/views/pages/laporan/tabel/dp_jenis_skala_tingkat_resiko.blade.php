@extends('datamaster::layouts.master')
@section('title', 'Data Permohonan Berdasarkan Jenis Skala dan Tingkat Resiko')
@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                           @yield('content')
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
            </div>
            <!-- /# row -->
            <section id="main-content">
                <div class="row">
                    <!-- /# column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-title pr">
                                <h4>List @yield('title')</h4>
                            </div>
                            <div class="card-body" style="margin-top:40px">
                                {{-- search pertanggal --}}
                                <form action="" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="form-control" id="skala_usaha" name="skala_usaha" required>
                                                    <option value="">--PILIH JENIS SKALA--</option>
                                                    <option value="Mikro">Mikro</option>
                                                    <option value="Makro">Makro</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="form-control" id="tingkat_resiko" name="tingkat_resiko" required>
                                                    <option value="">--PILIH TINGKAT RESIKO--</option>
                                                    <option value="Rendah">Rendah</option>
                                                    <option value="Menengah">Menengah</option>
                                                    <option value="Tinggi">Tinggi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary btn-sm">Submit</button>
                
                                            <a href="" onclick="this.href='/cetak-data-penjualan/' + document.getElementById('tanggal_awal').value + '/' + document.getElementById('tanggal_akhir').value" target="_blank" class="btn btn-danger btn-sm"><i class="ti-printer"></i></a>
                                        </div>
                                      
                                    </div>
                                </form>
                                {{-- endsearch pertanggal --}}
                                <div class="table-responsive">
                                    <table class="table student-data-table m-t-20" id="ajax-crud-datatable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pemohon</th>
                                                <th>NIK</th>
                                                <th>NPWP</th>
                                                <th>Alamat</th>
                                                <th>Jenis Skala</th>
                                                <th>Tingkat Resiko</th>
                                                <th>Status Permohonan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /# column -->
                </div>
                <!-- /# row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer">
                            <p>2018 © Admin Board. - <a href="#">example.com</a></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#ajax-crud-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('datapermohonanjenisskala_tingkatresiko.index') }}",
            columns: [
                { 
                   // mengambil & menampilkan kolom sesuai tabel database
                   render: function (data, type, row, meta) {
                   return meta.row + meta.settings._iDisplayStart + 1;
                   },
                },
                { data: 'nama_pemohon', name: 'nama_pemohon'},
                { data: 'nik', name: 'nik'},
                { data: 'npwp', name: 'npwp'},
                { data: 'alamat_pemohon', name: 'alamat_pemohon'},
                { data: 'skala_usaha', name: 'skala_usaha'},
                { data: 'tingkat_resiko', name: 'tingkat_resiko'},
                {
                    "render": function ( data, type, row ) {
                        if(row.status_permohonan == 1){
                            return 'Diajukan';
                        } else if(row.status_permohonan == 2){
                            return 'Divalidasi Admin';
                        } else if(row.status_permohonan == 3){
                            return 'Ditolak Admin';
                        }else if(row.status_permohonan == 4){
                            return 'Diteruskan';
                        }else if(row.status_permohonan == 5){
                            return 'Diterima Kasie';
                        } else if(row.status_permohonan == 6){
                            return 'Ditolak Kasie';
                        }else if(row.status_permohonan == 7){
                            return 'Diterima Kabid';
                        }else if(row.status_permohonan == 8){
                            return 'Ditolak Kabid';
                        }else if(row.tanggal_terbit !== ''){
                            return 'Diterbitkan';
                        }else if(row.status_permohonan == 9){
                            return 'Diterima Kadis';
                        }else if(row.status_permohonan == 10){
                            return 'Ditolak Kadis';
                        }else if(row.status_permohonan == 12){
                            return 'Tidak Diterbitkan';
                        }
                    }
                },
                {
                    "render": function ( data, type, row ) {
                            return `<a data-toggle="modal" data-target="#validasipermohonan" id="validasipermohonanData" data-id="`+row.id_data_permohonan+`" data-nama="`+row.nama_pemohon+`" class="btn btn-success mr-2" style="color:white; float:left">Detail</a>`
                    }
                },
            ],
        });

        $('#jenis_skala').select2({
            allowClear : true,
        });
        $('#tingkat_resiko').select2({
            allowClear : true,
        });
      
    });
</script>

@endsection
