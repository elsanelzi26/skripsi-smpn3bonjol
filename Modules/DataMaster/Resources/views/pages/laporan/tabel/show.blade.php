@extends('admin.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            @if(in_array(Auth::user()->kd_jabatan, $adm_glo))
            <h1>PPID Utama Kota Payakumbuh</h1>
            @else
            <h1>PPID Pembantu {{Auth::user()->mapping->ppidskpd->nama_skpd}}</h1>
            @endif
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Detail Data DIP</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fas fa-times"></i></button>
          </div>
        </div>
        <div class="card-body">
        	@foreach($dok as $d)
            <div class="col-md-12 col-sm-12">
            <iframe src="{{url('dip_frame',['id_skpd'=>$d->id_skpd,'filename'=>$d->NAMA_FILE])}}" style="width: 100%; height: 465px"></iframe>
            <br><br>
            <div class="row">
              <div class="col-lg-3"><label>Judul Dokumen</label></div>
              <div class="col-lg-9">: {{$d->JUDUL_DOKUMEN}}</div>              
            </div>

            <div class="row">
              <div class="col-lg-3"><label>Organisasi</label></div>
              <div class="col-lg-9">: {{$d->nama_skpd}}</div>
            </div>

            <div class="row">
              <div class="col-lg-3"><label>Jenis Informasi</label></div>
              <div class="col-lg-9">: {{$d->nm_jenis}}</div>
            </div>

            <div class="row">
              <div class="col-lg-3"><label>Tipe File</label></div>
              <div class="col-lg-9">: {{$d->tipedok}} </div>
            </div>

            <div class="row">
              <div class="col-lg-3"><label>Download</label></div>
              <div class="col-lg-9"><form action="{{route('download_dip', ['id_skpd'=> $d->id_skpd, 'filename'=> $d->NAMA_FILE])}}"><button id="download" type="submit" class="btn btn-primary btn-xs"><i class="fa fa-download"></i></button></form></div>
            </div>
            </div>
        	@endforeach
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          PPID Kota Payakumbuh
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

@endsection