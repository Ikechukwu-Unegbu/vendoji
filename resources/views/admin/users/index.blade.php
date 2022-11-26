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
    <table class="table">
        <thead><H5>Active User Tables</H5></thead>
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th>Phone</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
    <tr>
      <th scope="row">{{$user->id}}</th>
      <td>{{$user->name}}</td>
      <td>{{$user->email}}</td>
      <td>{{$user->phone}}</td>
      <td>
        <a href="{{route('panel.users.show', [$user->id])}}" class="btn btn-sm"><i class="fa-solid fa-eye"></i></a>
        <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#block-{{$user->id}}"><i class="fa-solid fa-ban"></i></button>
      </td>
    </tr>
    @include('admin.users.include._block_modal')
    @endforeach
  
  </tbody>
  <div style="" class="">{{$users->links()}}</div>
</table>
    </div>
</main>
@endsection 