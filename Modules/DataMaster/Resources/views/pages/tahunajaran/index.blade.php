@extends('layouts.master')
@section('title', 'Tahun Ajaran')
@section('content')

    <div class="content-wrap">
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
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Data Tahun Ajaran</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Tahun Ajaran</li>
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
                                    <h4>List Data Tahun Ajaran</h4>
                                </div>
                                <div class="card-body" style="margin-top:40px">
                                    <button type="button" class="btn btn-primary mt-3 mb-5" id="addtahunajaran">
                                        <i class="ti-plus"></i> Tambah Data
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20" id="ajax-crud-datatable"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tahun Ajaran</th>
                                                    <th>Semester</th>
                                                    <th>Periode</th>
                                                    <th>Status</th>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Form Data Tahun Ajaran
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form id="tahunajaranForm" name="tahunajaranForm" class="form-horizontal">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_tahun_ajaran" id="id_tahun_ajaran">
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Tahun Ajaran <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="tahun_ajaran"
                                                                    name="tahun_ajaran" placeholder="Masukan Tahun Ajaran.."
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Semester <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-lg-8">
                                                                <select class="form-control" id="semester" name="semester"
                                                                    required>
                                                                    <option value="" selected disabled>-- Pilih
                                                                        Semester --</option>
                                                                    <option value="Ganjil">Ganjil</option>
                                                                    <option value="Genap">Genap</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Tanggal Mulai <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-lg-8">
                                                                <input type="date" class="form-control"
                                                                    id="tanggal_mulai" name="tanggal_mulai" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Tanggal Selesai <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-lg-8">
                                                                <input type="date" class="form-control"
                                                                    id="tanggal_selesai" name="tanggal_selesai" required>
                                                            </div>
                                                        </div>

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
                ajax: "{{ route('tahun_ajaran.index') }}",
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                    },
                    {
                        data: 'tahun_ajaran',
                        name: 'tahun_ajaran'
                    },
                    {
                        data: 'semester',
                        name: 'semester'
                    },
                    {
                        data: 'periode',
                        name: 'periode'
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
                        //     let btnStatus = row.status_aktif == 'Aktif'
                        //         ? `<button class="btn btn-primary btn-sm statusButton me-1"
                    //                 data-id="${row.id_tahun_ajaran}"
                    //                 data-status="0"
                    //                 title="Nonaktifkan">
                    //                 <i class="ti-check"></i>
                    //         </button>`
                        //         : `<button class="btn btn-secondary btn-sm statusButton me-1"
                    //                 data-id="${row.id_tahun_ajaran}"
                    //                 data-status="1"
                    //                 title="Aktifkan">
                    //                 <i class="ti-close"></i>
                    //         </button>`;

                        //     // hanya tampil kalau nonaktif
                        //     let btnDelete = '';

                        //     if (row.status_aktif != 'Aktif') {
                        //         btnDelete = `
                    //             <button class="btn btn-danger btn-sm deleteButton"
                    //                 data-id="${row.id_tahun_ajaran}"
                    //                 data-nama="${row.tahun_ajaran}"
                    //                 title="Hapus">
                    //                 <i class="ti-trash"></i>
                    //             </button>
                    //         `;
                        //     }

                        //     return `
                    //         ${btnStatus}

                    //         <button class="btn btn-success btn-sm editButton me-1"
                    //             data-id="${row.id_tahun_ajaran}"
                    //             title="Edit">
                    //             <i class="ti-pencil"></i>
                    //         </button>

                    //         ${btnDelete}
                    //     `;
                        // }
                        render: function(data, type, row) {

                            let aksi = '';

                            // kondisi expired + ditutup
                            let isLocked =
                                row.is_expired == true &&
                                row.status_aktif == 0;

                            // ==========================
                            // STATUS TOGGLE
                            // ==========================
                            if (!isLocked) {

                                aksi += row.status_aktif == 1 ?
                                    `
                                    <label class="switch-status me-1">
                                        <input type="checkbox"
                                            class="statusButton"
                                            checked
                                            data-id="${row.id_tahun_ajaran}"
                                            data-status="0">
                                        <span class="slider-switch"></span>
                                    </label>
                                    ` :
                                    `
                                    <label class="switch-status me-1">
                                        <input type="checkbox"
                                            class="statusButton"
                                            data-id="${row.id_tahun_ajaran}"
                                            data-status="1">
                                        <span class="slider-switch"></span>
                                    </label>
                                    `;
                            }

                            // ==========================
                            // EDIT
                            // hanya periode terbaru + dibuka
                            // ==========================
                            if (
                                row.is_terbaru == true &&
                                row.status_aktif == 1 &&
                                !row.is_expired
                            ) {

                                aksi += `
                                    <button class="btn btn-info btn-sm editButton me-1"
                                        data-id="${row.id_tahun_ajaran}"
                                        title="Edit">
                                        <i class="ti-pencil"></i> Edit
                                    </button>
                                `;
                            }

                            // ==========================
                            // LOCK EXPIRED
                            // ==========================
                            if (isLocked) {
                                aksi = `
                                    <span class="text-danger font-weight-bold">
                                        Tgl Expired
                                    </span>
                                `;
                            }

                            return aksi;
                        }
                    },
                ],
            });

            $('#addtahunajaran').on('click', function() {
                $('#tahunajaranForm').trigger("reset");
                $('#id_tahun_ajaran').val('');
                $('#exampleModalLabel').html('Tambah Data Tahun Ajaran');
                $('#exampleModal').modal('show');
            });

            $(document).on('click', '.editButton', function() {
                let id = $(this).data('id');
                $.get("{{ url('tahun_ajaran') }}/" + id + "/edit", function(res) {
                    $('#exampleModalLabel').html('Update Data Tahun Ajaran');
                    $('#id_tahun_ajaran').val(res.id_tahun_ajaran);
                    $('#tahun_ajaran').val(res.tahun_ajaran);
                    $('#semester').val(res.semester);
                    $('#tanggal_mulai').val(res.tanggal_mulai);
                    $('#tanggal_selesai').val(res.tanggal_selesai);
                    $('#exampleModal').modal('show');
                });
            });

            $('#tahunajaranForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $("#btn-save").html('<i class="fa fa-spinner fa-spin"></i> Saving...').attr("disabled",
                    true);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('tahun_ajaran.store') }}",
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

            // ACTION: HAPUS DATA 
            $(document).on('click', '.deleteButton', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Yakin menghapus Tahun Ajaran: " + nama + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ url('tahun_ajaran/tahun_ajaran-delete') }}",
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

        // Aktif atau Non Aktif
        $(document).on('click', '.statusButton', function() {

            let id = $(this).data('id');
            let status = $(this).data('status');

            let isAktif = status == 1;

            Swal.fire({
                title: isAktif ?
                    'Aktifkan Tahun Ajaran?' : 'Nonaktifkan Tahun Ajaran?',
                text: isAktif ?
                    'Data tahun ajaran akan diaktifkan' : 'Data tahun ajaran akan dinonaktifkan',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: isAktif ? '#28a745' : '#ffc107',
                cancelButtonColor: '#d33',
                confirmButtonText: isAktif ? 'Ya, Aktifkan' : 'Ya, Nonaktifkan',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: `/tahun_ajaran/update-status/${id}`,
                        type: 'POST',
                        data: {
                            status_aktif: isAktif ? 1 : 0,
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
