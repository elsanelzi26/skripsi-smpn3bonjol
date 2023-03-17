@extends('datamaster::layouts.master')
@section('title', 'Permohonan')
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
                                <div class="table-responsive">
                                    <table class="table student-data-table m-t-20" id="ajax-crud-datatable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pemohon</th>
                                                <th>NIK</th>
                                                <th>NPWP</th>
                                                <th>Alamat</th>
                                                <th>Status Pemohon</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                {{-- Modal Disposisi --}}
                                <div class="modal fade" id="disposisipermohonan" tabindex="-1" aria-labelledby="disposisipermohonanLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="disposisipermohonanLabel">Disposisi Permohonan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="{{ route('proses_disposisi_permohonan_kadis') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body" style="max-height: calc(100vh - 210px);  overflow-y: auto;">
                                                    <div class="form-group row">
                                                        <input type="hidden" name="id_data_permohonan" id="id_data_permohonan" readonly>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-12 col-form-label" for="status_permohonan">STATUS PERMOHONAN <span class="text-danger">*</span></label>
                                                        <div class="col-lg-12">
                                                            <select class="@error('status_permohonan') is-invalid @enderror input-lg" id="status_permohonan" name="status_permohonan" value="{{old('status_permohonan')}}" style="width:100%" required>
                                                                <option value="">--PILIH STATUS PERMOHONAN--</option>
                                                                <option value="9">Diterima</option>
                                                                <option value="10">Ditolak</option>
                                                            </select>
                                                            <div class="text-danger">
                                                                @error('status_permohonan')
                                                                {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" id="keterangan_tolak_permohonan">
                                                        <label class="col-lg-12 col-form-label" for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                                        <div class="col-lg-12">
                                                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" cols="30" rows="10">{{ old('keterangan') }}</textarea>
                                                        </div>
                                                        @error('keterangan')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group row" id="keterangan_isi_disposisi">
                                                        <label class="col-lg-12 col-form-label" for="isi_disposisi">Isi Disposisi <span class="text-danger">*</span></label>
                                                        <div class="col-lg-12">
                                                            <textarea name="isi_disposisi" id="isi_disposisi" class="form-control @error('isi_disposisi') is-invalid @enderror" cols="30" rows="10">{{ old('isi_disposisi') }}</textarea>
                                                        </div>
                                                        @error('isi_disposisi')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Modal Disposisi --}}
                                {{-- Modal Terbitkan --}}
                                   <div class="modal fade" id="terbitkanpermohonan" tabindex="-1" aria-labelledby="terbitkanpermohonanLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="terbitkanpermohonanLabel">Terbitkan Permohonan</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="{{ route('proses_terbitkan_permohonan') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body" style="max-height: calc(100vh - 210px);  overflow-y: auto;">
                                                    <div class="form-group row">
                                                        <input type="hidden" name="id_data_permohonan" id="id_data_permohonan_penerbitan" readonly>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-12 col-form-label" for="status_permohonan">STATUS PERMOHONAN <span class="text-danger">*</span></label>
                                                        <div class="col-lg-12">
                                                            <select class="@error('status_permohonan') is-invalid @enderror input-lg" id="status_permohonan_penerbitan" name="status_permohonan" value="{{old('status_permohonan')}}" style="width:100%" required>
                                                                <option value="">--PILIH STATUS PERMOHONAN--</option>
                                                                <option value="11">Sesuai</option>
                                                                <option value="12">Ditolak</option>
                                                            </select>
                                                            <div class="text-danger">
                                                                @error('status_permohonan')
                                                                {{ $message }}
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row" id="keterangan_tolak_permohonan_penerbitan">
                                                        <label class="col-lg-12 col-form-label" for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                                        <div class="col-lg-12">
                                                            <textarea name="keterangan" id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" cols="30" rows="10">{{ old('keterangan') }}</textarea>
                                                        </div>
                                                        @error('keterangan')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Modal Terbitkan --}}
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
            ajax: "{{ route('disposisipermohonankadis.index') }}",
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
                        }else if(row.status_permohonan == 11){
                            return 'Sesuai';
                        }else if(row.status_permohonan == 12){
                            return 'Tidak Diterbitkan';
                        }
                    }
                },
                {
                    "render": function ( data, type, row ) {
                        var status_permohonan = row.status_permohonan;
                        if(status_permohonan== '7'){
                            return `<a data-toggle="modal" data-target="#validasipermohonan" id="validasipermohonanData" data-id="`+row.id_data_permohonan+`" data-nama="`+row.nama_pemohon+`" class="btn btn-success mr-2" style="color:white; float:left">Detail</a><a data-toggle="modal" data-target="#disposisipermohonan" id="disposisipermohonanData" data-id="`+row.id_data_permohonan+`" data-nama="`+row.nama_pemohon+`" class="disposisikasieButton btn btn-danger mr-2" style="color:white; float:left">Disposisi Permohonan</a>`
                        }else if(row.tanggal_terbit == ''){
                            return `<a data-toggle="modal" data-target="#validasipermohonan" id="validasipermohonanData" data-id="`+row.id_data_permohonan+`" data-nama="`+row.nama_pemohon+`" class="btn btn-success mr-2" style="color:white; float:left">Detail</a><a data-toggle="modal" data-target="#terbitkanpermohonan" id="terbitkanpermohonanData" data-id="`+row.id_data_permohonan+`" data-nama="`+row.nama_pemohon+`" class="terbitkanpermohonanButton btn btn-danger mr-2" style="color:white; float:left">Terbitkan</a>`
                        } else {
                            return `<a data-toggle="modal" data-target="#validasipermohonan" id="validasipermohonanData" data-id="`+row.id_data_permohonan+`" data-nama="`+row.nama_pemohon+`" class="btn btn-success mr-2" style="color:white; float:left">Detail</a>`
                        }
                    }
                },
            ],
        });

        $('body').on('click','.terbitkanpermohonanButton', function(){
            var id = $(this).data('id');
            $('#id_data_permohonan_penerbitan').val(id);
            $('#keterangan_tolak_permohonan_penerbitan').prop('hidden', true);
        });

        $('body').on('click','.disposisikasieButton', function(){
            var id = $(this).data('id');
            $('#id_data_permohonan').val(id);
            $('#keterangan_tolak_permohonan').prop('hidden', true);
            $('#keterangan_isi_disposisi').prop('hidden', true);
        });

        $('#status_permohonan').select2({
            allowClear : true,
        });

        $('#status_permohonan_penerbitan').select2({
            allowClear : true,
        });

        $("#status_permohonan_penerbitan").change(function() {
            //  console.log($("#status_permohonan option:selected").val());
            //  // Diterima 
             if ($("#status_permohonan_penerbitan option:selected").val() == '12') {
                 $('#keterangan_tolak_permohonan_penerbitan').prop('hidden', false);
             } else if($("#status_permohonan_penerbitan option:selected").val() == '11') {
                 $('#keterangan_tolak_permohonan_penerbitan').prop('hidden', true);
             }
         });

        $("#status_permohonan").change(function() {
            //  console.log($("#status_permohonan option:selected").val());
            //  // Diterima 
             if ($("#status_permohonan option:selected").val() == '10') {
                 $('#keterangan_tolak_permohonan').prop('hidden', false);
                 $('#keterangan_isi_disposisi').prop('hidden', true);
             } else if($("#status_permohonan option:selected").val() == '9') {
                 $('#keterangan_tolak_permohonan').prop('hidden', true);
                 $('#keterangan_isi_disposisi').prop('hidden', false);
             }
         });

         $('body').on('click', '.terbitkan', function () {
            var id = $(this).data('id');
            console.log(id);
            var nama = $(this).data('nama');
            Swal.fire({
                title: 'Yakin?',
                text: "Terbitkan Data Permohonan Atas Nama " + nama + "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type:"POST",
                        url: "{{ url('/datamaster/terbitkan_permohonan/prosesterbitkan') }}",
                        data: { 
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        dataType: 'json',
                        success: function(res){
                            Swal.fire("Sukses!", res.success, "success");
                            var oTable = $('#ajax-crud-datatable').dataTable();
                            oTable.fnDraw(false);
                        },
                        error: function(error){
                        console.log(error);
                        }
                    });
                }
            })
        });
    });


    
</script>

@include('sweetalert::alert')
@endsection