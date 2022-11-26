<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('shared_dasboard\vendor\bootstrap\css\bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('shared_dasboard\vendor\bootstrap-icons\bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('shared_dasboard\vendor\boxicons\css\boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('shared_dasboard\vendor\quill\quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('shared_dashboard/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('shared_dashboard/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('shared_dasboard\vendor\quill\quill.snow.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('shared_dasboard\css\style.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="{{ asset('shared_dasboard/js/jquery.js') }}"></script>
  <script src="{{ asset('shared_dasboard/js/alpine.min.js') }}" defer></script>
  <script src="{{ asset('shared_dasboard/js/chartjs.js') }}"></script>
  <style>
        .hidden-xs-up{display:none!important}
        @media (max-width:600px){.respond {text-align: center !important}}
    </style>
  @yield('header')

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.3.1
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  @include('partials.admin._top')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
    @include('partials.admin._sidebar')
  <!-- End Sidebar-->

    @yield('content')
  <!-- End #main -->

  @include('partials.admin._footer')
  @stack('scripts')
  <x-toastr />
</body>

</html>
