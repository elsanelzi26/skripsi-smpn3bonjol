@extends('layouts.master')
@section('title', 'Guru Mata Pelajaran')
@section('content')
    <style>
        .modal-body {
            max-height: 75vh;
            overflow-y: auto;
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
                                <h1>Data Guru Mata Pelajaran</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Guru Mata Pelajaran</li>
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
                                    <h4>List Data Guru Mata Pelajaran</h4>
                                </div>
                                <div class="card-body" style="margin-top:40px">
                                    <button type="button" class="btn btn-primary mt-3 mb-5" id="addgurumapel">
                                        <i class="ti-plus"></i> Tambah Data
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20" id="ajax-crud-datatable"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Guru Mapel</th>
                                                    <th>Nama Mapel</th>
                                                    <th>Nama Kelas</th>
                                                    <th>Tahun Ajaran</th>
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

                                                <form id="gurumapelForm" name="gurumapelForm" class="form-horizontal">

                                                    <div class="modal-body">

                                                        <!-- hidden -->
                                                        <input type="hidden" name="id_guru_mapel" id="id_guru_mapel">

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Nama Guru Mapel
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <select class="form-control select2" id="id_pegawai"
                                                                    name="id_pegawai" required style="width:100%;">

                                                                    <option value="" selected disabled>-- Pilih Guru
                                                                        Mapel --</option>

                                                                    @foreach ($data_pegawai as $p)
                                                                        <option value="{{ $p->id_pegawai }}">
                                                                            {{ $p->nama_pegawai }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Nama Mapel
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <select class="form-control select2" id="id_mapel"
                                                                    name="id_mapel" required style="width:100%;">

                                                                    <option value="" selected disabled>-- Pilih Mapel
                                                                        --</option>

                                                                    @foreach ($data_mapel as $mp)
                                                                        <option value="{{ $mp->id_mapel }}">
                                                                            {{ $mp->nama_mapel }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
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

                                                                    <option value="" selected disabled>-- Pilih Kelas
                                                                        --</option>

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

                                                                    <option value="" selected disabled>-- Pilih Tahun
                                                                        Ajaran --</option>

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
                ajax: "{{ route('guru_mapel.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },

                    {
                        data: 'nama_pegawai',
                        name: 'nama_pegawai',
                    },

                    {
                        data: 'nama_mapel',
                        name: 'nama_mapel'
                    },

                    {
                        data: 'nama_kelas',
                        name: 'nama_kelas',
                    },

                    {
                        data: 'tahun_ajaran',
                        name: 'tahun_ajaran',
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-info btn-sm editButton" data-id="${row.id_guru_mapel}"><i class="ti-pencil"></i> Edit</button>
                            <button class="btn btn-danger btn-sm deleteButton" data-id="${row.id_guru_mapel}" data-nama="${row.nama_pegawai}"><i class="ti-trash"></i> Hapus</button>
                        `;
                        }
                    },
                ]
            });


            $('#addgurumapel').on('click', function() {
                $('#gurumapelForm').trigger("reset");
                $('#id_guru_mapel').val('');
                $('#exampleModalLabel').html('Tambah Data Guru Mata Pelajaran');
                $('#exampleModal').modal('show');
            });

            $(document).on('click', '.editButton', function() {

                var id = $(this).data('id');

                console.log(id);

                $.get("{{ url('guru_mapel') }}/" + id + "/edit", function(res) {
                    $('#exampleModalLabel').html('Update Data Guru Mata Pelajaran');
                    $('#id_guru_mapel').val(res.id_guru_mapel);
                    $('#id_pegawai').val(res.id_pegawai).trigger('change');
                    $('#id_mapel').val(res.id_mapel).trigger('change');
                    $('#id_kelas').val(res.id_kelas).trigger('change');
                    $('#id_tahun_ajaran').val(res.id_tahun_ajaran).trigger('change');
                    $('#exampleModal').modal('show');
                });

            });
            $('#gurumapelForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                $("#btn-save").html('<i class="fa fa-spinner fa-spin"></i> Saving...').attr("disabled",
                    true);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('guru_mapel.store') }}",
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
                    text: "Yakin menghapus Guru MaPel: " + nama + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ url('guru_mapel/guru_mapel-delete') }}",
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
