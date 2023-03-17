@extends('datamaster::layouts.master')
@section('title', 'Data Permohonan Berdasarkan Kecamatan dan Kelurahan')
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
                                                <select class="form-control" id="kecamatan" name="kecamatan" required>
                                                    <option value="">--PILIH KECAMATAN--</option>
                                                    @foreach($kecamatans as $kecamatan)
                                                    <option value="{{ $kecamatan->id }}">{{ $kecamatan->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select class="form-control" id="kelurahan" name="kelurahan" required>
                                                    <option value="">--PILIH KELURAHAN--</option>
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
                                                <th>Kecamatan</th>
                                                <th>Kelurahan</th>
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
            ajax: "{{ route('datapermohonankecamatan_kelurahan.index') }}",
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
                { data: 'kecamatan', name: 'kecamatan'},
                { data: 'kelurahan', name: 'kelurahan'},
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

        $('#kecamatan').select2({
            allowClear : true,
        });
        $('#kelurahan').select2({
            allowClear : true,
        });

        $('#kecamatan').on('change', function(){
            let id_kecamatan = $('#kecamatan').val();
            // console.log(id_kecamatan);
            $.ajax({
                type : 'POST',
                url : '{{ route('getkelurahan') }}',
                data : {
                    "_token": "{{ csrf_token() }}",
                    "id_kecamatan": id_kecamatan,
                },
                cache : false,

                success : function(response){
                    $('#kelurahan').html(response);
                },

                error : function(error){
                    console.log('error: ',error);
                }

            });
        });
      
    });
</script>

@endsection
