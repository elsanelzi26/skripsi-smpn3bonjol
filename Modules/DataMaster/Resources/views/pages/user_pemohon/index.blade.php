@extends('datamaster::layouts.master')
@section('title', 'Register User')
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
                                <button type="button" class="btn btn-primary mt-3 mb-5" data-toggle="modal" data-target="#exampleModal" id="addmanajemenuser">
                                    Tambah
                                </button>

                                <div class="table-responsive">
                                    <table class="table student-data-table m-t-20" id="ajax-crud-datatable">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama User</th>
                                                <th>NIP</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Pendidikan</th>
                                                <th>Agama</th>
                                                <th>Role</th>
                                                <th>Status</th>
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

                                        <form action="javascript:void(0)" id="manajemenuserForm" name="manajemenuserForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body"  style="max-height: calc(100vh - 210px);  overflow-y: auto;">
                                                <div class="form-group row">
                                                    <input type="hidden" name="id_user" id="id_user">
                                                    <label class="col-lg-4 col-form-label" for="nama_user">Nama <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control @error('nama_user') is-invalid @enderror" id="nama_user" name="nama_user" placeholder="Masukan Nama.." value="{{ old('nama_user') }}" autofocus required>
                                                    </div>
                                                    @error('nama_user')
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
                                                            <option value="2">Kasi / Kabid</option>
                                                            <option value="3">Kadis</option>
                                                            <option value="4">Masyarakat</option>
                                                        </select>
                                                        <div class="text-danger">
                                                            @error('role')
                                                            {{ $message }}
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="password">Password <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="************" value="{{ old('password') }}" required>
                                                    </div>
                                                    @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="status_aktif">Status <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="checkbox" id="status_aktif" name="status_aktif"> Aktif
                                                        @error('status_aktif')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
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