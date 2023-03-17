<!DOCTYPE html>
<html lang="en">

    @include('datamaster::components.v_head')

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    @section('title', 'Register User')

<body style="background-image: url(/template/background1.jpg); background-size: 100%; opacity:0.9">
  
    <div class="unix-login">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="index.html"><span>SITERUNG UNGU</span></a>
                        </div>
                        <div class="login-form" style="border: 10px ridge purple;">
                            <h4>Register User</h4>
                            <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-lg-12 col-form-label" for="nama_pemohon">Nama Pemohon <span class="text-danger">*</span></label>
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control @error('nama_pemohon') is-invalid @enderror" id="nama_pemohon" name="nama_pemohon" placeholder="Masukan Nama Pemohon.." value="{{ old('nama_pemohon') }}" autofocus required>
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
                                                <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" placeholder="Masukan NIK.." value="{{ old('nik') }}" required onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="16">
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
                                                <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp" name="npwp" placeholder="Masukan NPWP.." value="{{ old('npwp') }}" required>
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
                                        <textarea name="alamat_pemohon" id="alamat_pemohon" class="form-control @error('alamat_pemohon') is-invalid @enderror" cols="30" rows="10" required>{{ old('alamat_pemohon') }}</textarea>
                                    </div>
                                    @error('alamat_pemohon')
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
                                    <div class="col-lg-4">
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
                                    <div class="col-lg-4">
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
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="col-lg-12 col-form-label" for="telepon">Telepon <span class="text-danger">*</span></label>
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" placeholder="Masukan Telepon.." value="{{ old('telepon') }}" required onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="18">
                                            </div>
                                            @error('telepon')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-lg-12 col-form-label" for="email">Email <span class="text-danger">*</span></label>
                                        <div class="col-lg-12">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukan Email.." value="{{ old('email') }}" required>
                                        </div>
                                        @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-lg-12 col-form-label" for="username">Username <span class="text-danger">*</span></label>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Masukan Username.." value="{{ old('username') }}" required>
                                        </div>
                                        @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-lg-12 col-form-label" for="password">Password <span class="text-danger">*</span></label>
                                        <div class="col-lg-12">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="************"  required>
                                        </div>
                                        @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="col-lg-12 col-form-label" for="confirm_password">confirm_Password <span class="text-danger">*</span></label>
                                        <div class="col-lg-12">
                                            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="************" required>
                                        </div>
                                        @error('confirm_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                               
                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Register</button>
                               
                                <div class="register-link m-t-15 text-center">
                                    <p>Already have account ? <a href="{{ route('login') }}"> Sign in</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
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
        });

       
</script>

</body>

</html>