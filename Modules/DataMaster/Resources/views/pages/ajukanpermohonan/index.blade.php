@extends('datamaster::layouts.master')
@section('title', 'Ajukan Permohonan')
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
                               <a href="{{ route('ajukanpermohonan.create') }}" class="btn btn-primary mb-5 mt-3">Buat Permohonan</a>

                                <div class="table-responsive">
                                    <table class="table student-data-table m-t-20" id="ajax-crud-datatable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pemohon</th>
                                                <th>NIK</th>
                                                <th>NPWP</th>
                                                <th>Alamat</th>
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
            ajax: "{{ route('ajukanpermohonan.index') }}",
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
            ],
        });
    });
</script>

@include('sweetalert::alert')
@endsection