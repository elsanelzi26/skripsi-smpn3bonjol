@extends('datamaster::layouts.master')
@section('title', 'Form Ajukan Permohonan')
@section('content')
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                           @yield('content')
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
                        <form action="{{ route('ajukanpermohonan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-lg-12 col-form-label" for="nama_pemohon">Nama Pemohon <span class="text-danger">*</span></label>
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control @error('nama_pemohon') is-invalid @enderror" id="nama_pemohon" name="nama_pemohon" placeholder="Masukan Nama Pemohon.." value="{{$datauserpemohon['nama_pemohon'], old('nama_pemohon') }}" autofocus required readonly>
                                            </div>
                                            @error('nama_pemohon')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-lg-12 col-form-label" for="nik">NIK <span class="text-danger">*</span></label>
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" placeholder="Masukan NIK.." value="{{ $datauserpemohon['nik'], old('nik') }}" required onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="16" readonly>
                                            </div>
                                            @error('nik')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-lg-12 col-form-label" for="npwp">NPWP <span class="text-danger">*</span></label>
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp" name="npwp" placeholder="Masukan NPWP.." value="{{$datauserpemohon['npwp'], old('npwp') }}" required readonly>
                                            </div>
                                            @error('npwp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="alamat_pemohon">Alamat Pemohon <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <textarea name="alamat_pemohon" id="alamat_pemohon" class="form-control @error('alamat_pemohon') is-invalid @enderror" cols="30" rows="10" required readonly>{{ $datauserpemohon['alamat_pemohon'], old('alamat_pemohon') }}</textarea>
                                    </div>
                                    @error('alamat_pemohon')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="hr" style="border-top: 5px solid black;"></div>
                            
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="nama_pemilik_tanah">Nama Pemilik Tanah <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control @error('nama_pemilik_tanah') is-invalid @enderror" id="nama_pemilik_tanah" name="nama_pemilik_tanah" placeholder="Masukan Nama Pemilik Tanah.." value="{{ old('nama_pemilik_tanah') }}" required>
                                    </div>
                                    @error('nama_pemilik_tanah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="nama_pemilik_bangunan">Nama Pemilik Bangunan <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control @error('nama_pemilik_bangunan') is-invalid @enderror" id="nama_pemilik_bangunan" name="nama_pemilik_bangunan" placeholder="Masukan Nama Pemilik Bangunan.." value="{{ old('nama_pemilik_bangunan') }}" required>
                                    </div>
                                    @error('nama_pemilik_bangunan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="alamat_lokasi">Alamat Lokasi <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <textarea name="alamat_lokasi" id="alamat_lokasi" class="form-control @error('alamat_lokasi') is-invalid @enderror" cols="30" rows="10" required>{{ old('alamat_lokasi') }}</textarea>
                                    </div>
                                    @error('alamat_lokasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="provinsi">Provinsi <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <select class="@error('provinsi') is-invalid @enderror input-lg" id="provinsi" name="provinsi" value="{{old('provinsi')}}" style="width:100%">
                                        <option value="">--PILIH PROVINSI--</option>
                                        @foreach($provinces as $provinsi)
                                        <option value="{{ $provinsi->id }}">{{ $provinsi->name }}</option>
                                        @endforeach
                                        </select>
                                        <div class="text-danger">
                                            @error('provinsi')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="kabupaten">Kabupaten <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <select class="@error('kabupaten') is-invalid @enderror input-lg" id="kabupaten" name="kabupaten" value="{{old('kabupaten')}}" style="width:100%">
                                            <option value="">--PILIH KABUPATEN--</option>
                                        </select>
                                        <div class="text-danger">
                                            @error('kabupaten')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="kecamatan">Kecamatan <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <select class="@error('kecamatan') is-invalid @enderror input-lg" id="kecamatan" name="kecamatan" value="{{old('kecamatan')}}" style="width:100%">
                                            <option value="">--PILIH KECAMATAN--</option>
                                            
                                        </select>
                                        <div class="text-danger">
                                            @error('kecamatan')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="kelurahan">Kelurahan <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <select class="@error('kelurahan') is-invalid @enderror input-lg" id="kelurahan" name="kelurahan" value="{{old('kelurahan')}}" style="width:100%">
                                            <option value="">--PILIH KELURAHAN--</option>
                                    
                                        </select>
                                        <div class="text-danger">
                                            @error('kelurahan')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-lg-12 col-form-label" for="rt">RT <span class="text-danger">*</span></label>
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name="rt" placeholder="Masukan RT.." value="{{ old('rt') }}" required>
                                            </div>
                                            @error('rt')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="col-lg-12 col-form-label" for="rw">RW <span class="text-danger">*</span></label>
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" name="rw" placeholder="Masukan RW.." value="{{ old('rw') }}" required>
                                            </div>
                                            @error('rw')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input type="checkbox" id="cek_status" name="cek_status"> Pilih jika data sama dengan users
                                    </div>
                                </div>

                                <div class="hr" style="border-top: 5px solid black;"></div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <label for="luas_tanah_yang_dimohon">Luas Tanah yang dimohon</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <input type="text" class="form-control" name="luas_tanah_yang_dimohon" id="luas_tanah_yang_dimohon" onkeypress="return event.charCode>=48 && event.charCode<=57">
                                            </div>
                                            <div class="input-group-text">m2</div>
                                        </div>
                                        @error('luas_tanah_yang_dimohon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="luas_bangunan_yang_dimohon">Luas Bangunan yang dimohon</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <input type="text" class="form-control" name="luas_bangunan_yang_dimohon" id="luas_bangunan_yang_dimohon" onkeypress="return event.charCode>=48 && event.charCode<=57">
                                            </div>
                                            <div class="input-group-text">m2</div>
                                        </div>
                                        @error('luas_bangunan_yang_dimohon')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="nama_usaha">Nama Usaha <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control @error('nama_usaha') is-invalid @enderror" id="nama_usaha" name="nama_usaha" placeholder="Masukan Nama Usaha.." value="{{ old('nama_usaha') }}" required>
                                    </div>
                                    @error('nama_usaha')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <label for="modal_usaha">Modal Usaha</label>
                                        <div class="input-group mb-2">
                                            <div class="input-group-text">Rp</div>
                                            <div class="input-group-prepend">
                                                <input type="text" class="form-control" name="modal_usaha" id="modal_usaha" size="10" onkeypress="return event.charCode>=48 && event.charCode<=57">
                                            </div>
                                            <div class="input-group-text">00</div>
                                        </div>
                                    </div>
                                    @error('modal_usaha')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="skala_usaha">Skala Usaha <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <select class="@error('skala_usaha') is-invalid @enderror input-lg" id="skala_usaha" name="skala_usaha" value="{{old('skala_usaha')}}" style="width:100%">
                                            <option value="">--PILIH SKALA USAHA--</option>
                                            <option value="Mikro">Mikro</option>
                                            <option value="Makro">Makro</option>
                                        </select>
                                        <div class="text-danger">
                                            @error('skala_usaha')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-12 col-form-label" for="tingkat_resiko">Tingkat Resiko <span class="text-danger">*</span></label>
                                    <div class="col-lg-12">
                                        <select class="@error('tingkat_resiko') is-invalid @enderror input-lg" id="tingkat_resiko" name="tingkat_resiko" value="{{old('tingkat_resiko')}}" style="width:100%">
                                            <option value="">--PILIH TINGKAT RESIKO--</option>
                                            <option value="Rendah">Rendah</option>
                                            <option value="Menengah">Menengah</option>
                                            <option value="Tinggi">Tinggi</option>

                                        </select>
                                        <div class="text-danger">
                                            @error('tingkat_resiko')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <input type="file" id="ktp" name="ktp" style="display: none" onchange="document.getElementById('filename_ktp').value=this.value" value="{{old('ktp')}}">
                                            <input type="text" id="filename_ktp" placeholder="Browse KTP" class="form-control" readonly onclick="document.getElementById('ktp').click()">
                                        <span class="input-group-btn">
                                            <input type="button" value="Upload File" onclick="document.getElementById('ktp').click()" class="btn btn-primary">
                                            @error('ktp')
                                        </span>
                                        <div class="text-danger invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <input type="file" id="sppt_pbb" name="sppt_pbb" style="display: none" onchange="document.getElementById('filename_sppt_pbb').value=this.value" value="{{old('sppt_pbb')}}">
                                            <input type="text" id="filename_sppt_pbb" placeholder="Browse SPPT & PBB" class="form-control" readonly onclick="document.getElementById('sppt_pbb').click()">
                                        <span class="input-group-btn">
                                            <input type="button" value="Upload File" onclick="document.getElementById('sppt_pbb').click()" class="btn btn-primary">
                                            @error('sppt_pbb')
                                        </span>
                                        <div class="text-danger invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <input type="file" id="bukti_kepemilikan" name="bukti_kepemilikan" style="display: none" onchange="document.getElementById('filename_bukti_kepemilikan').value=this.value" value="{{old('bukti_kepemilikan')}}">
                                            <input type="text" id="filename_bukti_kepemilikan" placeholder="Browse Bukti Kepemilikan" class="form-control" readonly onclick="document.getElementById('bukti_kepemilikan').click()">
                                        <span class="input-group-btn">
                                            <input type="button" value="Upload File" onclick="document.getElementById('bukti_kepemilikan').click()" class="btn btn-primary">
                                            @error('bukti_kepemilikan')
                                        </span>
                                        <div class="text-danger invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <input type="file" id="denah_lokasi" name="denah_lokasi" style="display: none" onchange="document.getElementById('filename_denah_lokasi').value=this.value" value="{{old('denah_lokasi')}}">
                                            <input type="text" id="filename_denah_lokasi" placeholder="Browse Denah Lokasi" class="form-control" readonly onclick="document.getElementById('denah_lokasi').click()">
                                        <span class="input-group-btn">
                                            <input type="button" value="Upload File" onclick="document.getElementById('denah_lokasi').click()" class="btn btn-primary">
                                            @error('denah_lokasi')
                                        </span>
                                        <div class="text-danger invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <input type="file" id="lembar_bidang_tanah" name="lembar_bidang_tanah" style="display: none" onchange="document.getElementById('filename_lembar_bidang_tanah').value=this.value" value="{{old('lembar_bidang_tanah')}}">
                                            <input type="text" id="filename_lembar_bidang_tanahs" placeholder="Browse Lembar Bidang" class="form-control" readonly onclick="document.getElementById('lembar_bidang_tanahs').click()">
                                        <span class="input-group-btn">
                                            <input type="button" value="Upload File" onclick="document.getElementById('lembar_bidang_tanah').click()" class="btn btn-primary">
                                            @error('lembar_bidang_tanah')
                                        </span>
                                        <div class="text-danger invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input type="checkbox" id="cek_status_kebenaran" name="cek_status_kebenaran"> Saya Menyatakan Bahwa Data yang saya adalah Benar
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Ajukan Permohonan</button>
                            </div>
                        </form>
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
<script>
      
    $(function(){
        $('#provinsi').on('change', function(){
            let id_provinsi = $('#provinsi').val();
            
            $.ajax({
                type : 'POST',
                url : '{{ route('getkabupaten') }}',
                data : {
                    "_token": "{{ csrf_token() }}",
                    "id_provinsi": id_provinsi,
                },
                cache : false,

                success : function(response){
                    $('#kabupaten').html(response);
                    $('#kecamatan').html('');
                    $('#kelurahan').html('');
                },

                error : function(error){
                    console.log('error: ',error);
                }

            });
        });

        $('#kabupaten').on('change', function(){
            let id_kabupaten = $('#kabupaten').val();   
            $.ajax({
                type : 'POST',
                url : '{{ route('getkecamatan') }}',
                data : {
                    "_token": "{{ csrf_token() }}",
                    "id_kabupaten": id_kabupaten,
                },
                cache : false,

                success : function(response){
                    $('#kecamatan').html(response);
                    $('#kelurahan').html('');
                },

                error : function(error){
                    console.log('error: ',error);
                }

            });
        });

        $('#kecamatan').on('change', function(){
            let id_kecamatan = $('#kecamatan').val();
            $.ajax({
                type : 'POST',
                url : '{{ route('getkelurahan') }}',
                data : {
                    "_token": "{{ csrf_token() }}",
                    "id_kecamatan": id_kecamatan,
                },
                cache : false,

                success : function(response){
                    $('#kelurahan').html(response);
                },

                error : function(error){
                    console.log('error: ',error);
                }

            });
        });
    });


    $(document).ready(function(){
        $('#provinsi').select2({
            allowClear : true,
        });
        $('#kabupaten').select2({
            allowClear : true,
        });
        $('#kecamatan').select2({
            allowClear : true,
        });
        $('#kelurahan').select2({
            allowClear : true,
        });

        $('#cek_status').click(function(){
            var status = document.getElementById('cek_status');
            if(status.checked){
                // console.log('1');
                $.ajax({
                    url : '{{ route('getwilayahsamausers') }}',
                    method: 'GET',
                    success : function(response){
                        $('#rt').val(response.datauserpemohon.rt);
                        $('#rw').val(response.datauserpemohon.rw);

                        var id_provinsi = response.datauserpemohon.provinsi;
                        var id_kabupaten = response.datauserpemohon.kabupaten;
                        var id_kecamatan = response.datauserpemohon.kecamatan;
                        var id_kelurahan = response.datauserpemohon.kelurahan;
                     

                        var htmlProvinsi = "<option value=''>--PILIH PROVINSI--</option>";
                        var htmlKabupaten = "<option value=''>--PILIH KABUPATEN--</option>";
                        var htmlKecamatan = "<option value=''>--PILIH KECAMATAN--</option>";
                        var htmlKelurahan = "<option value=''>--PILIH KELURAHAN--</option>";

                        var countProvinsi = (response['provinces']).length;
                        // var kecamatan = (response['districts']).length;
                        // var kelurahan = ()response['villages']).length;

                        for(let i = 0; i<countProvinsi; i++){
                            if(response['provinces'][i].id == id_provinsi){
                            htmlProvinsi += `<option value="`+response['provinces'][i].id+`" selected>`+response['provinces'][i].name+`</option>`;
                           
                            } else {
                                htmlProvinsi += `<option value="`+response['provinces'][i].id+`">`+response['provinces'][i].name+`</option>`;
                            }
                        }

                        $('#provinsi').html(htmlProvinsi);
                        $('#provinsi').attr("readonly", "readonly");

                        $.ajax({
                            type : 'POST',
                            url : '{{ route('getkabupatensamauser') }}',
                            data : {
                                "_token": "{{ csrf_token() }}",
                                "id_provinsi": id_provinsi,
                            },
                            cache : false,

                            success : function(response){
                                var countKabupaten = response.length;

                                for(let i = 0; i<countKabupaten; i++){
                                    if(response[i].id == id_kabupaten){
                                    htmlKabupaten += `<option value="`+response[i].id+`" selected>`+response[i].name+`</option>`;
                                    } else {
                                        htmlKabupaten += `<option value="`+response[i].id+`">`+response[i].name+`</option>`;
                                    }
                                }

                                $('#kabupaten').html(htmlKabupaten);

                                $.ajax({
                                    type : 'POST',
                                    url : '{{ route('getkecamatansamauser') }}',
                                    data : {
                                        "_token": "{{ csrf_token() }}",
                                        "id_kabupaten": id_kabupaten,
                                    },
                                    cache : false,
                                    success : function(response){
                                        var countKecamatan = response.length;

                                        for(let i = 0; i<countKecamatan; i++){
                                            if(response[i].id == id_kecamatan){
                                            htmlKecamatan += `<option value="`+response[i].id+`" selected>`+response[i].name+`</option>`;
                                            } else {
                                                htmlKecamatan += `<option value="`+response[i].id+`">`+response[i].name+`</option>`;
                                            }
                                        }

                                        $('#kecamatan').html(htmlKecamatan);

                                        $.ajax({
                                            type : 'POST',
                                            url : '{{ route('getkelurahansamauser') }}',
                                            data : {
                                                "_token": "{{ csrf_token() }}",
                                                "id_kecamatan": id_kecamatan,
                                            },
                                            cache : false,
                                            success : function(response){
                                                var countKelurahan = response.length;

                                                for(let i = 0; i<countKelurahan; i++){
                                                    if(response[i].id == id_kelurahan){
                                                    htmlKelurahan += `<option value="`+response[i].id+`" selected>`+response[i].name+`</option>`;
                                                    } else {
                                                        htmlKelurahan += `<option value="`+response[i].id+`">`+response[i].name+`</option>`;
                                                    }
                                                }

                                                $('#kelurahan').html(htmlKecamatan);
                                            },
                                            error : function(error){
                                                console.log('error: ',error);
                                            }

                                        });
                                    },
                                    error : function(error){
                                        console.log('error: ',error);
                                    }

                                });
                            },

                            error : function(error){
                                console.log('error: ',error);
                            }

                        });
                    },
                    error : function(error){
                        console.log(error);
                    }
                });
            } else {
                console.log('2');
            }
        });

       
        
    });

</script>
@endsection