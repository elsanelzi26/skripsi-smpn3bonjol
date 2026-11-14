@extends('layouts.master')
@section('title', 'Monitoring Perkembangan Anak')

@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            
            <div class="card alert alert-info p-3">
                <div class="d-flex align-items-center">
                    <div class="mr-3">
                        <i class="ti-user" style="font-size: 24px;"></i>
                    </div>
                    <div>
                        <h4 class="mb-1">Monitoring Siswa: <strong>{{ $siswa->nama_siswa }}</strong></h4>
                        <p class="mb-0">NISN: {{ $siswa->nisn }} | Kelas: {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary btn-block p-3 font-weight-bold shadow-sm mb-2" onclick="switchKategori('absensi')">
                        <i class="ti-calendar"></i> MONITORING ABSENSI
                    </button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-success btn-block p-3 font-weight-bold shadow-sm mb-2" onclick="switchKategori('nilai')">
                        <i class="ti-bar-chart"></i> MONITORING NILAI AKADEMIK
                    </button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-warning btn-block p-3 font-weight-bold shadow-sm mb-2 text-white" onclick="switchKategori('prestasi')">
                        <i class="ti-trophy"></i> MONITORING PRESTASI
                    </button>
                </div>
            </div>

            <hr class="my-4">

            <div id="section-absensi" class="kategori-section" style="display: none;">
                <div class="card">
                    <div class="card-title"><h4>Filter Rentang Tanggal Absensi</h4></div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="font-weight-bold">Dari Tanggal</label>
                                <input type="date" class="form-control" id="absensi_mulai" value="{{ date('Y-m-01') }}">
                            </div>
                            <div class="col-md-5">
                                <label class="font-weight-bold">Sampai Tanggal</label>
                                <input type="date" class="form-control" id="absensi_selesai" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-primary btn-sm btn-block" onclick="loadAbsensi()"><i class="ti-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="box-notifikasi-alpha" class="mt-3" style="display: none;"></div>

                <div class="row mt-3">
                    <div class="col-md-5">
                        <div class="card h-100">
                            <div class="card-title"><h4>Grafik Kehadiran</h4></div>
                            <div class="card-body mt-2 text-center">
                                <div style="max-width: 280px; margin: 0 auto;">
                                    <canvas id="chartAbsensi"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card h-100">
                            <div class="card-title"><h4>Rincian Tabel Absensi</h4></div>
                            <div class="card-body mt-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="tabel-absensi">
                                        <thead>
                                            <tr class="text-center">
                                                <th width="10%">No</th>
                                                <th>Tanggal</th>
                                                <th>Status Absen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr><td colspan="3" class="text-center text-muted">Silakan tentukan tanggal lalu klik Cari.</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="section-nilai" class="kategori-section" style="display: none;">
                <div class="card">
                    <div class="card-title"><h4>Filter Nilai Mata Pelajaran & Semester</h4></div>
                    <div class="card-body mt-2">
                        <div class="row">
                            <div class="col-md-5">
                                <label class="font-weight-bold">Pilih Mata Pelajaran</label>
                                <select class="form-control" id="nilai_mapel">
                                    <option value="">-- Pilih Mapel --</option>
                                    @foreach($data_mapel as $m)
                                        <option value="{{ $m->id_mapel }}">{{ $m->nama_mapel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="font-weight-bold">Semester</label>
                                <select class="form-control" id="nilai_semester">
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-success btn-sm btn-block" onclick="loadNilai()"><i class="ti-search"></i> Lihat Nilai</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-title"><h4>Capaian Nilai Akademik Anak</h4></div>
                    <div class="card-body mt-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="tabel-nilai">
                                <thead>
                                    <tr class="text-center">
                                        <th>Mata Pelajaran</th>
                                        <th>Tugas (10%)</th>
                                        <th>UH (20%)</th>
                                        <th>UTS (30%)</th>
                                        <th>UAS (40%)</th>
                                        <th>Nilai Akhir</th>
                                        <th>KKM</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="8" class="text-center text-muted">Silakan pilih mapel dan semester terlebih dahulu.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="section-prestasi" class="kategori-section" style="display: none;">
                <div class="card">
                    <div class="card-title"><h4>Daftar Kompetensi / Prestasi yang Diikuti</h4></div>
                    <div class="card-body mt-3">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="tabel-prestasi">
                                <thead>
                                    <tr class="text-center">
                                        <th width="5%">No</th>
                                        <th width="20%">Tanggal</th>
                                        <th>Nama Lomba / Kegiatan</th>
                                        <th>Tingkat</th>
                                        <th width="15%">Juara/Peringkat</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let myChart = null; // Variabel global penampung objek grafik agar tidak bentrok saat di-render ulang

    // Fungsi ganti-ganti tampilan section menu utama
    function switchKategori(kategori) {
        $('.kategori-section').hide();
        $('#section-' + kategori).fadeIn();

        // Khusus menu prestasi, karena tidak butuh input filter, langsung load otomatis saat diklik
        if (kategori === 'prestasi') {
            loadPrestasi();
        }
    }

    // ==========================================
    // AJAX JALUR 1: LOAD ABSENSI & RENDER GRAFIK
    // ==========================================
    function loadAbsensi() {
        let tglMulai = $('#absensi_mulai').val();
        let tglSelesai = $('#absensi_selesai').val();

        $.ajax({
            url: "{{ route('ortu.monitoring.absensi') }}",
            type: "GET",
            data: { tanggal_mulai: tglMulai, tanggal_selesai: tglSelesai },
            success: function(res) {
                // 1. Render Tabel Rincian Absensi
                let htmlTabel = '';
                if(res.data_tabel.length > 0) {
                    res.data_tabel.forEach((row, i) => {
                        let badge = row.status_absensi === 'Alpha' ? 'badge-danger' : 'badge-success';
                        htmlTabel += `<tr>
                            <td class="text-center">${i+1}</td>
                            <td class="text-center">${row.tanggal}</td>
                            <td class="text-center"><span class="badge ${badge}">${row.status_absensi}</span></td>
                        </tr>`;
                    });
                } else {
                    htmlTabel = `<tr><td colspan="3" class="text-center text-muted">Tidak ada rekaman absensi pada rentang tanggal ini.</td></tr>`;
                }
                $('#tabel-absensi tbody').html(htmlTabel);

                // 2. Tampilkan/Sembunyikan Box Early Warning System Peringatan Batas Alpha
                if (res.notifikasi) {
                    $('#box-notifikasi-alpha').html(`<div class="alert alert-danger font-weight-bold shadow-sm" role="alert"><i class="ti-alert"></i> ${res.notifikasi}</div>`).slideDown();
                } else {
                    $('#box-notifikasi-alpha').slideUp();
                }

                // 3. Render / Update Grafik Lingkaran (Pie Chart.js)
                if (myChart) { myChart.destroy(); } // Hapus grafik lama sebelum membuat grafik baru
                
                const ctx = document.getElementById('chartAbsensi').getContext('2d');
                myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: res.data_grafik.labels,
                        datasets: [{
                            data: res.data_grafik.dataset,
                            backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#17a2b8'] // Sesuaikan variasi status absen
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            }
        });
    }

    // ==========================================
    // AJAX JALUR 2: LOAD TABEL NILAI PER MAPEL
    // ==========================================
    function loadNilai() {
        let mapel = $('#nilai_mapel').val();
        let semester = $('#nilai_semester').val();

        if(!mapel) { alert('Silakan pilih mata pelajaran!'); return; }

        $.ajax({
            url: "{{ route('ortu.monitoring.nilai') }}",
            type: "GET",
            data: { id_mapel: mapel, semester: semester },
            success: function(res) {
                let htmlTabel = '';
                if (res.length > 0) {
                    res.forEach(row => {
                        let badgeKeterangan = row.status_kelulusan === 'Tuntas' ? 'badge-success' : 'badge-danger';
                        // Mengambil nama mapel dan KKM dengan aman dari objek relasi mapel
                        let namaMapel = row.mapel ? row.mapel.nama_mapel : 'Mapel';
                        let kkmMapel  = row.mapel ? row.mapel.kkm : 75; 
                        htmlTabel += `<tr class="text-center">
                            <td><strong>${row.mapel.nama_mapel}</strong></td>
                            <td>${row.nilai_tugas}</td>
                            <td>${row.nilai_uh}</td>
                            <td>${row.nilai_uts}</td>
                            <td>${row.nilai_uas}</td>
                            <td class="text-primary font-weight-bold">${row.nilai_akhir}</td>
                            <td>${kkmMapel}</td>
                            <td><span class="badge ${badgeKeterangan}">${row.status_kelulusan}</span></td>
                        </tr>`;
                    });
                } else {
                    htmlTabel = `<tr><td colspan="8" class="text-center text-muted">Data nilai untuk komponen/semester ini belum diinput oleh guru.</td></tr>`;
                }
                $('#tabel-nilai tbody').html(htmlTabel);
            }
        });
    }

    // ==========================================
    // AJAX JALUR 3: LOAD SEMUA DATA PRESTASI
    // ==========================================
    function loadPrestasi() {
        $.ajax({
            url: "{{ route('ortu.monitoring.prestasi') }}",
            type: "GET",
            success: function(res) {
                let htmlTabel = '';
                if (res.length > 0) {
                    res.forEach((row, i) => {
                        htmlTabel += `<tr>
                            <td class="text-center">${i+1}</td>
                            <td class="text-center">
                                ${row.tanggal_penghargaan
                                    ? row.tanggal_penghargaan.split('-').reverse().join('-')
                                    : '-'}
                            </td>
                            <td><strong>${row.jenis_lomba.nama_jenis_lomba}</strong></td>
                             <td class="text-center text-success font-weight-bold"><i class="ti-medal"></i>${row.tingkat}</td>
                            <td class="text-center text-success font-weight-bold"><i class="ti-medal"></i> ${row.peringkat}</td>
                            <td>${row.keterangan ?? '-'}</td>
                        </tr>`;
                    });
                } else {
                    htmlTabel = `<tr><td colspan="5" class="text-center text-muted">Belum ada data riwayat capaian prestasi siswa saat ini.</td></tr>`;
                }
                $('#tabel-prestasi tbody').html(htmlTabel);
            }
        });
    }
</script>
@endsection