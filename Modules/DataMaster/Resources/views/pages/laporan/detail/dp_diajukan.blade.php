{{-- Detail DP Diajukan
<td> <a href="{{asset('image/rka/'.$row->file_rka)}}" target="__blank">{{ $row->file_rka }}</a></td>  --}}

@extends('datamaster::layouts.master')
@section('title', 'Data Permohonan Diajukan Per Tanggal')
@section('content')
<div class="content-wrap">
  <div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>@yield('title')</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
            </div>
            <!-- /# row -->
            <section id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card bg-primary">
                            <div class="weather-widget">
                                <div id="weather-one" class="weather-one" style="padding:-20px">
                                  <h6>Detail @yield('title')</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                          <div class="row">
                            <div class="col-lg-3"><label>Judul Dokumen</label></div>
                            <div class="col-lg-9">: Judul Dokumen</div>              
                          </div>
              
                          <div class="row">
                            <div class="col-lg-3"><label>Organisasi</label></div>
                            <div class="col-lg-9">: organisasi</div>
                          </div>
              
                          <div class="row">
                            <div class="col-lg-3"><label>Jenis Informasi</label></div>
                            <div class="col-lg-9">: Jenis Informasi</div>
                          </div>
                        </div>
                    </div>
                </div>
                <!-- /# row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer">
                            <p>2018 © Admin Board. - <a href="#">example.com</a></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</div>

@endsection