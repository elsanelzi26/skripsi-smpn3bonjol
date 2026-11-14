@extends('layouts.master')
@section('title', 'Jenis Lomba')
@section('content')
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
                                <h1>Data Jenis Lomba</h1>
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
                                    <h4>List Data Jenis Lomba</h4>
                                </div>
                                <div class="card-body" style="margin-top:40px">
                                    <button type="button" class="btn btn-primary mt-3 mb-5" id="addjenislomba">
                                        <i class="ti-plus"></i> Tambah Data
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20" id="ajax-crud-datatable"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Lomba</th>
                                                    <th>Keterangan</th>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Form Data Jenis Lomba</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form id="jenislombaForm" name="jenislombaForm" class="form-horizontal">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id_jenis_lomba" id="id_jenis_lomba">

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Nama Lomba <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="nama_jenis_lomba"
                                                                    name="nama_jenis_lomba" placeholder="Masukan Nama Lomba.."
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">Keterangan <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="keterangan"
                                                                    name="keterangan" placeholder="Masukan Keterangan.."
                                                                    required>
                                                            </div>
                                                            {{-- <div class="col-lg-8">
                                                               <textarea name="keterangan" id="keterangan" cols="30" rows="10"></textarea>
                                                            </div> --}}
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
                ajax: "{{ route('jenislomba.index') }}",
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
                    },
                    {
                        data: 'nama_jenis_lomba',
                        name: 'nama_jenis_lomba'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-info btn-sm editButton" data-id="${row.id_jenis_lomba}"><i class="ti-pencil"></i> Edit</button>
                            <button class="btn btn-danger btn-sm deleteButton" data-id="${row.id_jenis_lomba}" data-nama="${row.nama_jenis_lomba}"><i class="ti-trash"></i> Hapus</button>
                        `;
                        }
                    },
                ],
            });

            $('#addjenislomba').on('click', function() {
                $('#jenislombaForm').trigger("reset");
                $('#id_jenis_lomba').val('');
                $('#exampleModalLabel').html('Tambah Data Jenis Lomba');
                $('#exampleModal').modal('show');
            });

            $(document).on('click', '.editButton', function() {
                var id = $(this).data('id');
                $.get("{{ url('jenislomba') }}/" + id + "/edit", function(res) {
                    $('#exampleModalLabel').html('Update Data Jenis Lomba');
                    $('#id_jenis_lomba').val(res.id_jenis_lomba);
                    $('#nama_jenis_lomba').val(res.nama_jenis_lomba);
                    $('#keterangan').val(res.keterangan);
                    $('#exampleModal').modal('show');
                });
            });

            $('#jenislombaForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $("#btn-save").html('<i class="fa fa-spinner fa-spin"></i> Saving...').attr("disabled",
                    true);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('jenislomba.store') }}",
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
                            url: "{{ url('jenislomba/jenislomba-delete') }}", 
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
    </script>
@endsection
