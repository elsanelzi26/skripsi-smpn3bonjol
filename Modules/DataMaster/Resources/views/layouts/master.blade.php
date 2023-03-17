<!DOCTYPE html>
<html lang="en">

@include('datamaster::components.v_head')
<body>

    @include('datamaster::components.v_sidebar')
    <!-- /# sidebar -->

    @include('datamaster::components.v_header')


    @yield('content')
    @include('datamaster::components.v_script')
</body>

</html>
