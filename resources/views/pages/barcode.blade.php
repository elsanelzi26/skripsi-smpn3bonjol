@extends('datamaster::layouts.master')
@section('title', 'Data Chart JS')
@section('content')

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                           @yield('title')
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="">Dashboard</a></li>
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
                    <!-- /# column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-title pr">
                                <h4>List @yield('title')</h4>
                            </div>
                            <div class="card-body" style="margin-top:40px">
                                <div id="container">
                                    <h1>Barcode</h1>
                                    <div class="container mt-4">
                                        <div class="mb-3">{!! DNS2D::getBarcodeHTML("$productCode", 'QRCODE') !!}</div>
                                        {{-- <div class="mb-3">{!! DNS2D::getBarcodeHTML("$productCode", 'DATAMATRIX') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'C39') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'C39+') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'C39E') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'C39E+') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'C93') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'S25') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'S25+') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'I25') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'I25+') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'C128') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'C128A') !!}</div> --}}
                                        {{-- <div class="mb-3">{!! DNS1D::getBarcodeHTML("$productCode", 'C128B') !!}</div>  --}}
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <!-- /# column -->
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
@endsection





