@extends('layouts.master')
@section('title', 'User')
@section('content')
    <style>
        .modal-body {
            max-height: 75vh;
            overflow-y: auto;
        }
    </style>
    <style>
        /* wrapper */
        .switch-status {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 24px;
            margin-bottom: 0;
        }

        /* hide checkbox */
        .switch-status input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* background switch */
        .slider-switch {
            position: absolute;
            cursor: pointer;
            inset: 0;
            background: #dc3545;
            border-radius: 999px;
            transition: .3s;
            box-shadow: inset 0 1px 4px rgba(0, 0, 0, .15);
        }

        /* bulatan putih */
        .slider-switch::before {
            content: "";
            position: absolute;
            height: 18px;
            width: 18px;
            left: 3px;
            top: 3px;
            background: white;
            border-radius: 50%;
            transition: .3s;
        }

        /* status aktif */
        .switch-status input:checked+.slider-switch {
            background: #169b40;
        }

        .switch-status input:checked+.slider-switch::before {
            transform: translateX(18px);
        }

        /* disabled */
        .switch-status input:disabled+.slider-switch {
            background: #cfd4da;
            cursor: not-allowed;
        }
    </style>
    <style>
        /* Border tabel */
        #ajax-crud-datatable {
            border-collapse: collapse;
            width: 100%;
        }

        #ajax-crud-datatable th,
        #ajax-crud-datatable td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }

        /* Header abu-abu */
        #ajax-crud-datatable thead th {
            background-color: #73baf7;
            color: white;
            text-align: center;
        }

        /* Row ganjil abu-abu muda */
        #ajax-crud-datatable tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
        }

        /* Hover */
        #ajax-crud-datatable tbody tr:hover {
            background-color: #dbeafe !important;
            cursor: pointer;
            transition: 0.2s;
        }
    </style>
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Data Pegawai</h1>
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
                                    <h4>List Data Pegawai</h4>
                                </div>
                                <div class="card-body" style="margin-top:40px">
                                    <button type="button" class="btn btn-primary mt-3 mb-5" id="adduser">
                                        <i class="ti-plus"></i> Tambah Data
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20" id="ajax-crud-datatable"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Username</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Role</th>
                                                    <th>Email</th>
                                                    <th>No. Telepon</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">

                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">

                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        Form Data Pegawai
                                                    </h5>

                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">

                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form id="userForm" name="userForm" class="form-horizontal">

                                                    <div class="modal-body">

                                                        <!-- hidden -->
                                                        <input type="hidden" name="id_user" id="id_user">
                                                        <input type="hidden" name="id_pegawai" id="id_pegawai">

                                                        <!-- ROLE -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Role
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <select class="form-control select2" id="role"
                                                                    name="role" required style="width:100%;">

                                                                    <option value="" selected disabled>-- Pilih Role
                                                                        --</option>

                                                                    @foreach ($role as $r)
                                                                        <option value="{{ $r->id_role }}">
                                                                            {{ $r->nama_role }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- USERNAME -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Username
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="username"
                                                                    name="username" placeholder="Masukan Username.."
                                                                    autocomplete="off" required>
                                                            </div>
                                                        </div>

                                                        <!-- PASSWORD -->
                                                        <div class="form-group row">
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
                                                        </div>

                                                        <!-- NIP -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                NIP
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="nip"
                                                                    name="nip" placeholder="Masukan NIP.."
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 18);">
                                                            </div>
                                                        </div>

                                                        <!-- NAMA -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Nama Lengkap
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    id="nama_pegawai" name="nama_pegawai"
                                                                    placeholder="Masukan Nama Lengkap.." required>
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

                                                                    <option value="" selected disabled>-- Pilih Jenis
                                                                        Kelamin --</option>
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

                                                        <!-- STATUS -->
                                                        {{-- <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Status Pegawai
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <select class="form-control" id="status_pegawai"
                                                                    name="status_pegawai">

                                                                    <option value="Aktif">Aktif</option>
                                                                    <option value="Nonaktif">Nonaktif</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Status User
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <select class="form-control" id="status_user"
                                                                    name="status_user">

                                                                    <option value="Aktif">Aktif</option>
                                                                    <option value="Nonaktif">Nonaktif</option>
                                                                </select>
                                                            </div>
                                                        </div> --}}

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
                ajax: "{{ route('pegawai.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },

                    {
                        data: 'username',
                        name: 'username',
                    },

                    {
                        data: 'nama_pegawai',
                        name: 'nama_pegawai'
                    },

                    {
                        data: 'nama_role',
                        name: 'nama_role',
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
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {

                            let aksi = '';

                            // ==========================
                            // STATUS TOGGLE
                            // ==========================
                            aksi += row.status_pegawai == 1 ?
                                `
                            <label class="switch-status me-2">
                                <input type="checkbox"
                                    class="statusButton"
                                    checked
                                    data-id="${row.id_pegawai}"
                                    data-status="0">
                                <span class="slider-switch"></span>
                            </label>
                            ` :
                                `
                            <label class="switch-status me-2">
                                <input type="checkbox"
                                    class="statusButton"
                                    data-id="${row.id_pegawai}"
                                    data-status="1">
                                <span class="slider-switch"></span>
                            </label>
                            `;

                            // ==========================
                            // EDIT
                            // ==========================
                            aksi += `
                                <button class="btn btn-info btn-sm editButton me-1"
                                    data-id="${row.user.id_user}">
                                    <i class="ti-pencil"></i> Edit
                                </button>
                            `;

                            // ==========================
                            // DELETE
                            // ==========================
                            aksi += `
                                <button class="btn btn-danger btn-sm deleteButton"
                                    data-id="${row.id_pegawai}"
                                    data-nama="${row.nama_pegawai}">
                                    <i class="ti-trash"></i> Hapus
                                </button>
                            `;

                            return aksi;
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

            $('#adduser').on('click', function() {
                $('#userForm').trigger("reset");
                $('#id_user').val('');
                $('#id_pegawai').val('');
                $('#exampleModalLabel').html('Tambah Data Pegawai');
                $('#password').attr('required', true);
                $('#req-password').show();
                $('#pass-note').hide();
                $('#exampleModal').modal('show');
            });

            $(document).on('click', '.editButton', function() {

                var id = $(this).data('id');

                console.log(id);

                $.get("{{ url('pegawai') }}/" + id + "/edit", function(res) {

                    $('#exampleModalLabel').html('Update Data Pegawai');

                    $('#id_user').val(res.id_user);
                    $('#id_pegawai').val(res.id_pegawai);

                    $('#username').val(res.username);
                    $('#role').val(res.role).trigger('change');

                    $('#nip').val(res.nip);

                    $('#nama_pegawai').val(res.nama_pegawai);

                    $('#jk').val(res.jk);

                    $('#tempat_lahir').val(res.tempat_lahir);

                    $('#tanggal_lahir').val(res.tanggal_lahir);

                    $('#alamat').val(res.alamat);

                    $('#email').val(res.email);

                    $('#status_pegawai').val(res.status_pegawai);

                    $('#status_user').val(res.status_user);

                    // no hp
                    if (res.no_hp) {

                        let nohp = res.no_hp
                            .replace(/^628/, '')
                            .replace(/^08/, '');

                        $('#no_hp_display').val(nohp);
                        $('#no_hp_hidden').val(res.no_hp);
                    }

                    // password optional saat edit
                    $('#password').removeAttr('required');

                    $('#req-password').hide();

                    $('#pass-note').show();

                    $('#exampleModal').modal('show');
                });

            });
            $('#userForm').submit(function(e) {
                e.preventDefault();
                // Gabungkan prefix +628 sebelum kirim
                let valHp = $('#no_hp_display').val().replace(/-/g, '');
                $('#no_hp_hidden').val('08' + valHp);

                var formData = new FormData(this);
                $("#btn-save").html('<i class="fa fa-spinner fa-spin"></i> Saving...').attr("disabled",
                    true);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('pegawai.store') }}",
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

            // ACTION: HAPUS DATA (Sesuai Route POST pegawai/pegawai-delete)
            $(document).on('click', '.deleteButton', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Yakin menghapus pegawai: " + nama + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST", // Diubah dari DELETE ke POST sesuai route kamu
                            url: "{{ url('pegawai/pegawai-delete') }}", // URL sesuai route kamu
                            data: {
                                "id": id // Mengirim parameter id
                            },
                            success: function(res) {
                                Swal.fire("Terhapus!", "Data berhasil dihapus",
                                    "success");
                                table.ajax.reload(null,
                                    false); // Reload tabel tanpa reset paging
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

        // Aktif atau Non Aktif
        $(document).on('click', '.statusButton', function() {

            let id = $(this).data('id');
            let status = $(this).data('status');

            let isAktif = status == 1;

            Swal.fire({
                title: isAktif ?
                    'Aktifkan Pegawai?' : 'Nonaktifkan Pegawai?',
                text: isAktif ?
                    'Data pegawai akan diaktifkan' : 'Data pegawai akan dinonaktifkan',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: isAktif ? '#28a745' : '#ffc107',
                cancelButtonColor: '#d33',
                confirmButtonText: isAktif ? 'Ya, Aktifkan' : 'Ya, Nonaktifkan',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: `/pegawai/update-status/${id}`,
                        type: 'POST',
                        data: {
                            status_pegawai: isAktif ? 1 : 0,
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },

                        success: function(response) {

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            $('#ajax-crud-datatable').DataTable().ajax.reload();
                        },

                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal mengubah status'
                            });
                        }
                    });

                }
            });
        });
    </script>
@endsection
