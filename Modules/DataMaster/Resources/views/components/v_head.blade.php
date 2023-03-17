<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- theme meta -->
    <meta name="theme-name" content="focus" />
 
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">
    <!-- Styles -->
    <link href="{{ asset('template/css/lib/calendar2/pignose.calendar.min.css')}}" rel="stylesheet">
    {{-- <link href="{{ asset('template/css/lib/chartist/chartist.min.css')}}" rel="stylesheet"> --}}
    <link href="{{ asset('template/css/lib/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/lib/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('template/css/lib/owl.theme.default.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('template/css/lib/weather-icons.css')}}" rel="stylesheet" />
    <link href="{{ asset('template/css/lib/menubar/sidebar.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/lib/helper.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/style.css')}}" rel="stylesheet"> 
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
  

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    
    {{-- CKEDITOR --}}
    <script src="{{asset('template/ckeditor4/ckeditor.js')}}"></script>

    {{-- SweetAlert --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

    {{-- DataTable --}}
    {{-- // css --}}
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">  
    {{-- // Js --}}
    {{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script> --}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />

    

    {{-- <script type="text/javascript">
        var onloadCallback = function() {
          alert("grecaptcha is ready!");
        };
    </script> --}}

    {{-- <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
    </script> --}}
</head>