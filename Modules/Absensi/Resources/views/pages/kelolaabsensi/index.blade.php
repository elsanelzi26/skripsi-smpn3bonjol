@extends('layouts.master')
@section('title', 'Form Absensi')

@section('content')

    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>Form Absensi Siswa</h1>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="#">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        Form Absensi
                                    </li>
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
                                    <h4>Input Absensi Siswa</h4>
                                </div>

                                <div class="card-body" style="margin-top:30px">

                                    <form method="POST" action="" id="formAbsensi">
                                        @csrf

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="date" class="form-control" name="tanggal"
                                                        value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Kelas</label>
                                                    <select class="form-control" name="id_kelas" id="id_kelas">
                                                        <option value="">
                                                            -- Pilih Kelas --
                                                        </option>
                                                        @foreach ($data_kelas as $item)
                                                            <option value="{{ $item->id_kelas }}">
                                                                {{ $item->nama_kelas }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Mata Pelajaran</label>
                                                    <select class="form-control" name="id_mapel">
                                                        <option value="">
                                                            -- Pilih Mata Pelajaran --
                                                        </option>

                                                        @foreach ($data_mapel as $item)
                                                            <option value="{{ $item->id_mapel }}">
                                                                {{ $item->nama_mapel }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="d-flex justify-content-center mb-4">
                                            <button type="button" class="btn btn-sm btn-primary" id="btnTampilkanSiswa">
                                                <i class="ti-search"></i>
                                                Tampilkan Siswa
                                            </button>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between align-items-center mb-4">

                                            <h5 class="mb-0">
                                                Daftar Siswa
                                            </h5>

                                            <label class="d-flex align-items-center mb-0 d-none" id="headerSiswa"
                                                style="gap:8px; cursor:pointer;">

                                                <input type="checkbox" id="checkHadirSemua">

                                                <span class="badge badge-success px-3 py-2">
                                                    Hadir Semua
                                                </span>

                                            </label>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered">

                                                <thead>
                                                    <tr>
                                                        <th width="5%">No</th>
                                                        <th>Nama Siswa</th>
                                                        <th>NISN</th>
                                                        <th width="25%">Status</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="tableSiswa">
                                                    <tr>
                                                        <td colspan="3" class="text-center">
                                                            Silahkan pilih kelas
                                                        </td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                        <div class="row mt-4">

                                            <div class="col-md-12 d-flex justify-content-center">

                                                <button type="submit"
                                                    class="btn btn-primary btn-sm px-5 rounded-pill shadow d-flex align-items-center"
                                                    style="gap:8px;">

                                                    <i class="ti-save"></i>
                                                    <span>Simpan Absensi</span>

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            // ======================
            // TAMPILKAN SISWA
            // ======================
            $('#btnTampilkanSiswa').click(function() {
                let id_kelas = $('#id_kelas').val();

                if (id_kelas == '') {
                    alert('Pilih kelas terlebih dahulu');
                    return;
                }

                // reset UI sebelum load
                $('#headerSiswa').hide();
                $('#checkHadirSemua').prop('checked', false);

                $.ajax({
                    url: "{{ route('absensi.getSiswa') }}",
                    type: "GET",
                    data: {
                        id_kelas: id_kelas
                    },
                    beforeSend: function() {
                        $('#tableSiswa').html(`
                        <tr>
                            <td colspan="4" class="text-center">
                                Memuat data siswa...
                            </td>
                        </tr>
                    `);
                    },
                    success: function(response) {
                        let html = '';

                        if (response.length === 0) {
                            html = `
                            <tr>
                                <td colspan="4" class="text-center">
                                    Data siswa tidak ditemukan
                                </td>
                            </tr>
                        `;
                            $('#headerSiswa').hide();
                        } else {
                            $.each(response, function(index, item) {
                                html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>
                                    ${item.nama_siswa}
                                    <input type="hidden" name="id_siswa[]" value="${item.id_siswa}">
                                </td>
                                <td>${item.nisn}</td>
                                <td>
                                    <div class="d-flex align-items-center" style="gap:14px;">
                                        <label class="d-flex align-items-center m-0" style="gap:4px;">
                                            <input type="radio"
                                                name="status[${item.id_siswa}]"
                                                value="Hadir"
                                                class="status-absen radio-hadir">
                                            <span>H</span>
                                        </label>

                                        <label class="d-flex align-items-center m-0" style="gap:4px;">
                                            <input type="radio"
                                                name="status[${item.id_siswa}]"
                                                value="Izin"
                                                class="status-absen">
                                            <span>I</span>
                                        </label>

                                        <label class="d-flex align-items-center m-0" style="gap:4px;">
                                            <input type="radio"
                                                name="status[${item.id_siswa}]"
                                                value="Sakit"
                                                class="status-absen">
                                            <span>S</span>
                                        </label>

                                        <label class="d-flex align-items-center m-0" style="gap:4px;">
                                            <input type="radio"
                                                name="status[${item.id_siswa}]"
                                                value="Alpha"
                                                class="status-absen">
                                            <span>A</span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            `;
                            });

                            // Tampilkan header pembungkus checkbox Hadir Semua
                            $('#headerSiswa').fadeIn();
                            // Pastikan class 'd-none' bawaan Bootstrap dihapus agar muncul
                            $('#headerSiswa').removeClass('d-none');
                        }

                        $('#tableSiswa').html(html);
                    }
                });
            });


            // ===================================
            // LOGIKA HADIR SEMUA & UNCHECK (FIXED)
            // ===================================
            $(document).on('change', '#checkHadirSemua', function() {
                if ($(this).is(':checked')) {
                    // Jika digeser/dicentang aktif, pilih semua radio button yang value-nya "Hadir"
                    $('input.status-absen[value="Hadir"]').prop('checked', true);
                } else {
                    // Jika centang dicabut, kosongkan pilihan (uncheck) semua radio button siswa
                    $('input.status-absen').prop('checked', false);
                }
            });

        });
    </script>
    <script>
        // tampil
        $('#headerSiswa').removeClass('d-none');

        // sembunyi
        $('#headerSiswa').addClass('d-none');

        // ======================
        // SIMPAN ABSENSI VIA AJAX
        // ======================
        $('#formAbsensi').submit(function(e) {
            e.preventDefault(); // Mencegah form submit normal (reload halaman)

            // Validasi sederhana: pastikan kelas dan mapel sudah dipilih
            if ($('#id_kelas').val() == '' || $('select[name="id_mapel"]').val() == '') {
                alert('Pastikan Kelas dan Mata Pelajaran sudah dipilih!');
                return;
            }

            // Validasi: pastikan semua siswa sudah diisi absensinya
            let semuaTerisi = true;
            $('input[name="id_siswa[]"]').each(function() {
                let idSiswa = $(this).val();
                if (!$(`input[name="status[${idSiswa}]"]:checked`).val()) {
                    semuaTerisi = false;
                    return false; // break loop
                }
            });

            if (!semuaTerisi) {
                alert('Mohon isi status absensi untuk semua siswa terlebih dahulu!');
                return;
            }

            // Ambil semua data form
            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('absensi.store') }}", // Sesuaikan dengan nama route Anda
                type: "POST",
                data: formData,
                beforeSend: function() {
                    // Ubah button jadi loading statis
                    $('button[type="submit"]').prop('disabled', true).html(`
                <i class="ti-reload rotate-anime"></i> Menyimpan...
            `);
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        // Reset form atau kosongkan tabel siswa setelah berhasil
                        $('#tableSiswa').html(`
                    <tr>
                        <td colspan="4" class="text-center">Silahkan pilih kelas</td>
                    </tr>
                `);
                        $('#headerSiswa').hide();
                        $('#checkHadirSemua').prop('checked', false);
                    } else {
                        alert('Gagal menyimpan: ' + response.message);
                    }

                    // window.location.href = "{{ route('absensi.rekap') }}";
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan sistem. Silahkan coba lagi.');
                    console.log(xhr.responseText);
                },
                complete: function() {
                    // Kembalikan tombol ke status semula
                    $('button[type="submit"]').prop('disabled', false).html(`
                <i class="ti-save"></i> <span>Simpan Absensi</span>
            `);
                }
            });
        });
    </script>
@endsection
