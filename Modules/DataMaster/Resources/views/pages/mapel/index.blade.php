@extends('layouts.master')
@section('title', 'Mata Pelajaran')
@section('content')
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
                                <h1>Data Mata Pelajaran</h1>
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
                                    <h4>List Data Mata Pelajaran</h4>
                                </div>
                                <div class="card-body" style="margin-top:40px">
                                    <button type="button" class="btn btn-primary mt-3 mb-5" id="addmapel">
                                        <i class="ti-plus"></i> Tambah Data
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20" id="ajax-crud-datatable"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Mapel</th>
                                                    <th>Kode</th>
                                                    <th>KKM</th>
                                                    <th>Status Mapel</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <h5 class="modal-title" id="exampleModalLabel">Form Data Mata Pelajaran
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form id="mapelForm" name="mapelForm" class="form-horizontal">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_mapel" id="id_mapel">

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Nama Mapel <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="nama_mapel"
                                                                    name="nama_mapel" placeholder="Masukan Nama Mapel.."
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Kode Mapel <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="kode_mapel"
                                                                    name="kode_mapel" placeholder="Masukan Kode Mapel.."
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">KKM <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="kkm"
                                                                    name="kkm" placeholder="Masukan KKM.." required>
                                                            </div>
                                                        </div>

                                                        {{-- <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Status Mapel <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-lg-8">
                                                                <select class="form-control" id="status_mapel"
                                                                    name="status_mapel" required>
                                                                    <option value="">-- Pilih Status --</option>
                                                                    <option value="Aktif">Aktif</option>
                                                                    <option value="Nonaktif">Nonaktif</option>
                                                                </select>
                                                            </div>
                                                        </div> --}}
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary" id="btn-save">Simpan
                                                            Data</button>
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
                ajax: "{{ route('mapel.index') }}",
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                    },
                    {
                        data: 'nama_mapel',
                        name: 'nama_mapel'
                    },
                    {
                        data: 'kode_mapel',
                        name: 'kode_mapel'
                    },
                    {
                        data: 'kkm',
                        name: 'kkm'
                    },
                    {
                        data: 'status_alert',
                        name: 'status_alert'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        // render: function(data, type, row) {
                        //     return `
                    //     <button class="btn btn-success btn-sm editButton" data-id="${row.id_mapel}"><i class="ti-pencil"></i> Edit</button>
                    //     <button class="btn btn-danger btn-sm deleteButton" data-id="${row.id_mapel}" data-nama="${row.nama_mapel}"><i class="ti-trash"></i> Hapus</button>
                    // `;
                        // }
                        render: function(data, type, row) {

                            let aksi = '';

                            // TOGGLE STATUS AKTIF / NONAKTIF
                            aksi += row.status_aktif == 1 ?
                                `
                            <label class="switch-status me-1">
                                <input type="checkbox"
                                    class="statusButton"
                                    checked
                                    data-id="${row.id_mapel}"
                                    data-status="0">
                                <span class="slider-switch"></span>
                            </label>
                        ` :
                                `
                            <label class="switch-status me-1">
                                <input type="checkbox"
                                    class="statusButton"
                                    data-id="${row.id_mapel}"
                                    data-status="1">
                                <span class="slider-switch"></span>
                            </label>
                        `;

                            // BUTTON ACTION
                            aksi += `
                                <button class="btn btn-info btn-sm editButton"
                                    data-id="${row.id_mapel}">
                                    <i class="ti-pencil"></i> Edit
                                </button>

                                <button class="btn btn-danger btn-sm deleteButton"
                                    data-id="${row.id_mapel}"
                                    data-nama="${row.nama_mapel}">
                                    <i class="ti-trash"></i> Hapus
                                </button>
                            `;

                            return aksi;
                        }
                    },
                ],
            });

            $('#addmapel').on('click', function() {
                $('#mapelForm').trigger("reset");
                $('#id_mapel').val('');
                $('#exampleModalLabel').html('Tambah Data Mapel');
                $('#exampleModal').modal('show');
            });

            $(document).on('click', '.editButton', function() {
                var id = $(this).data('id');
                $.get("{{ url('mapel') }}/" + id + "/edit", function(res) {
                    $('#exampleModalLabel').html('Update Data Mapel');
                    $('#id_mapel').val(res.id_mapel);
                    $('#nama_mapel').val(res.nama_mapel);
                    $('#kode_mapel').val(res.kode_mapel);
                    $('#kkm').val(res.kkm);
                    $('#status_mapel').val(res.status_mapel);
                    $('#exampleModal').modal('show');
                });
            });

            $('#mapelForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $("#btn-save").html('<i class="fa fa-spinner fa-spin"></i> Saving...').attr("disabled",
                    true);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('mapel.store') }}",
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
                    text: "Yakin menghapus mata pelajaran: " + nama + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ url('mapel/mapel-delete') }}",
                            data: {
                                "id": id
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
                    'Aktifkan Mata Pelajaran?' : 'Nonaktifkan Mata Pelajaran?',
                text: isAktif ?
                    'Data mata pelajaran akan diaktifkan' : 'Data mata pelajaran akan dinonaktifkan',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: isAktif ? '#28a745' : '#ffc107',
                cancelButtonColor: '#d33',
                confirmButtonText: isAktif ? 'Ya, Aktifkan' : 'Ya, Nonaktifkan',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: `/mapel/update-status/${id}`,
                        type: 'POST',
                        data: {
                            status_mapel: isAktif ? 1 : 0,
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
