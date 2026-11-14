@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')
    <div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-r-0 title-margin-right">
                        <div class="page-header">
                            <div class="page-title">
                                @if(auth()->user()->id_role == 1)
                                <h1>Dashboard Admin</h1>
                                @elseif(auth()->user()->id_role == 2)
                                <h1>Dashboard Kepala Sekolah</h1>
                                @elseif(auth()->user()->id_role == 3)
                                <h1>Dashboard Wali Kelas</h1>
                                @elseif(auth()->user()->id_role == 4)
                                <h1>Dashboard Guru Mapel</h1>
                                @elseif(auth()->user()->id_role == 5)
                                <h1>Dashboard Guru BK</h1>
                                @elseif(auth()->user()->id_role == 6)
                                <h1>Dashboard Orang Tua</h1>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Home</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <section id="main-content">
                    @if (Auth::user()->id_role == 1)
                        <div class="row">

                            <div class="col-lg-3">
                                <a href="{{ route('role.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i class="ti-key color-primary border-primary"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Role</div>
                                                <div class="stat-digit">{{ $count_role ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('tahun_ajaran.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i class="ti-calendar color-pink border-pink"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Tahun Ajaran</div>
                                                <div class="stat-digit">{{ $count_tahun_ajaran ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('pegawai.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i
                                                    class="ti-id-badge color-warning border-warning"></i></div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Pegawai</div>
                                                <div class="stat-digit">{{ $count_pegawai ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('siswa.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i class="ti-user color-success border-success"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Siswa</div>
                                                <div class="stat-digit">{{ $count_siswa ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('kelas.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i class="ti-blackboard color-info border-info"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Kelas</div>
                                                <div class="stat-digit">{{ $count_kelas ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('mapel.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i class="ti-book color-dark border-dark"></i></div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">MaPel</div>
                                                <div class="stat-digit">{{ $count_mapel ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('jenislomba.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i class="ti-cup color-danger border-danger"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Jenis Lomba</div>
                                                <div class="stat-digit">{{ $count_lomba ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (Auth::user()->id_role == 6)
                        {{-- Orang Tua --}}
                        <div class="row">
                            <div class="col-lg-3">
                                <a href="{{ route('ortu.monitoring.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i class="ti-desktop color-info border-info"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Monitoring</div>
                                                <div class="stat-digit">{{ $count_monitoring ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Walas dan Guru Mapel --}}
                    @if (in_array(Auth::user()->id_role, [3, 4]))
                        <div class="row">

                            <div class="col-lg-3">
                                <a href="{{ route('absensi.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i
                                                    class="ti-check-box color-primary border-primary"></i></div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Absensi</div>
                                                <div class="stat-digit">{{ $count_absensi ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('penilaian.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i
                                                    class="ti-clipboard color-warning border-warning"></i></div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Penilaian</div>
                                                <div class="stat-digit">{{ $count_penilaian ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('prestasi.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib"><i class="ti-cup color-success border-success"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Prestasi</div>
                                                <div class="stat-digit">{{ $count_prestasi ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    @endif

                    {{-- Guru BK --}}
                    @if (in_array(Auth::user()->id_role, [5]))
                        <div class="row">

                            <div class="col-lg-4">
                                <a href="{{ route('siswabermasalah.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib">
                                                <i class="ti-alert color-danger border-danger"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Rekap Siswa Bermasalah</div>
                                                <div class="stat-digit">
                                                    {{ $count_rekap_siswa_bermasalah ?? 0 }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    @endif

                    {{-- Kepala Sekolah --}}
                    @if (in_array(Auth::user()->id_role, [2]))
                        <div class="row">

                            <div class="col-lg-3">
                                <a href="{{ route('absensi.rekap') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib">
                                                <i class="ti-check-box color-primary border-primary"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Rekap Absensi</div>
                                                <div class="stat-digit">{{ $count_absensi ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('penilaian.rekap') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib">
                                                <i class="ti-clipboard color-warning border-warning"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Rekap Penilaian</div>
                                                <div class="stat-digit">{{ $count_penilaian ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('prestasi.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib">
                                                <i class="ti-cup color-success border-success"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Rekap Prestasi</div>
                                                <div class="stat-digit">{{ $count_prestasi ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-3">
                                <a href="{{ route('siswabermasalah.index') }}"
                                    style="text-decoration: none; color: inherit; display: block;">
                                    <div class="card">
                                        <div class="stat-widget-one">
                                            <div class="stat-icon dib">
                                                <i class="ti-alert color-danger border-danger"></i>
                                            </div>
                                            <div class="stat-content dib">
                                                <div class="stat-text">Siswa Bermasalah</div>
                                                <div class="stat-digit">{{ $count_rekap_siswa_bermasalah ?? 0 }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    @endif

                </section>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer">
                            <p>2026 © SMPN 3 BONJOL.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('sweetalert::alert')
@endsection
