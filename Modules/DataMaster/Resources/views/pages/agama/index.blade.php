@extends('datamaster::layouts.master')
@section('title', 'Agama')
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
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mt-3 mb-5" data-toggle="modal" data-target="#exampleModal" id="addagama">
                                    Tambah
                                </button>

                                <div class="table-responsive">
                                    <table class="table student-data-table m-t-20" id="ajax-crud-datatable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Jenis Kelamin</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>

                                        <form action="javascript:void(0)" id="agamaForm" name="agamaForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <input type="hidden" name="id_agama" id="id_agama">
                                                    <label class="col-lg-4 col-form-label" for="nama_agama">Nama Agama <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control @error('nama_agama') is-invalid @enderror" id="nama_agama" name="nama_agama" placeholder="Masukan Nama Agama.." value="{{ old('nama_agama') }}" autofocus required>
                                                    </div>
                                                    @error('nama_agama')
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
            ajax: "{{ route('agama.index') }}",
            columns: [
                { 
                   // mengambil & menampilkan kolom sesuai tabel database
                   render: function (data, type, row, meta) {
                   return meta.row + meta.settings._iDisplayStart + 1;
                   },
                },
                { data: 'nama_agama', 
                  name: 'nama_agama',
                },
                {
                    "render": function ( data, type, row ) {
                        // console.log(data);
                        return `<a href="#exampleModal" data-target="#exampleModal" data-toggle="modal" class="btn btn-success editButton mr-2" data-id="`+row.id_agama+`">Edit</a><a href="javascript:void(0)" data-id="`+row.id_agama+`" data-nama="`+row.nama_agama+`" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">Delete</a>`
                    }
                },
            ],
        });


        $('#addagama').click(function(){
            $('#agamaForm').trigger("reset");
            $('#exampleModalLabel').html('Create Data Agama');
            $('#btn-save').html('Save');
            var id = $('#id_agama').val('');
        });


        $('body').on('click', '.delete', function () {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            Swal.fire({
                title: 'Yakin?',
                text: "Kamu Akan Menghapus Data Agama dengan Nama " + nama + "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type:"POST",
                        url: "{{ url('/datamaster/agama/agama-delete') }}",
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
        
        $('body').on('click','.editButton', function(){
            var id = $(this).data('id');
            $('#exampleModalLabel').html('Update Data Agama');
            $('#btn-save').html('Update');

            $.ajax({
                    url: '{{ url('datamaster/agama/', '') }}'+'/'+id+'/edit',
                    method: 'GET',
                    success: function(response){
                        $('#id_agama').val(response.id_agama);
                        $('#nama_agama').val(response.nama_agama);
                    },
                    error: function(error){
                        console.log(error);
                    }
            });
        });

    });

    $('#agamaForm').submit(function(e) {
        var id_agama = $('#id_agama').val();
        var nama = $('#nama_agama').val();
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: "{{ route('agama.store')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id_agama": id_agama,
                "nama_agama": nama,
            },
            
            success: (response) => {
                Swal.fire("Sukses!", response.success, "success");
                $("#exampleModal").modal('hide');
                var oTable = $('#ajax-crud-datatable').dataTable();
                oTable.fnDraw(false);
                $("#btn-save"). attr("disabled", false);
            },
            error: function(error){
            console.log(error);
            }
        });
    });
</script>

@include('sweetalert::alert')

@endsection