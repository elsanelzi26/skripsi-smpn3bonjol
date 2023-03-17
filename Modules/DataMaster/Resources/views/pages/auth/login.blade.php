
<!DOCTYPE html>
<html lang="en">

    @include('datamaster::components.v_head')

<body class="bg-primary" style="background-image: url(/template/background3.jpg); background-size: 100%; opacity:0.9">
    <div class="unix-login">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="index.html"><span style="color:blueviolet">SITERUNG UNGU</span></a>
                            {{-- <div class="row">
                                <div class="col-md-8">
                                    <div class="logo text-center">
                                        @if(session('message'))
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <i class="fa fa-times-circle"></i> {{session('message')}}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="login-logo">
                            @if(Session::has('message'))
                            <p class="alert alert-danger">{{ Session::get('message') }}</p>
                            @endif
                        </div>
                        <div class="login-form" style="border: 10px ridge purple;">
                            <h4 style="color:blueviolet">Login</h4>
                            <form action="{{ route('proses_login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="username" class="control-label sr-only">Username</label>
                                    <input type="text" name="username" class="form-control" id="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="control-label sr-only">Password</label>
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                                <div class="register-link m-t-15 text-center">
                                    <p>Don't have account ? <a href="{{ route('register.index') }}"> Sign Up Here</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('datamaster::components.v_script')

    @include('sweetalert::alert')
</body>

</html>