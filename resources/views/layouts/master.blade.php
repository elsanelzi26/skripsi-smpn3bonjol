<!DOCTYPE html>
<html lang="en">
@include('components.v_head')
<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    .content-wrap {
        min-height: 100vh;

        background-image:
            linear-gradient(
                rgba(255,255,255,0.75),
                rgba(255,255,255,0.75)
            ),
            url("{{ asset('template/bg_sekolah.jpg') }}");

        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
</style>
<body>
    @include('components.v_sidebar')
    @include('components.v_header')

    @yield('content')

    @include('components.v_script')

    @yield('scripts') 
</body>
</html>