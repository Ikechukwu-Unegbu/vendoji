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
        <form action="{{route('login')}}" method="POST" class="form">
          <h3 class="text-center">Log Into Your Account </h3>
          @csrf
          <div class="form-group">
            @include('partials._message')
          </div>

          <div class="form-group mt-4">
            <label for="" class="form-label">Email</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="form-group mt-4">
            <label for="" class="form-label">Password</label>
            <input type="password" name="password" class="form-control"/>
          </div>
            <div class="form-group mt-4">
                <span>remember me? </span><input type="checkbox" name="remember_me">
            </div>
            <div class="form-group mt-4">
              <span>Don't have account? 
              </span><a href="{{route('register')}}">Click here</a>
            </div>
          <div class="form-group mt-4">
            <button style="float:right;" class="btn btn-sm btn-primary">Login</button>
          </div>
        </form>
      </div>
      @include('pages.partials._footer')
  </main>
@endsection
