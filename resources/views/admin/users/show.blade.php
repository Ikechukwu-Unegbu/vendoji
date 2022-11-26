@extends('layouts.admin')

@section('header')
<link rel="stylesheet" href="{{asset('shared_dasboard\css\admin\user\show.css')}}">
@endsection

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->
  <div class="">
    <div class="image-holder">
        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1528&q=80" alt="">
    </div>
    <hr style="">
    <div class="user-deets">
        <div class="user-deets-left">
            <h5 class="text-center">Personal Info</h5>
            <div class="deet">
                <span class="value">Profile Status : </span>
                <span>@if($user->block == null) <span> Active</span> @else <span> Blocked<span> @endif</span>
            </div>
            <div class="deet">
                <span class="value">Name : </span>
                <span>{{$user->name}}</span>
            </div>   
            <div class="deet">
                <span class="value">Email : </span>
                <span>{{$user->email}}</span>
            </div>
            <div class="deet">
                <span class="value">Gender : </span>
                <span>{{$user->gender}}</span>
            </div>
            <div class="deet">
                <span class="value">State : </span>
                <span>{{$user->state}}</span>
            </div>
            <div class="deet">
                <span class="value">Town : </span>
                <span>{{$user->town}}</span>
            </div>
            <div class="deet">
                <span class="value">Access Level : </span>
                <span>{{$user->access}}</span>
            </div>
        </div>
        <!-- user deets right begins -->
        <div class="user-deets-right">
            <h5 class="text-center">Next Of Kins</h5>
        </div>
    </div>
 
  </div>
</main>
@endsection 