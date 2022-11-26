@extends('layouts.admin')

@section('header')
<link rel="stylesheet" href="{{asset('shared_dasboard\css\admin\user\index.css')}}">
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
  @include('partials._message')
</div><!-- End Page Title -->
    <div class="">
        @include('admin.users.include._quick_stats')
    
        <div style="" class="">
          <button class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#new-lock">
              New Duration
          </button>
        </div>
        @include('admin.lock.include._lock_table')
    </div>
</main>
@include('admin.lock.include._new_lock_modal')
@endsection 