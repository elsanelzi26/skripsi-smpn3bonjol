@extends('datamaster::layouts.master')
@section('title', 'Management User')
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
                            <div class="card-body">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary mt-3 mb-5" data-toggle="modal" data-target="#exampleModal" id="adddetailuser">
                                    Tambah
                                </button>

                                <div class="table-responsive">
                                    <table class="table student-data-table m-t-20" id="ajax-crud-datatable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NIP</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Pendidikan</th>
                                                <th>Agama</th>
                                                <th>Role</th>
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

                                        <form action="javascript:void(0)" id="detailuserForm" name="detailuserForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body"  style="max-height: calc(100vh - 210px);  overflow-y: auto;">
                                                <div class="form-group row">
                                                    <input type="hidden" name="id_user" id="id_user">
                                                    <label class="col-lg-4 col-form-label" for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" placeholder="Masukan Nama Lengkap.." value="{{ old('nama_lengkap') }}" autofocus required>
                                                    </div>
                                                    @error('nama_lengkap')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="nip">NIP <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip" placeholder="Masukan NIP.." value="{{ old('nip') }}" required onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="18">
                                                    </div>
                                                    @error('nip')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="email">Email <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukan Email.." value="{{ old('email') }}" required>
                                                    </div>
                                                    @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <select class="@error('jenis_kelamin') is-invalid @enderror input-lg" id="jenis_kelamin" name="jenis_kelamin" value="{{old('jenis_kelamin')}}" style="width:100%">
                                                            <option value="">--PILIH JENIS KELAMIN--</option>
                                                            @foreach ($jeniskelamin as $jk)
                                                            <option value="{{ $jk->id_jenis_kelamin }}">{{ $jk->nama_jenis_kelamin }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('jenis_kelamin')
                                                            {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="pendidikan">Pendidikan <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <select class="@error('pendidikan') is-invalid @enderror input-lg" id="pendidikan" name="pendidikan" value="{{old('pendidikan')}}" style="width:100%">
                                                            <option value="">--PILIH PENDIDIKAN--</option>
                                                            @foreach ($pendidikan as $jk)
                                                            <option value="{{ $jk->id_pendidikan }}">{{ $jk->nama_pendidikan }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('pendidikan')
                                                            {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="agama">Agama <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <select class="@error('agama') is-invalid @enderror input-lg" id="agama" name="agama" value="{{old('agama')}}" style="width:100%">
                                                            <option value="">--PILIH AGAMA--</option>
                                                            @foreach ($agama as $jk)
                                                            <option value="{{ $jk->id_agama }}">{{ $jk->nama_agama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('agama')
                                                            {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-12 col-form-label" for="role">Role <span class="text-danger">*</span></label>
                                                    <div class="col-lg-12">
                                                        <select class="@error('role') is-invalid @enderror input-lg" id="role" name="role" value="{{old('role')}}" style="width:100%">
                                                            <option value="">--PILIH ROLE--</option>
                                                            <option value="1">Admin</option>
                                                            <option value="2">Kasi</option>
                                                            <option value="3">Kabid</option>
                                                            <option value="4">Kadis</option>
                                                            <option value="5">Masyarakat</option>
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('role')
                                                            {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="nomor_telepon">No. Telepon <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" id="nomor_telepon" name="nomor_telepon" placeholder="Masukan No. Telepon.." value="{{ old('nomor_telepon') }}" required onkeypress="return event.charCode>=48 && event.charCode<=57">
                                                    </div>
                                                    @error('nomor_telepon')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="alamat">Alamat <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <textarea name="alamat" id="alamat" class="form-control @error('nomor_telepon') is-invalid @enderror" cols="30" rows="10" required>{{ old('alamat') }}</textarea>
                                                    </div>
                                                    @error('alamat')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="password">Password <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="************" value="{{ old('password') }}" required>
                                                    </div>
                                                    @error('password')
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
            ajax: "{{ route('detailuser.index') }}",
            columns: [
                { 
                   // mengambil & menampilkan kolom sesuai tabel database
                   render: function (data, type, row, meta) {
                   return meta.row + meta.settings._iDisplayStart + 1;
                   },
                },
                { data: 'nama_lengkap', name: 'nama_lengkap'},
                { data: 'username', name: 'username'},
                { data: 'nama_jenis_kelamin', name: 'nama_jenis_kelamin' },
                { data: 'nama_pendidikan', name: 'nama_pendidikan'},
                { data: 'nama_agama', name: 'nama_agama'},
                {
                    "render": function ( data, type, row ) {
                        if(row.role == 1){
                            return 'Admin';
                        } else if(row.role == 1){
                            return 'Kasie';
                        } else if(row.role == 2){
                            return 'Kabid';
                        } else if(row.role == 3){
                            return 'Kadis';
                        }else if(row.role == 4){
                            return 'Kabid';
                        }else if(row.role == 5){
                            return 'Masyarakat';
                        }
                    }
                },

                {
                    "render": function ( data, type, row ) {
                        return `<a href="#exampleModal" data-target="#exampleModal" data-toggle="modal" class="btn btn-success editButton mr-2" data-id="`+row.id_user+`">Edit</a><a href="javascript:void(0)" data-id="`+row.id_user+`" data-nama="`+row.nama_lengkap+`" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger">Delete</a>`
                    }
                },
            ],
        });


        $('#adddetailuser').click(function(){
            $('#detailuserForm').trigger("reset");
            $('#exampleModalLabel').html('Create Data Manajemen User');
            $('#btn-save').html('Save');
            var id = $('#id_detail_user').val('');
        });


        $('body').on('click', '.delete', function () {
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            Swal.fire({
                title: 'Yakin?',
                text: "Kamu Akan Menghapus Data Manajemen User dengan Nama " + nama + "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type:"POST",
                        url: "{{ url('/datamaster/detailuser/detailuser-delete') }}",
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
            $('#exampleModalLabel').html('Update Data Manajemen User');
            $('#btn-save').html('Update');

            $.ajax({
                    url: '{{ url('datamaster/detailuser/', '') }}'+'/'+id+'/edit',
                    method: 'GET',
                    success: function(response){
                        var idu = response['jeniskelamin'].nama_jenis_kelamin;
                        $('#id_user').val(response['detailuser'].id_user);
                        $('#nama_lengkap').val(response['detailuser'].nama_lengkap);
                        $('#nip').val(response['detailuser'].username);
                        $('#email').val(response['detailuser'].email);
                        $('#nama_lengkap').val(response['detailuser'].nama_lengkap);
                        $('#nomor_telepon').val(response['detailuser'].nomor_telepon);
                        $('#alamat').val(response['detailuser'].alamat);
                        console.log(idu);

                        var id_jenis_kelamin = response['detailuser'].id_jenis_kelamin;
                        var id_pendidikan = response['detailuser'].id_pendidikan;
                        var id_agama = response['detailuser'].id_agama;
                        
                        var htmlJenisKelamin = "<option value=''>Select Jenis Kelamin</option>";
                        var htmlPendidikan = "<option value=''>Select Pendidikan</option>";           
                        var htmlAgama = "<option value=''>Select Agama</option>";
                        
                        var jeniskelamin = response['jeniskelamin'].length;
                        var pendidikan = response['pendidikan'].length;
                        var agama = response['agama'].length;
                        // console.log(jeniskelamin);

                        for(let j = 0; j<jeniskelamin; j++){
                            if(response['jeniskelamin'][j].id_jenis_kelamin == id_jenis_kelamin){
                            htmlJenisKelamin += `<option value="`+response['jeniskelamin'][j].id_jenis_kelamin+`" selected>`+response['jeniskelamin'][j].nama_jenis_kelamin+`</option>`;
                            } else {
                                htmlJenisKelamin += `<option value="`+response['jeniskelamin'][j].id_jenis_kelamin+`">`+response['jeniskelamin'][j].nama_jenis_kelamin+`</option>`;
                            }
                        }

                        for(let j = 0; j<pendidikan; j++){
                            if(response['pendidikan'][j].id_pendidikan == id_pendidikan){
                            htmlPendidikan += `<option value="`+response['pendidikan'][j].id_pendidikan+`" selected>`+response['pendidikan'][j].nama_pendidikan+`</option>`;
                            } else {
                                htmlPendidikan += `<option value="`+response['pendidikan'][j].id_pendidikan+`">`+response['pendidikan'][j].nama_pendidikan+`</option>`;
                            }
                        }

                        for(let j = 0; j<agama; j++){
                            if(response['agama'][j].id_agama == id_agama){
                            htmlAgama += `<option value="`+response['agama'][j].id_agama+`" selected>`+response['agama'][j].nama_agama+`</option>`;
                            } else {
                                htmlAgama += `<option value="`+response['agama'][j].id_agama+`">`+response['agama'][j].nama_agama+`</option>`;
                            }
                        }

                        $('#jenis_kelamin').html(htmlJenisKelamin);
                        $('#pendidikan').html(htmlPendidikan);
                        $('#agama').html(htmlAgama);

                        var role = response['detailuser'].role;
                        $('#role option[value="'+role+'"]').prop("selected", true);

                       
                    },
                    error: function(error){
                        console.log(error);
                    }
            });
        });
        
    });

    $('#detailuserForm').submit(function(e) {
        var id_user = $('#id_user').val();
        var nama_lengkap = $('#nama_lengkap').val();
        var nip = $('#nip').val();
        var email = $('#email').val();
        var jenis_kelamin = $('#jenis_kelamin').val();
        var pendidikan = $('#pendidikan').val();
        var agama = $('#agama').val();
        var password = $('#password').val();
        var role = $('#role').val();
        var nomor_telepon = $('#nomor_telepon').val();
        var alamat = $('#alamat').val();
        

        e.preventDefault();
        var formData = new FormData(this);
        // console.log(formData);
        $.ajax({
            type:'POST',
            url: "{{ route('detailuser.store')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id_user": id_user,
                "nama_lengkap": nama_lengkap,
                "nip": nip,
                "email": email,
                "jenis_kelamin": jenis_kelamin,
                "pendidikan": pendidikan,
                "agama": agama,
                "password": password,
                "role": role,
                "nomor_telepon": nomor_telepon,
                "alamat": alamat,
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

<script>
    $(document).ready(function(){
        $('#role').select2({
            placeholder : 'PILIH ROLE',
            dropdownParent: $("#exampleModal"),
            allowClear : true,
        });
        $('#jenis_kelamin').select2({
            placeholder : 'PILIH JENIS KELAMIN',
            dropdownParent: $("#exampleModal"),
            allowClear : true,
        });
        $('#pendidikan').select2({
            placeholder : 'PILIH PENDIDIKAN',
            dropdownParent: $("#exampleModal"),
            allowClear : true,
        });
        $('#agama').select2({
            placeholder : 'PILIH AGAMA',
            dropdownParent: $("#exampleModal"),
            allowClear : true,
        });
    });
</script>

@include('sweetalert::alert')

@endsection