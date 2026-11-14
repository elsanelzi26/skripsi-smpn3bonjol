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
    <link href="{{ asset('template/css/lib/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/lib/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('template/css/lib/owl.theme.default.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('template/css/lib/weather-icons.css')}}" rel="stylesheet" />
    <link href="{{ asset('template/css/lib/menubar/sidebar.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/lib/helper.css')}}" rel="stylesheet">
    <link href="{{ asset('template/css/style.css')}}" rel="stylesheet"> 

    <style>
      .modal .close {
        font-size: 2rem; /* Perbesar ukuran */
        padding: 0; /* Hilangkan padding */
        line-height: 1; /* Sesuaikan tinggi baris */
        position: absolute; /* Posisi absolut untuk menempel ke sudut */
        top: 10px; /* Jarak dari atas */
        right: 10px; /* Jarak dari kanan */
        color: #000; /* Warna teks close */
        opacity: 1; /* Pastikan terlihat jelas */
        z-index: 1051; /* Pastikan berada di atas elemen lain */
    }
    .modal .close:hover {
        color: #ff0000; /* Tambahkan efek hover jika perlu */
    }
       /* Gaya khusus untuk memperbesar lebar modal */
       .modal-dialog {
        max-width: 800px; /* Sesuaikan ukuran lebar */
        width: 100%; /* Pastikan modal responsif */
    }
</style>

<style>
    /* Menggeser Search ke Kanan */
    #ajax-crud-datatable_filter {
        text-align: right;
    }
    #ajax-crud-datatable_filter label {
        display: inline-flex;
        align-items: center;
    }
    #ajax-crud-datatable_filter input {
        margin-left: 10px;
        border: 1px solid #e7e7e7;
        padding: 5px 10px;
        border-radius: 4px;
    }

    /* Mengatur Jarak Show Entries (Kiri) */
    #ajax-crud-datatable_length select {
        border: 1px solid #e7e7e7;
        padding: 5px;
        border-radius: 4px;
        margin: 0 5px;
    }

    /* Merapikan Info & Pagination (Bawah) */
    .dataTables_info {
        padding-top: 15px !important;
    }
    .dataTables_paginate {
        text-align: right !important;
        padding-top: 10px !important;
    }
    .paginate_button {
        padding: 5px 12px !important;
        margin-left: 5px !important;
        border: 1px solid #ddd !important;
        border-radius: 4px !important;
        cursor: pointer;
    }
    .paginate_button.current {
        background: #343957 !important;
        color: white !important;
        border: 1px solid #343957 !important;
    }
</style>


</head>