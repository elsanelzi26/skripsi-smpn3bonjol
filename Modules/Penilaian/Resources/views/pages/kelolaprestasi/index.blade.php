@extends('layouts.master')
@section('title', 'Kelola Prestasi Siswa')

@section('content')
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Kelola Prestasi Siswa</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Kelola Prestasi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Sukses!</strong> {{ session('success') }}
                    </div>
                @endif

                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                
                                <div class="row mb-4 align-items-center">
                                    <div class="col-md-6">
                                        <form method="GET" action="{{ route('prestasi.index') }}" class="form-inline">
                                            <div class="form-group mb-0">
                                                <label class="mr-2 font-weight-bold">Filter Tingkat:</label>
                                                <select name="filter_tingkat" class="form-control form-control-sm" onchange="this.form.submit()">
                                                    <option value="">-- Tampilkan Semua Tingkat --</option>
                                                    <option value="Sekolah" {{ request('filter_tingkat') == 'Sekolah' ? 'selected' : '' }}>Sekolah</option>
                                                    <option value="Kecamatan" {{ request('filter_tingkat') == 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                                    <option value="Kabupaten/Kota" {{ request('filter_tingkat') == 'Kabupaten/Kota' ? 'selected' : '' }}>Kabupaten/Kota</option>
                                                    <option value="Provinsi" {{ request('filter_tingkat') == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                                    <option value="Nasional" {{ request('filter_tingkat') == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                                    <option value="Internasional" {{ request('filter_tingkat') == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="{{ route('prestasi.cetakPdf', request()->all()) }}" class="btn btn-danger btn-sm shadow">
                                            <i class="ti-printer"></i> Cetak / Export Laporan PDF
                                        </a>
                                    </div>
                                </div>

                                <hr>

                                <div class="card-title d-flex justify-content-between align-items-center mt-3">
                                    <h4>Daftar Prestasi & Penghargaan Siswa</h4>
                                    <button type="button" class="btn btn-primary btn-sm rounded-pill shadow" data-toggle="modal" data-target="#modalPrestasi" onclick="addForm()">
                                        <i class="ti-plus"></i> Tambah Prestasi
                                    </button>
                                </div>

                                <div class="card-body mt-2">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No</th>
                                                    <th>Nama Siswa</th>
                                                    <th width="12%">NISN</th>
                                                    <th>Nama Lomba / Penghargaan (Kategori)</th>
                                                    <th width="12%">Tingkat</th>
                                                    <th width="15%">Peringkat/Capaian</th>
                                                    <th width="12%">Tanggal</th>
                                                    <th width="15%">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($data_prestasi as $index => $row)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td class="text-left">{{ $row->siswa->nama_siswa ?? '-' }}</td>
                                                        <td>{{ $row->siswa->nisn ?? '-' }}</td>
                                                        <td class="text-left">
                                                            <strong>[{{ $row->jenis_lomba->keterangan ?? '-' }}]</strong>
                                                            {{ $row->jenis_lomba->nama_jenis_lomba ?? '-' }}
                                                            @if ($row->keterangan)
                                                                <br><small class="text-muted">Ket: {{ $row->keterangan }}</small>
                                                            @endif
                                                        </td>
                                                        <td><span class="badge badge-info px-2 py-1">{{ $row->tingkat }}</span></td>
                                                        <td><span class="badge badge-success px-2 py-1">{{ $row->peringkat }}</span></td>
                                                        <td>{{ date('d-m-Y', strtotime($row->tanggal_penghargaan)) }}</td>
                                                        <td>
                                                            <div class="d-flex justify-content-center" style="gap: 6px;">
                                                                <button type="button" class="btn btn-info btn-sm text-white" onclick="editForm({{ $row->id_prestasi }})" title="Edit">
                                                                    <i class="ti-pencil"></i> Edit
                                                                </button>
                                                                <button type="button" class="btn btn-danger btn-sm deleteButton" data-id="{{ $row->id_prestasi }}" data-nama="{{ $row->siswa->nama_siswa ?? 'Siswa' }}">
                                                                    <i class="ti-trash"></i> Hapus
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center text-muted">Belum ada data prestasi siswa yang tercatat.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPrestasi" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="modalTitle">Tambah Data Prestasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('prestasi.store') }}" method="POST" id="formPrestasi">
                    @csrf
                    <input type="hidden" name="id_prestasi" id="id_prestasi">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nama Siswa</label>
                                <select class="form-control" name="siswa_id" id="siswa_id" required>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($data_siswa as $s)
                                        <option value="{{ $s->id_siswa }}">{{ $s->nama_siswa }} ({{ $s->nisn }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nama Lomba / Penghargaan</label>
                                <select class="form-control" name="jenis_lomba_id" id="jenis_lomba_id" required>
                                    <option value="">-- Pilih Jenis Lomba --</option>
                                    @foreach ($data_jenis_lomba as $lomba)
                                        <option value="{{ $lomba->id_jenis_lomba }}">[{{ $lomba->nama_jenis_lomba }}] - {{ $lomba->keterangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Tingkat</label>
                                <select class="form-control" name="tingkat" id="tingkat" required>
                                    <option value="Sekolah">Sekolah</option>
                                    <option value="Kecamatan">Kecamatan</option>
                                    <option value="Kabupaten/Kota">Kabupaten/Kota</option>
                                    <option value="Provinsi">Provinsi</option>
                                    <option value="Nasional">Nasional</option>
                                    <option value="Internasional">Internasional</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Peringkat / Juara</label>
                                <input type="text" class="form-control" name="peringkat" id="peringkat" placeholder="Contoh: Juara 1 / Harapan 3" required>
                            </div>
                            <div class="col-md-4 form-group">
                                <label class="font-weight-bold">Tanggal Penghargaan</label>
                                <input type="date" class="form-control" name="tanggal_penghargaan" id="tanggal_penghargaan" required>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label class="font-weight-bold">Keterangan Tambahan (Opsional)</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="Contoh: Diselenggarakan oleh Universitas ... atau Dinas Pendidikan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm shadow"><i class="ti-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // 1. Reset form ke mode Tambah Data
        function addForm() {
            $('#modalTitle').text('Tambah Data Prestasi');
            $('#formPrestasi').attr('action', "{{ route('prestasi.store') }}");
            $('#formPrestasi')[0].reset();
            $('#id_prestasi').val('');
        }

        // 2. Load data via AJAX ke mode Edit Data
        function editForm(id) {
            $('#modalTitle').text('Edit Data Prestasi');
            $('#formPrestasi').attr('action', "{{ route('prestasi.update') }}");
            $('#formPrestasi')[0].reset();

            $.ajax({
                url: "/prestasi/" + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id_prestasi').val(data.id_prestasi);
                    $('#siswa_id').val(data.id_siswa);
                    $('#jenis_lomba_id').val(data.id_jenis_lomba);
                    $('#tingkat').val(data.tingkat);
                    $('#peringkat').val(data.peringkat);
                    $('#tanggal_penghargaan').val(data.tanggal_penghargaan);
                    $('#keterangan').val(data.keterangan);

                    $('#modalPrestasi').modal('show');
                },
                error: function() {
                    alert("Gagal memuat data dari server, silakan segarkan halaman.");
                }
            });
        }

        // 3. Hapus Data dengan SweetAlert2
        $(document).on('click', '.deleteButton', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            Swal.fire({
                title: 'Hapus Data Prestasi?',
                text: "Yakin menghapus prestasi dari siswa: " + nama + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('prestasi.destroy') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": id
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire({
                                    title: "Terhapus!",
                                    text: res.message,
                                    icon: "success"
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire("Gagal!", res.message, "error");
                            }
                        },
                        error: function(err) {
                            Swal.fire("Gagal!", "Terjadi kesalahan server saat menghapus data.", "error");
                            console.log(err.responseText);
                        }
                    });
                }
            });
        });
    </script>
@endsection