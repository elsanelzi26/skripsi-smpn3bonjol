@extends('layouts.master')
@section('title', 'Siswa')
@section('content')
    <style>
        .modal-body {
            max-height: 75vh;
            overflow-y: auto;
        }
    </style>
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Data Siswa</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">User</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title pr">
                                    <h4>List Data Siswa</h4>
                                </div>
                                <div class="card-body" style="margin-top:40px">
                                    <button type="button" class="btn btn-primary mt-3 mb-5" id="addsiswa">
                                        <i class="ti-plus"></i> Tambah Data
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20" id="ajax-crud-datatable"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>NIK</th>
                                                    <th>NISN</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>TTL</th>
                                                    <th>Email</th>
                                                    <th>No. Telepon</th>
                                                    <th>Kelas</th>
                                                    <th>Tahun Ajaran</th>
                                                    <th>Status Siswa</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">

                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Form Data Siswa
                                                    </h5>

                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">

                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form id="siswaForm" name="siswaForm" class="form-horizontal">

                                                    <div class="modal-body">

                                                        <!-- hidden -->
                                                        <input type="hidden" name="id_siswa" id="id_siswa">

                                                        <!-- NIK -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                NIK
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="nik"
                                                                    name="nik" placeholder="Masukan NIK.."
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);">
                                                            </div>
                                                        </div>

                                                        <!-- NISN -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                NISN
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="nisn"
                                                                    name="nisn" placeholder="Masukan NISN.."
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);">
                                                            </div>
                                                        </div>

                                                        <!-- PASSWORD -->
                                                        {{-- <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Password
                                                                <span class="text-danger" id="req-password">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="password" class="form-control" id="password"
                                                                    name="password" placeholder="Masukan Password">

                                                                <small class="text-muted" id="pass-note"
                                                                    style="display:none;">

                                                                    Kosongkan jika tidak ingin mengganti password
                                                                </small>
                                                            </div>
                                                        </div> --}}

                                                        
                                                        <!-- NAMA -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Nama Siswa
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    id="nama_siswa" name="nama_siswa"
                                                                    placeholder="Masukan Nama Siswa.." required>
                                                            </div>
                                                        </div>

                                                        <!-- JK -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Jenis Kelamin
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <select class="form-control" id="jk"
                                                                    name="jk" required>

                                                                    <option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
                                                                    <option value="L">Laki-Laki</option>
                                                                    <option value="P">Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- TEMPAT LAHIR -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Tempat Lahir
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    id="tempat_lahir" name="tempat_lahir"
                                                                    placeholder="Masukan Tempat Lahir..">
                                                            </div>
                                                        </div>

                                                        <!-- TANGGAL LAHIR -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Tanggal Lahir
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="date" class="form-control"
                                                                    id="tanggal_lahir" name="tanggal_lahir">
                                                            </div>
                                                        </div>

                                                        <!-- ALAMAT -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Alamat
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukan Alamat.."></textarea>
                                                            </div>
                                                        </div>

                                                        <!-- NO HP -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                No. HP
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">

                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            +628
                                                                        </span>
                                                                    </div>

                                                                    <input type="text" class="form-control"
                                                                        id="no_hp_display" placeholder="3141-3323-88"
                                                                        required>
                                                                </div>

                                                                <input type="hidden" name="no_hp" id="no_hp_hidden">

                                                                <small class="text-muted">
                                                                    Ex: 8888-8777-33
                                                                </small>

                                                            </div>
                                                        </div>

                                                        <!-- EMAIL -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Email
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="email" class="form-control" id="email"
                                                                    name="email" placeholder="Masukan Email..">
                                                            </div>
                                                        </div>
                                                             <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Nama Kelas
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <select class="form-control select2" id="id_kelas"
                                                                    name="id_kelas" required style="width:100%;">

                                                                    <option value="" selected disabled>-- Pilih Kelas --</option>

                                                                    @foreach ($data_kelas as $k)
                                                                        <option value="{{ $k->id_kelas }}">
                                                                            {{ $k->nama_kelas }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Tahun Ajaran
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <select class="form-control select2" id="id_tahun_ajaran"
                                                                    name="id_tahun_ajaran" required style="width:100%;">

                                                                    <option value="" selected disabled>-- Pilih Tahun Ajaran --</option>

                                                                    @foreach ($data_tahun_ajaran as $t)
                                                                        <option value="{{ $t->id_tahun_ajaran }}">
                                                                            {{ $t->tahun_ajaran }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>


                                                    </div>

                                                    <div class="modal-footer">

                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">

                                                            Tutup
                                                        </button>

                                                        <button type="submit" class="btn btn-primary" id="btn-save">

                                                            Simpan Data
                                                        </button>

                                                    </div>

                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#ajax-crud-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('siswa.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa',
                    },

                    {
                        data: 'nik',
                        name: 'nik',
                    },

                    {
                        data: 'nisn',
                        name: 'nisn'
                    },

                    
                    {
                        data: 'jk',
                        name: 'jk'
                    },

                     {
                        data: 'ttl',
                        name: 'ttl'
                    },

                    {
                        data: 'email',
                        name: 'email',
                    },

                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },

                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas',
                    },

                    {
                        data: 'tahun_ajaran',
                        name: 'tahun_ajaran'
                    },

                    {
                        data: 'status_siswa',
                        name: 'status_siswa'
                    },

                       {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-success btn-sm editButton" data-id="${row.id_siswa}"><i class="ti-pencil"></i> Edit</button>
                            <button class="btn btn-danger btn-sm deleteButton" data-id="${row.id_siswa}" data-nama="${row.nama_siswa}"><i class="ti-trash"></i> Hapus</button>
                        `;
                        }
                    },
                ]
            });
            // MASKING NO HP (Sesuai Placeholder Screenshot)
            $('#no_hp_display').on('input', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                let formattedValue = "";
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) formattedValue += "-";
                    formattedValue += value[i];
                }
                $(this).val(formattedValue.substring(0, 15));
            });

            $('#addsiswa').on('click', function() {
                $('#siswaForm').trigger("reset");
                $('#id_siswa').val('');
                $('#exampleModalLabel').html('Tambah Data Siswa');
                $('#password').attr('required', true);
                $('#req-password').show();
                $('#pass-note').hide();
                $('#exampleModal').modal('show');
            });

            $(document).on('click', '.editButton', function() {

                var id = $(this).data('id');

                console.log(id);

                $.get("{{ url('siswa') }}/" + id + "/edit", function(res) {

                    $('#exampleModalLabel').html('Update Data Siswa');

                    $('#id_siswa').val(res.id_siswa);
                    $('#nik').val(res.nik);
                    $('#nisn').val(res.nisn);
                    $('#nama_siswa').val(res.nama_siswa);
                    $('#jk').val(res.jk);
                    $('#tempat_lahir').val(res.tempat_lahir);
                    $('#tanggal_lahir').val(res.tanggal_lahir);
                    $('#alamat').val(res.alamat);
                    $('#email').val(res.email);
                    $('#id_kelas').val(res.id_kelas).trigger('change');
                    $('#id_tahun_ajaran').val(res.id_tahun_ajaran).trigger('change');
                    $('#status_siswa').val(res.status_siswa);
                    // no hp
                    if (res.no_hp) {

                        let nohp = res.no_hp
                            .replace(/^628/, '')
                            .replace(/^08/, '');

                        $('#no_hp_display').val(nohp);
                        $('#no_hp_hidden').val(res.no_hp);
                    }

                    // // password optional saat edit
                    // $('#password').removeAttr('required');

                    // $('#req-password').hide();

                    // $('#pass-note').show();

                    $('#exampleModal').modal('show');
                });

            });
            $('#siswaForm').submit(function(e) {
                e.preventDefault();
                // Gabungkan prefix +628 sebelum kirim
                let valHp = $('#no_hp_display').val().replace(/-/g, '');
                $('#no_hp_hidden').val('08' + valHp);

                var formData = new FormData(this);
                $("#btn-save").html('<i class="fa fa-spinner fa-spin"></i> Saving...').attr("disabled",
                    true);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('siswa.store') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (res) => {
                        Swal.fire("Berhasil!", "Data telah disimpan", "success");
                        $("#exampleModal").modal('hide');
                        table.ajax.reload(null, false);
                        $("#btn-save").html('Simpan Data').attr("disabled", false);
                    },
                    error: (err) => {
                        Swal.fire("Gagal!", "Cek inputan anda", "error");
                        $("#btn-save").html('Simpan Data').attr("disabled", false);
                    }
                });
            });

            $(document).on('click', '.deleteButton', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Yakin menghapus Siswa: " + nama + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ url('siswa/siswa-delete') }}",
                            data: {
                                "id": id 
                            },
                            success: function(res) {
                                Swal.fire("Terhapus!", "Data berhasil dihapus",
                                    "success");
                                table.ajax.reload(null,
                                    false); 
                            },
                            error: function(err) {
                                Swal.fire("Gagal!",
                                    "Data tidak dapat dihapus atau terjadi kesalahan server.",
                                    "error");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
