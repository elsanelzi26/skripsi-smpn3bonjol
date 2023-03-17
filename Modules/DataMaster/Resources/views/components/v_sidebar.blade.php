<div class="sidebar sidebar-hide-to-small sidebar-shrink sidebar-gestures">
    <div class="nano">
        <div class="nano-content">
            <ul>
                <div class="logo"><a href="{{ asset('template/index.html')}}">
                        <!-- <img src="{{ asset('template/images/logo.png')}}" alt="" /> --><span>SITERUNG</span></a></div>
                <li class="label">Menu Administrator</li>

                <li><a href="{{ route('dashboard') }}"><i class="ti-home" style="color:purple"></i>Dashboard</a></li>

                @if(auth()->user()->role=="1")
                  

                    <li><a class="sidebar-sub-toggle"><i class="ti-server"></i> Data Master <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{ route('jeniskelamin.index') }}"><i class="fa fa-circle-o" style="color:purple"></i>Jenis Kelamin</a></li>
                            <li><a href="{{ route('pendidikan.index') }}"><i class="fa fa-circle-o" style="color:cyan"></i>Pendikan</a></li>
                            <li><a href="{{ route('agama.index') }}"><i class="fa fa-circle-o" style="color:red"></i>Agama</a></li>
                            <li><a href="{{ route('detailuser.index') }}"><i class="fa fa-circle-o" style="color:white"></i>Manajemen User</a></li>
                        </ul>
                    </li> 

                  

                    
                    <li><a href="{{ route('validasipermohonanadmin.index') }}"><i class="ti-home" style="color:purple"></i>Validasi Permohonan</a></li>

                    <li><a class="sidebar-sub-toggle"><i class="ti-server"></i> Laporan <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href=""><i class="fa fa-circle-o" style="color:purple"></i>DP Diajukan</a></li>
                            <li><a href=""><i class="fa fa-circle-o" style="color:cyan"></i>DP Diterbitkan</a></li>
                            <li><a href=""><i class="fa fa-circle-o" style="color:red"></i>DP Perskala TR</a></li>
                            <li><a href=""><i class="fa fa-circle-o" style="color:white"></i>DP Perkecamatan Kelurahan</a></li>
                        </ul>
                    </li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-server"></i> Grafik <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href=""><i class="fa fa-circle-o" style="color:purple"></i>JP Diajukan</a></li>
                            <li><a href=""><i class="fa fa-circle-o" style="color:cyan"></i>JP Diterbitkan</a></li>
                            <li><a href=""><i class="fa fa-circle-o" style="color:red"></i>JP Perkecamatan Kelurahan</a></li>
                        </ul>
                    </li>
                    
                    <li><a href=""><i class="ti-home" style="color:purple"></i>Cetak Permohonan</a></li>
                @endif

                @if(auth()->user()->role=="2")
                    <li><a href="{{ route('disposisipermohonankasie.index') }}"><i class="ti-home" style="color:white"></i>Disposisi Permohonan</a></li>
                @endif

                @if(auth()->user()->role=="3")
                    <li><a href="{{ route('disposisipermohonankabid.index') }}"><i class="ti-home" style="color:white"></i>Disposisi Permohonan</a></li>
                @endif

                @if(auth()->user()->role=="4")
                    <li><a href="{{ route('disposisipermohonankadis.index') }}"><i class="ti-home" style="color:white"></i>Disposisi Permohonan</a></li>

                    <li><a class="sidebar-sub-toggle"><i class="ti-server"></i> Laporan <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{ route('datapermohonandiajukan.index') }}"><i class="fa fa-circle-o" style="color:purple"></i>DP Diajukan</a></li>
                            <li><a href="{{ route('datapermohonanditerbitkan.index') }}"><i class="fa fa-circle-o" style="color:cyan"></i>DP Diterbitkan</a></li>
                            <li><a href="{{ route('datapermohonanjenisskala_tingkatresiko.index') }}"><i class="fa fa-circle-o" style="color:red"></i>DP Perskala TR</a></li>
                            <li><a href="{{ route('datapermohonankecamatan_kelurahan.index') }}"><i class="fa fa-circle-o" style="color:white"></i>DP Perkecamatan Kelurahan</a></li>
                        </ul>
                    </li>
                    <li><a class="sidebar-sub-toggle"><i class="ti-server"></i> Grafik <span class="sidebar-collapse-icon ti-angle-down"></span></a>
                        <ul>
                            <li><a href="{{ route('jumlah_permohonan_diajukan.index') }}"><i class="fa fa-circle-o" style="color:purple"></i>JP Diajukan</a></li>
                            <li><a href="{{ route('jumlah_permohonan_diterbitkan.index') }}"><i class="fa fa-circle-o" style="color:cyan"></i>JP Diterbitkan</a></li>
                            <li><a href="{{ route('jumlah_permohonan_perkecamatan.index') }}"><i class="fa fa-circle-o" style="color:red"></i>JP Perkecamatan Kelurahan</a></li>
                        </ul>
                    </li>
                    <li><a href=""><i class="ti-home" style="color:purple"></i>Cetak Permohonan</a></li>
                @endif

                @if(auth()->user()->role=="5")
                <li><a href="{{ route('ajukanpermohonan.index') }}"><i class="ti-home" style="color:purple"></i>Ajukan Permohonan</a></li>
                <li><a href=""><i class="ti-home" style="color:purple"></i>Cetak Permohonan</a></li>
                @endif
                    
                <li><a href="{{ route('logout') }}"><i class="ti-close"></i> Logout</a></li>
            </ul>
        </div>
    </div>
</div>