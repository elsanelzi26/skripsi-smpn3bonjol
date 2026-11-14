@extends('layouts.master')
@section('title', 'Form Penilaian')

@section('content')
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Form Penilaian Siswa</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Form Penilaian</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Input Penilaian Siswa</h4>
                                </div>

                                <div class="card-body" style="margin-top:30px">
                                    <form method="POST" action="" id="formpenilaian">
                                        @csrf

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Mata Pelajaran</label>
                                                    <select class="form-control" name="id_mapel" id="id_mapel" required>
                                                        <option value="">-- Pilih Mata Pelajaran --</option>
                                                        @foreach ($data_mapel as $item)
                                                            <option value="{{ $item->id_mapel }}">{{ $item->nama_mapel }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Kelas</label>
                                                    <select class="form-control" name="id_kelas" id="id_kelas" required>
                                                        <option value="">-- Pilih Kelas --</option>
                                                        @foreach ($data_kelas as $item)
                                                            <option value="{{ $item->id_kelas }}">{{ $item->nama_kelas }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Tahun Ajaran / Semester</label>
                                                    <select class="form-control" name="id_tahun_ajaran" id="id_tahun_ajaran" required>
                                                        <option value="">-- Pilih Semester --</option>
                                                        @foreach ($data_tahun_ajaran as $item)
                                                            <option value="{{ $item->id_tahun_ajaran }}">
                                                                {{ $item->teks_tahun_ajaran }} - Semester {{ $item->semester }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Tanggal Input</label>
                                                    <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mb-4">
                                            <button type="button" class="btn btn-sm btn-primary" id="btnTampilkanSiswa">
                                                <i class="ti-search"></i> Tampilkan Siswa
                                            </button>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="mb-0">Daftar Siswa & Input Nilai</h5>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th width="5%">No</th>
                                                        <th>Nama Siswa</th>
                                                        <th width="15%">NISN</th>
                                                        <th width="12%">Nilai Tugas</th>
                                                        <th width="12%">Nilai UH</th>
                                                        <th width="12%">Nilai UTS</th>
                                                        <th width="12%">Nilai UAS</th>
                                                        <th width="10%">Kunci Nilai?</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableSiswa">
                                                    <tr>
                                                        <td colspan="7" class="text-center">Silahkan isi filter di atas dan klik Tampilkan Siswa</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-12 d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary btn-sm px-5 rounded-pill shadow d-flex align-items-center" style="gap:8px;">
                                                    <i class="ti-save"></i>
                                                    <span>Simpan Penilaian</span>
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // ==========================================
            // AJAX TAMPILKAN SISWA BERDASARKAN FILTER
            // ==========================================
            $('#btnTampilkanSiswa').click(function() {
                let id_kelas = $('#id_kelas').val();
                let id_mapel = $('#id_mapel').val();
                let id_tahun_ajaran = $('#id_tahun_ajaran').val();

                if (id_kelas == '' || id_mapel == '' || id_tahun_ajaran == '') {
                    alert('Mohon lengkapi filter Mapel, Kelas, dan Semester terlebih dahulu!');
                    return;
                }

                $.ajax({
                    url: "{{ route('penilaian.getSiswa') }}",
                    type: "GET",
                    data: {
                        id_kelas: id_kelas,
                        id_mapel: id_mapel,
                        id_tahun_ajaran: id_tahun_ajaran
                    },
                    beforeSend: function() {
                        $('#tableSiswa').html(`
                            <tr>
                                <td colspan="7" class="text-center">Memuat data siswa dan nilai...</td>
                            </tr>
                        `);
                    },
                    success: function(response) {
                        let html = '';

                        if (response.length === 0) {
                            html = `
                                <tr>
                                    <td colspan="7" class="text-center">Data siswa tidak ditemukan di kelas ini</td>
                                </tr>
                            `;
                        } else {
                            $.each(response, function(index, item) {
                                let checkedFinal = item.is_final == 1 ? 'checked' : '';
                                
                                html += `
                                <tr>
                                    <td class="text-center">${index + 1}</td>
                                    <td>
                                        ${item.nama_siswa}
                                        <input type="hidden" name="siswa_id[]" value="${item.id_siswa}">
                                    </td>
                                    <td class="text-center">${item.nisn}</td>
                                    <td>
                                        <input type="number" min="0" max="100" class="form-control text-center" 
                                               name="nilai_tugas[${item.id_siswa}]" value="${item.nilai_tugas}" placeholder="0-100">
                                    </td>
                                    <td>
                                        <input type="number" min="0" max="100" class="form-control text-center" 
                                               name="nilai_uh[${item.id_siswa}]" value="${item.nilai_uh}" placeholder="0-100">
                                    </td>
                                    <td>
                                        <input type="number" min="0" max="100" class="form-control text-center" 
                                               name="nilai_uts[${item.id_siswa}]" value="${item.nilai_uts}" placeholder="0-100">
                                    </td>
                                    <td>
                                        <input type="number" min="0" max="100" class="form-control text-center" 
                                               name="nilai_uas[${item.id_siswa}]" value="${item.nilai_uas}" placeholder="0-100">
                                    </td>
                                    <td class="text-center">
                                        <input type="hidden" name="is_final[${item.id_siswa}]" value="0">
                                        <input type="checkbox" name="is_final[${item.id_siswa}]" value="1" ${checkedFinal} style="transform: scale(1.2);">
                                    </td>
                                </tr>
                                `;
                            });
                        }
                        $('#tableSiswa').html(html);
                    },
                    error: function() {
                        alert('Gagal mengambil data siswa.');
                    }
                });
            });

            // ==========================================
            // AJAX SIMPAN PENILAIAN
            // ==========================================
            $('#formpenilaian').submit(function(e) {
                e.preventDefault();

                if ($('#id_kelas').val() == '' || $('#id_mapel').val() == '' || $('#id_tahun_ajaran').val() == '') {
                    alert('Filter pengisian nilai tidak lengkap!');
                    return;
                }

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('penilaian.store') }}",
                    type: "POST",
                    data: formData,
                    beforeSend: function() {
                        $('button[type="submit"]').prop('disabled', true).html(`
                            <i class="ti-reload rotate-anime"></i> Menyimpan...
                        `);
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert('Gagal menyimpan: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan sistem.');
                        console.log(xhr.responseText);
                    },
                    complete: function() {
                        $('button[type="submit"]').prop('disabled', false).html(`
                            <i class="ti-save"></i> <span>Simpan Penilaian</span>
                        `);
                    }
                });
            });
        });
    </script>
@endsection