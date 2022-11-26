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
    <!-- <div class=""> -->
       {{-- @include('admin.users.include._quick_stats')--}}
    <table class="table">
        <thead><H5>User's Inquiries</H5></thead>
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            
            <tr>
            <th scope="row"></th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                <button data-bs-toggle="modal" data-bs-target="#view" class="btn btn-sm"><i class="fa-solid fa-eye"></i></button>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#resolve"><i class="fa-solid fa-ban"></i></button>
            </td>
            </tr>
         
        
        </tbody>
        <div style="" class=""></div>
    </table>
</div>
</main>
@endsection 