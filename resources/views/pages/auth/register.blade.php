@extends('layouts.public')

@section('head')
<style>
  .cont{
    width: 60%;
    margin-top: 7rem;
    padding-bottom: 5rem;
  }
</style>
@endsection

@section('content')
{{--@include('pages.partials._hero')--}}
  <main class="" id="main mb-5">
      <div class="cont container">
        <form action="{{route('register')}}" method="POST" class="form">
          <h3 class="text-center">Create Account and Get Started</h3>
          @csrf
          <div class="form-group">
            @include('partials._message')
          </div>
          <div class="form-group mt-4">
            <label for="" class="form-label">Username</label>
            <input type="text" name="name" class="form-control">
          </div>
          <div class="form-group mt-4">
            <label for="" class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="form-group mt-4">
            <label for="" class="form-label">Password</label>
            <input type="password" for="" name="password" class="form-control"/>
          </div>
          <div class="form-group mt-4">
            <label for="" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control">
          </div>
          <div class="form-group mt-4">
            Do you have account alread? <a href="{{route('login')}}">Click here to login</a>
            <!-- <input type="text" class="form-control"> -->
          </div>
          <div class="mt-3">
            <input class="form-check-input" type="radio" name="terms" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
              <a href="" class="">Terms and Conditions</a>
            </label>
          </div>
          <div class="form-group mt-4">
            <button style="float:right;" class="btn btn-sm btn-primary">Register</button>
          </div>
        </form>
      </div>
      @include('pages.partials._footer')
  </main>
@endsection
