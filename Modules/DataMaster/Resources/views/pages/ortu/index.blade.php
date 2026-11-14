@extends('layouts.master')
@section('title', 'Orang Tua')
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
                                <h1>Data Orang Tua</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Orang Tua</li>
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
                                    <h4>List Data Orang Tua</h4>
                                </div>
                                <div class="card-body" style="margin-top:40px">
                                    <button type="button" class="btn btn-primary mt-3 mb-5" id="addortu">
                                        <i class="ti-plus"></i> Tambah Data
                                    </button>

                                    <div class="table-responsive">
                                        <table class="table student-data-table m-t-20" id="ajax-crud-datatable"
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Nama Ayah</th>
                                                    <th>Nama Ibu</th>
                                                    <th>No. Telp</th>
                                                    <th>Alamat</th>
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
                                                        Form Data  Orang Tua
                                                    </h5>

                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">

                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <form id="ortuForm" name="ortuForm" class="form-horizontal">

                                                    <div class="modal-body">

                                                        <!-- hidden -->
                                                        <input type="hidden" name="id_ortu" id="id_ortu">

                                                        
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Nama Siswa
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <select class="form-control select2" id="id_siswa"
                                                                    name="id_siswa" required style="width:100%;">

                                                                    <option value="">-- Pilih Siswa --</option>

                                                                    @foreach ($data_siswa as $s)
                                                                        <option value="{{ $s->id_siswa }}">
                                                                            {{ $s->nama_siswa }}
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
                                                       
                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Nama Ayah
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="nama_ayah"
                                                                    name="nama_ayah" placeholder="Masukan Nama Ayah.."
                                                                    autocomplete="off" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <label class="col-lg-4 col-form-label">
                                                                Nama Ibu
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <div class="col-lg-8">
                                                                <input type="text" class="form-control" id="nama_ibu"
                                                                    name="nama_ibu" placeholder="Masukan Nama Ibu.."
                                                                    autocomplete="off" required>
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
                ajax: "{{ route('ortu.index') }}",
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
                        data: 'nama_ayah',
                        name: 'nama_ayah'
                    },

                    {
                        data: 'nama_ibu',
                        name: 'nama_ibu',
                    },

                    {
                        data: 'no_hp',
                        name: 'no_hp',
                    },

                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                     {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-success btn-sm editButton" data-id="${row.id_ortu}"><i class="ti-pencil"></i> Edit</button>
                            <button class="btn btn-danger btn-sm deleteButton" data-id="${row.id_ortu}" data-nama="${row.nama_siswa}"><i class="ti-trash"></i> Hapus</button>
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
            $('#addortu').on('click', function() {
                $('#ortuForm').trigger("reset");
                $('#id_kelas').val('');
                $('#exampleModalLabel').html('Tambah Data Kelas');
                $('#exampleModal').modal('show');
            });

            $(document).on('click', '.editButton', function() {

                var id = $(this).data('id');

                console.log(id);

                $.get("{{ url('ortu') }}/" + id + "/edit", function(res) {
                    $('#exampleModalLabel').html('Update Data Orang Tua');
                    $('#username').val(res.username);
                    $('#id_ortu').val(res.id_ortu);
                    $('#id_siswa').val(res.id_siswa).trigger('change');
                    $('#nama_ayah').val(res.nama_ayah);
                    $('#nama_ibu').val(res.nama_ibu);
                    // no hp
                    if (res.no_hp) {

                        let nohp = res.no_hp
                            .replace(/^628/, '')
                            .replace(/^08/, '');

                        $('#no_hp_display').val(nohp);
                        $('#no_hp_hidden').val(res.no_hp);
                    }
                    $('#alamat').val(res.alamat);
                    $('#exampleModal').modal('show');
                });

            });
            $('#ortuForm').submit(function(e) {
                e.preventDefault();

               // Gabungkan prefix +628 sebelum kirim
                let valHp = $('#no_hp_display').val().replace(/-/g, '');
                $('#no_hp_hidden').val('08' + valHp);

                var formData = new FormData(this);
                $("#btn-save").html('<i class="fa fa-spinner fa-spin"></i> Saving...').attr("disabled",
                    true);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('ortu.store') }}",
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
                    text: "Yakin menghapus Nama Ortu Dari Siswa : " + nama + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST", 
                            url: "{{ url('ortu/ortu-delete') }}",
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
