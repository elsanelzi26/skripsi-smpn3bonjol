<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <div class="logo"><a href="{{ asset('template/index.html') }}">
                        <!-- <img src="{{ asset('template/images/logo.png') }}" alt="" /> --><span>SMPN 3
                            BONJOL</span></a></div>

                <li class="label">
                    <hr style="border-top: 5px solid rgba(231, 231, 241, 0.822);">
                </li>

                <li><a href="{{ route('dashboard') }}"><i class="ti-home" style="color:purple"></i>Dashboard</a></li>
                {{-- Admin  --}}
                @if (Auth::user()->id_role == 1)
                    <li><a class="sidebar-sub-toggle"><i class="ti-server"></i> Data Master <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{ route('role.index') }}"><i class="fa fa-circle-o"
                                        style="color:Yellow"></i>Role</a></li>
                            <li><a href="{{ route('pegawai.index') }}"><i class="fa fa-circle-o"
                                        style="color:white"></i>Pegawai</a></li>
                            <li><a href="{{ route('siswa.index') }}"><i class="fa fa-circle-o"
                                        style="color:red"></i>Siswa</a></li>
                            <li><a href="{{ route('tahun_ajaran.index') }}"><i class="fa fa-circle-o"
                                        style="color:blue"></i>Tahun Ajaran</a></li>
                            <li><a href="{{ route('kelas.index') }}"><i class="fa fa-circle-o"
                                        style="color:green"></i>Kelas</a></li>
                            <li><a href="{{ route('mapel.index') }}"><i class="fa fa-circle-o"
                                        style="color:purple"></i>Mata Pelajaran</a></li>
                            <li><a href="{{ route('guru_mapel.index') }}"><i class="fa fa-circle-o"
                                        style="color:blue"></i>Guru Mapel</a></li>
                            <li><a href="{{ route('jenislomba.index') }}"><i class="fa fa-circle-o"
                                        style="color:Yellow"></i>Jenis Lomba</a></li>
                            {{-- <li><a href="{{ route('ortu.index') }}"><i class="fa fa-circle-o" style="color:green"></i>Orang Tua</a></li> --}}
                        </ul>
                    </li>
                @endif


                @if (in_array(Auth::user()->id_role, [1, 3, 4]))
                    <li><a class="sidebar-sub-toggle"><i class="ti-file"></i> Absensi <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            @if (in_array(Auth::user()->id_role, [3, 4]))
                                {{-- Wali Kelas dan Guru Mapel --}}
                                <li><a href="{{ route('absensi.index') }}"><i class="fa fa-circle-o"
                                            style="color:Yellow"></i>Kelola Absensi</a></li>
                            @endif
                            @if (in_array(Auth::user()->id_role, [1, 3, 4]))
                                {{-- Walas, GUru Mapel, Admin --}}
                                <li><a href="{{ route('absensi.rekap') }}"><i class="fa fa-circle-o"
                                            style="color:blue"></i>Rekap Absensi</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (in_array(Auth::user()->id_role, [1, 3, 4]))
                    <li><a class="sidebar-sub-toggle"><i class="ti-file"></i> Penilaian <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            @if (in_array(Auth::user()->id_role, [4]))
                                {{-- Guru Mapel --}}
                                <li><a href="{{ route('penilaian.index') }}"><i class="fa fa-circle-o"
                                            style="color:Yellow"></i>Kelola Nilai Siswa</a></li>
                            @endif
                            @if (in_array(Auth::user()->id_role, [1, 3, 4]))
                                {{-- Walas, GUru Mapel, Admin --}}
                                <li><a href="{{ route('penilaian.rekap') }}"><i class="fa fa-circle-o"
                                            style="color:blue"></i>Rekap Penilaian</a></li>
                                <li><a href="{{ route('penilaian.rekap-perangkingan') }}"><i class="fa fa-circle-o"
                                            style="color:blue"></i>Rekap Perangkingan</a></li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (in_array(Auth::user()->id_role, [1, 3, 4]))
                    {{-- Walas, GUru Mapel, Admin --}}
                    <li><a class="sidebar-sub-toggle"><i class="ti-file"></i> Prestasi <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            {{-- Wali Kelas dan Guru Mapel, dan Admin --}}
                            <li><a href="{{ route('prestasi.index') }}"><i class="fa fa-circle-o"
                                        style="color:Yellow"></i>Kelola Prestasi</a></li>
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->id_role == 5)
                    <li><a class="sidebar-sub-toggle"><i class="ti-file"></i> Monitoring <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{ route('absensi.rekap') }}"><i class="fa fa-circle-o"
                                        style="color:blue"></i>Absensi</a></li>
                            <li><a href="{{ route('penilaian.rekap') }}"><i class="fa fa-circle-o"
                                        style="color:blue"></i>Penilaian</a></li>
                            <li><a href="{{ route('penilaian.rekap-perangkingan') }}"><i class="fa fa-circle-o"
                                        style="corgb(0, 247, 255)blue"></i>Perangkingan</a></li>
                        </ul>
                    </li>
                    {{-- GUru BK --}}
                    <li><a class="sidebar-sub-toggle"><i class="ti-file"></i> Siswa Bermasalah <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{ route('siswabermasalah.index') }}"><i class="fa fa-circle-o"
                                        style="color:blue"></i>Rekap Siswa bermasalah</a></li>
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->id_role == 6)
                    {{-- Orang Tua Siswa --}}
                    <li><a class="sidebar-sub-toggle"><i class="ti-file"></i> Monitoring <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            {{-- Orang Tua --}}
                            <li><a href="{{ route('ortu.monitoring.index') }}"><i class="fa fa-circle-o"
                                        style="color:Yellow"></i>Monitoring Siswa</a></li>
                        </ul>
                    </li>
                @endif

                @if (Auth::user()->id_role == 2)
                    {{-- Kepala Sekolah --}}
                    <li><a class="sidebar-sub-toggle"><i class="ti-file"></i> Laporan <span
                                class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{ route('absensi.rekap') }}"><i class="fa fa-circle-o"
                                        style="color:Yellow"></i>Rekap Absensi</a></li>
                            <li><a href="{{ route('penilaian.rekap') }}"><i class="fa fa-circle-o"
                                        style="color:blue"></i>Rekap Penilaian</a></li>
                            <li><a href="{{ route('penilaian.rekap-perangkingan') }}"><i class="fa fa-circle-o"
                                        style="corgb(0, 247, 255)blue"></i>Rekap Perangkingan</a></li>
                            <li><a href="{{ route('prestasi.index') }}"><i class="fa fa-circle-o"
                                        style="color:white"></i>Rekap Prestasi</a></li>
                            <li><a href="{{ route('siswabermasalah.index') }}"><i class="fa fa-circle-o"
                                        style="color:green"></i>Rekap Siswa Bermasalah</a>
                            </li>

                    </li>
            </ul>
            </li>
            @endif

            <li><a href="{{ route('logout') }}"><i class="ti-power-off"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>
