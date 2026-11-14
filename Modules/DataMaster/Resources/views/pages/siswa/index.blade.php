@extends('layouts.master')
@section('title', 'Siswa')
@section('content')
    <style>
        .modal-body {
            max-height: 75vh;
            overflow-y: auto;
        }

        .section-separator {
            background: #f8f9fa;
            padding: 8px 12px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 15px;
            border-left: 4px solid #007bff;
            color: #333;
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
                                                    <th style="width:300px">Nama</th>
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

                                    <!-- MODAL INPUT / EDIT DATA GABUNGAN -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title" id="exampleModalLabel">Form Data Siswa</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form id="siswaForm" name="siswaForm" class="form-horizontal">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_siswa" id="id_siswa">
                                                        <input type="hidden" name="id_ortu" id="id_ortu">

                                                        <!-- SEKAT A: DATA SISWA -->
                                                        <div class="section-separator">A. DATA BIODATA SISWA</div>

                                                        <!-- NIK -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">NIK</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="nik"
                                                                    name="nik" placeholder="Masukan NIK.."
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);">
                                                            </div>
                                                        </div>

                                                        <!-- NISN -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">NISN</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="nisn"
                                                                    name="nisn" placeholder="Masukan NISN.."
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 11);">
                                                            </div>
                                                        </div>

                                                        <!-- NAMA -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Nama Siswa <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="nama_siswa"
                                                                    name="nama_siswa" placeholder="Masukan Nama Siswa.."
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <!-- JK -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Jenis Kelamin <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <select class="form-control" id="jk" name="jk"
                                                                    required>
                                                                    <option value="" selected disabled>-- Pilih Jenis
                                                                        Kelamin --</option>
                                                                    <option value="L">Laki-Laki</option>
                                                                    <option value="P">Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- TEMPAT LAHIR -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Tempat Lahir</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="tempat_lahir"
                                                                    name="tempat_lahir"
                                                                    placeholder="Masukan Tempat Lahir..">
                                                            </div>
                                                        </div>

                                                        <!-- TANGGAL LAHIR -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Tanggal Lahir</label>
                                                            <div class="col-lg-8">
                                                                <input type="date" class="form-control"
                                                                    id="tanggal_lahir" name="tanggal_lahir">
                                                            </div>
                                                        </div>

                                                        <!-- ALAMAT SISWA -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Alamat Siswa</label>
                                                            <div class="col-lg-8">
                                                                <textarea class="form-control" id="alamat_siswa" name="alamat_siswa" rows="2"
                                                                    placeholder="Masukan Alamat Siswa.."></textarea>
                                                            </div>
                                                        </div>

                                                        <!-- NO HP SISWA -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">No. HP Siswa</label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    id="no_hp_siswa" name="no_hp"
                                                                    placeholder="Masukan No HP Siswa..">
                                                            </div>
                                                        </div>

                                                        <!-- EMAIL -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Email</label>
                                                            <div class="col-lg-8">
                                                                <input type="email" class="form-control" id="email"
                                                                    name="email" placeholder="Masukan Email..">
                                                            </div>
                                                        </div>

                                                        <!-- KELAS -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Nama Kelas <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <select class="form-control select2" id="id_kelas"
                                                                    name="id_kelas" required style="width:100%;">
                                                                    <option value="" selected disabled>-- Pilih Kelas
                                                                        --</option>
                                                                    @foreach ($data_kelas as $k)
                                                                        <option value="{{ $k->id_kelas }}">
                                                                            {{ $k->nama_kelas }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- TAHUN AJARAN -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Tahun Ajaran <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <select class="form-control select2" id="id_tahun_ajaran"
                                                                    name="id_tahun_ajaran" required style="width:100%;">
                                                                    <option value="" selected disabled>-- Pilih Tahun
                                                                        Ajaran --</option>
                                                                    @foreach ($data_tahun_ajaran as $t)
                                                                        <option value="{{ $t->id_tahun_ajaran }}">
                                                                            {{ $t->tahun_ajaran }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>


                                                        <!-- SEKAT B: DATA ORANG TUA & AKUN LOGIN -->
                                                        <div class="section-separator">B. DATA ORANG TUA & AKUN LOGIN ORTU
                                                        </div>

                                                        <!-- NAMA AYAH & IBU -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Nama Ayah / Ibu <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control" id="nama_ayah"
                                                                    name="nama_ayah" required placeholder="Nama Ayah">
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <input type="text" class="form-control" id="nama_ibu"
                                                                    name="nama_ibu" required placeholder="Nama Ibu">
                                                            </div>
                                                        </div>

                                                        <!-- NO HP ORANG TUA -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">No. HP Orang Tua <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend"><span
                                                                            class="input-group-text">+628</span></div>
                                                                    <input type="text" class="form-control"
                                                                        id="no_hp_display_ortu" placeholder="3141-3323-88"
                                                                        required>
                                                                </div>
                                                                <input type="hidden" name="no_hp_ortu"
                                                                    id="no_hp_hidden_ortu">
                                                            </div>
                                                        </div>

                                                        <!-- USERNAME ORTU -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Username Login Ortu
                                                                <span class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control"
                                                                    id="username_ortu" name="username_ortu"
                                                                    autocomplete="off" required
                                                                    placeholder="Masukan Username..">
                                                            </div>
                                                        </div>

                                                        <!-- PASSWORD ORTU -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Password Login
                                                                Ortu</label>
                                                            <div class="col-lg-8">
                                                                <input type="password" class="form-control"
                                                                    id="password_ortu" name="password_ortu"
                                                                    placeholder="Kosongkan jika tidak ingin merubah default (12345678)">
                                                            </div>
                                                        </div>

                                                        <!-- ALAMAT ORTU -->
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Alamat Orang Tua</label>
                                                            <div class="col-lg-8">
                                                                <textarea class="form-control" id="alamat_ortu" name="alamat_ortu" rows="2"
                                                                    placeholder="Kosongkan jika sama dengan alamat siswa.."></textarea>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            id="btn-save">Simpan Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODAL DETAIL KHUSUS DATA ORANG TUA -->
                                    <div class="modal fade" id="detailOrtuModal" tabindex="-1"
                                        aria-labelledby="detailOrtuModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="detailOrtuModalLabel">Detail Orang Tua
                                                        Siswa</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table table-bordered table-striped">
                                                        <tr>
                                                            <th width="35%">Nama Siswa</th>
                                                            <td id="view_nama_siswa">-</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Nama Ayah</th>
                                                            <td id="view_nama_ayah">-</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Nama Ibu</th>
                                                            <td id="view_nama_ibu">-</td>
                                                        </tr>
                                                        <tr>
                                                            <th>No. HP Orang Tua</th>
                                                            <td id="view_no_hp_ortu">-</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Username Login</th>
                                                            <td id="view_username_ortu">-</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Status Akun</th>
                                                            <td id="view_status_user">-</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Alamat Tempat Tinggal</th>
                                                            <td id="view_alamat_ortu">-</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Tutup</button>
                                                </div>
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
            // Render AJAX Datatable Utama (Sesuai order kolom awal Anda)
            var table = $('#ajax-crud-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('siswa.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'nama_siswa',
                        name: 'nama_siswa'
                    },
                    {
                        data: 'nik',
                        name: 'nik'
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
                        name: 'email'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas'
                    },
                    {
                        data: 'tahun_ajaran',
                        name: 'tahun_ajaran'
                    },
                    {
                        data: 'status_alert',
                        name: 'status_alert'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            let aksi = '';
                            // STATUS TOGGLE (Menggunakan status_siswa)
                            aksi += row.status_siswa == 1 ? `
                            <label class="switch-status me-2" title="Status Siswa">
                                <input type="checkbox"
                                    class="statusButton"
                                    checked
                                    data-id="${row.id_siswa}"
                                    data-status="0">
                                <span class="slider-switch"></span>
                            </label>
                        ` : `
                            <label class="switch-status me-2" title="Status Siswa">
                                <input type="checkbox"
                                    class="statusButton"
                                    data-id="${row.id_siswa}"
                                    data-status="1">
                                <span class="slider-switch"></span>
                            </label>
                        `;

                            // DETAIL ORANG TUA
                            aksi += `
                            <button class="btn btn-info btn-sm detailOrtuButton me-1" data-id="${row.id_siswa}">
                                <i class="ti-eye"></i> Detail Ortu
                            </button>
                        `;
                            // EDIT
                            aksi += `
                            <button class="btn btn-success btn-sm editButton me-1" data-id="${row.id_siswa}">
                                <i class="ti-pencil"></i> Edit
                            </button>
                        `;
                            // DELETE
                            aksi += `
                            <button class="btn btn-danger btn-sm deleteButton" data-id="${row.id_siswa}" data-nama="${row.nama_siswa}">
                                <i class="ti-trash"></i> Hapus
                            </button>
                        `;

                            return aksi;
                        }
                    },
                ]
            });

            // Input Masking khusus HP Orang Tua (+628 Display)
            $('#no_hp_display_ortu').on('input', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                let formattedValue = "";
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) formattedValue += "-";
                    formattedValue += value[i];
                }
                $(this).val(formattedValue.substring(0, 15));
            });

            // Event Tombol Tambah Data Siswa
            $('#addsiswa').on('click', function() {
                $('#siswaForm').trigger("reset");
                $('#id_siswa').val('');
                $('#id_ortu').val('');
                $('#id_kelas').val('').trigger('change');
                $('#id_tahun_ajaran').val('').trigger('change');
                $('#exampleModalLabel').html('Tambah Data Siswa & Orang Tua');
                $('#exampleModal').modal('show');
            });

            // Event Tombol Lihat Detail Orang Tua (Pop-up Modal Terpisah)
            $(document).on('click', '.detailOrtuButton', function() {
                var id = $(this).data('id');
                $.get("{{ url('siswa') }}/" + id + "/edit", function(res) {
                    $('#view_nama_siswa').text(res.nama_siswa);
                    $('#view_nama_ayah').text(res.nama_ayah || '-');
                    $('#view_nama_ibu').text(res.nama_ibu || '-');
                    $('#view_no_hp_ortu').text(res.no_hp_ortu || '-');
                    $('#view_username_ortu').text(res.username_ortu || '-');
                    $('#view_status_user').html(
                        `<span class="badge badge-success">${res.status_user}</span>`);
                    $('#view_alamat_ortu').text(res.alamat_ortu || '-');

                    $('#detailOrtuModal').modal('show');
                }).fail(function() {
                    Swal.fire("Gagal!", "Data orang tua tidak ditemukan / eror server.", "error");
                });
            });

            // Event Tombol Edit Data (Mengambil data lengkap siswa & ortu sekaligus)
            $(document).on('click', '.editButton', function() {
                var id = $(this).data('id');
                $.get("{{ url('siswa') }}/" + id + "/edit", function(res) {
                    $('#exampleModalLabel').html('Update Data Siswa & Orang Tua');

                    // Bind Form Siswa
                    $('#id_siswa').val(res.id_siswa);
                    $('#nik').val(res.nik);
                    $('#nisn').val(res.nisn);
                    $('#nama_siswa').val(res.nama_siswa);
                    $('#jk').val(res.jk);
                    $('#tempat_lahir').val(res.tempat_lahir);
                    $('#tanggal_lahir').val(res.tanggal_lahir);
                    $('#alamat_siswa').val(res.alamat_siswa);
                    $('#no_hp_siswa').val(res.no_hp_siswa);
                    $('#email').val(res.email);
                    $('#id_kelas').val(res.id_kelas).trigger('change');
                    $('#id_tahun_ajaran').val(res.id_tahun_ajaran).trigger('change');

                    // Bind Form Ortu
                    $('#id_ortu').val(res.id_ortu);
                    $('#nama_ayah').val(res.nama_ayah);
                    $('#nama_ibu').val(res.nama_ibu);
                    $('#username_ortu').val(res.username_ortu);
                    $('#alamat_ortu').val(res.alamat_ortu);

                    if (res.no_hp_ortu) {
                        let nohp = res.no_hp_ortu.replace(/^628/, '').replace(/^08/, '');
                        $('#no_hp_display_ortu').val(nohp);
                        $('#no_hp_hidden_ortu').val(res.no_hp_ortu);
                    } else {
                        $('#no_hp_display_ortu').val('');
                        $('#no_hp_hidden_ortu').val('');
                    }

                    $('#exampleModal').modal('show');
                });
            });

            // Submit Form via Ajax POST ke Controller
            $('#siswaForm').submit(function(e) {
                e.preventDefault();

                let valHpOrtu = $('#no_hp_display_ortu').val().replace(/-/g, '');
                $('#no_hp_hidden_ortu').val('08' + valHpOrtu);

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

            // Action Hapus Data Gabungan
            $(document).on('click', '.deleteButton', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Menghapus Siswa: " + nama +
                        " juga akan menghapus data akun login orang tuanya!",
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
                                table.ajax.reload(null, false);
                            },
                            error: function(err) {
                                Swal.fire("Gagal!", "Terjadi kesalahan server.",
                                    "error");
                            }
                        });
                    }
                });
            });
        });

        // Aktif atau Non Aktif Status Siswa via SweetAlert2
        $(document).on('click', '.statusButton', function(e) {
            e.preventDefault(); // Mencegah checkbox berpindah posisi sebelum dikonfirmasi

            let id = $(this).data('id');
            let status = $(this).data('status');
            let isAktif = status == 1;

            Swal.fire({
                title: isAktif ? 'Aktifkan Siswa?' : 'Nonaktifkan Siswa?',
                text: isAktif ? 'Data siswa akan diaktifkan' : 'Data siswa akan dinonaktifkan',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: isAktif ? '#28a745' : '#ffc107',
                cancelButtonColor: '#d33',
                confirmButtonText: isAktif ? 'Ya, Aktifkan' : 'Ya, Nonaktifkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `{{ url('siswa/update-status') }}/${id}`,
                        type: 'POST',
                        data: {
                            status_siswa: isAktif ? 1 : 0,
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

                            $('#ajax-crud-datatable').DataTable().ajax.reload(null, false);
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal mengubah status siswa'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
