@extends('datamaster::layouts.master')
@section('title', 'Data Permohonan Diajukan Per Tanggal')
@section('content')
<style>
.modal-detail-pengajuan{
     width: 1000px;
     margin: 0 auto;
}
</style>
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
                                {{-- search per bulan --}}
                                {{-- @php
                                    date_default_timezone_set('Asia/Jakarta');
                                    $tgl = date('m');
                                @endphp
                                <form action="" method="POST">
                                    @csrf
                                    <div class="row float-center">

                                        <select class="form-control" name="periode" aria-label="Default select example">
                                            @php
                                                $bulan = ['Januari' => '1', 'Februari' => '2', 'Maret' => '3', 'April' => '4', 'Mei' => '5', 'Juni' => '6', 'Juli' => '7', 'Agustus' => '8', 'September' => '9', 'Oktober' => '10', 'November' => '11', 'Desember' => '12'];
                                            @endphp
                                            <option value="{{ $tgl }}">Pilih Bulan</option>
                                            @foreach ($bulan as $b => $value_bulan)
                                                <option value="{{ $value_bulan }}">{{ $b }} </option>
                                            @endforeach

                                        </select>
                                        <button type="submit" class="btn btn-primary my-2">Cari</button>
                                        @if (isset($periode))
                                            <a href="" target="_blank"
                                                class="btn btn-danger mt-2 ml-1 my-2">
                                                Print</a>
                                        @else
                                            <a href="" target="_blank" class="btn btn-danger mt-2 ml-1 my-2">
                                                Print</a>
                                        @endif
                                    </div>
                                </form> --}}
                                {{-- endsearch perbulan --}}
                                {{-- search pertanggal --}}
                                <form action="" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="date" class="form-control searchTanggalAwal" name="tanggal_awal" id="tanggal_awal" placeholder="Enter Tanggal Awal"  required>&nbsp;
                                            </div>
                                        </div>
                
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="date" class="form-control searchTanggalAkhir" name="tanggal_akhir" id="tanggal_akhir" placeholder="Enter Tanggal Akhir"  required>&nbsp;
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" name="filter" id="filter" class="btn btn-primary btn-sm">Filter</button>
                                            <button type="button" name="reset" id="reset" class="btn btn-success btn-sm">Reset</button>
                                          
                                            <a class="btn btn-danger btn-sm" href="{{route('cetak_permohonan_diajukan_pertanggal')}}" target="_blank"><i class="fa fa-print"></i> Cetak PDF</a>
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
                 {{-- <!-- Modal -->
                 <div class="modal fade modal-detail-pengajuan" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form action="javascript:void(0)" id="jenis_kelaminForm" name="jenis_kelaminForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <input type="hidden" name="id_jenis_kelamin" id="id_jenis_kelamin">
                                        <label class="col-lg-4 col-form-label" for="nama_jenis_kelamin">Nama Jenis Kelamin <span class="text-danger">*</span></label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control @error('nama_jenis_kelamin') is-invalid @enderror" id="nama_jenis_kelamin" name="nama_jenis_kelamin" placeholder="Masukan Nama Jenis Kelamin.." value="{{ old('nama_jenis_kelamin') }}" autofocus required>
                                        </div>
                                        @error('nama_jenis_kelamin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="btn-save">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                End Modal --}}
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
        fill_datatable();
        function fill_datatable(tanggal_awal = '', tanggal_akhir = ''){
            var dataTable =  $('#ajax-crud-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('datapermohonandiajukan.index') }}",
                    
                    data: {tanggal_awal:tanggal_awal, tanggal_akhir:tanggal_akhir}
                },
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
                            return `<a href="{{url('/datamaster/permohonandiajukan/detailshowdiajukan/`+row.id_data_permohonan+`')}}"><button type="button" class="btn btn-success mr-2"><i class="ti-eye"></i></button></a>`
                            // return `<a href="#exampleModal" data-target="#exampleModal" data-toggle="modal" class="btn btn-success detailButton mr-2" data-id="`+row.id_data_permohonan+`" data-nama="`+row.nama_pemohon+`"><i class="ti-eye"></a>`
                        }
                    },
                ],
            });
        }
      
        $('#filter').click(function(){
            var tanggal_awal = $('#tanggal_awal').val();
            var tanggal_akhir = $('#tanggal_akhir').val();

            if(tanggal_awal != '' && tanggal_akhir != ''){
                $('#ajax-crud-datatable').DataTable().destroy();
                fill_datatable(tanggal_awal, tanggal_akhir);
            }else {
                alert('Select Filter Option');
            }
        });

        $('#reset').click(function(){
            $('#tanggal_awal').val('');
            $('#tanggal_akhir').val('');
            $('#ajax-crud-datatable').DataTable().destroy();
            fill_datatable();
        });
    });
</script>

@endsection
