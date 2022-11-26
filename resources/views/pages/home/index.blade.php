@extends('layouts.public')

@section('head')
<style>
  .coins-img{
    height: 5rem;
    width: 5rem;
    border-radius: 50%;
  }
</style>
@endsection

@section('content')
  @include('pages.partials._hero')
  <main class="" id="main">
      @include('pages.home.include._about')
      @include('pages.home.include._values')
      @include('pages.home.include._count')
      {{--@include('pages.home.include._features')--}}
      @include('pages.home.include._services')
      @include('pages.home.include._faq')
      @include('pages.home.include._team')
      @include('pages.home.include._testimonial')

      {{--@include('pages.home.include._blog')--}}
      @include('pages.home.include._contact')
      @include('pages.partials._footer')
  </main>
  <script>
    function contactus(){
      let phone = document.getElementById('phone');
      let email = document.getElementById('email');
      let subject = document.getElementById('subject')
      let message = document.getElementById('message')

    }
  </script>
@endsection 