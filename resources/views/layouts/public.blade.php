<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title> Vendoji</title>
  <meta content="" name="description">

  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('pages\vendor\aos\aos.css')}}" rel="stylesheet">
  <link href="{{asset('pages\vendor\bootstrap\css\bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('pages\vendor\bootstrap-icons\bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('pages\vendor\glightbox\css\glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('pages\vendor\remixicon\remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('pages\vendor\swiper\swiper-bundle.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Template Main CSS File -->
  <link href="{{asset('pages\css\style.css')}}" rel="stylesheet">
    @yield('head')
  <!-- =======================================================
  * Template Name: FlexStart - v1.10.1
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <script src="//code.jivosite.com/widget/ZYj9rILMwT" async></script>

</head>

<body>

  <!-- ======= Header ======= -->
    @include('pages.partials._navmenu')
  <!-- End Header -->

  @yield('content')

</body>

</html>