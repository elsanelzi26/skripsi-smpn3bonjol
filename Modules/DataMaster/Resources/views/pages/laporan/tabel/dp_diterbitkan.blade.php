@extends('datamaster::layouts.master')
@section('title', 'Data Permohonan Diterbitkan Per Tanggal')
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
                                                <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal" placeholder="Enter Tanggal Awal"  required>&nbsp;
                                            </div>
                                        </div>
                
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" placeholder="Enter Tanggal Akhir"  required>&nbsp;
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary btn-sm">Submit</button>
                
                                            <a href="" onclick="this.href='/cetak-data-penjualan/' + document.getElementById('tanggal_awal').value + '/' + document.getElementById('tanggal_akhir').value" target="_blank" class="btn btn-danger btn-sm"><i class="ti-printer"></i></a>
                                        </div>
                                        <div class="col-md-3">
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
                                                <th>Tanggal Permohonan</th>
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
            ajax: "{{ route('datapermohonanditerbitkan.index') }}",
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
                // { data: 'tanggal_pemohon', name: 'tanggal_pemohon'},
                {
                    "render": function ( data, type, row ) {
                        var tanggal_permohonan = row.tanggal_pemohon;
                        var dateAr1 = tanggal_permohonan.split('-');
                        // console.log(dateAr1);
                        var tgl_permohonan = dateAr1[0] + '-' + dateAr1[1] + '-' + dateAr1[2].slice(-2); 
                        return tgl_permohonan;
                    }
                },
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
    });
</script>

@endsection
