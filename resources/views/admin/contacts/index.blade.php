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
            @foreach($contacts as $contact)
            <tr>
            <th scope="row">{{$contact->id}}</th>
            <td>{{$contact->name}}</td>
            <td>{{$contact->email}}</td>
            <td>{{$contact->phone}}</td>
            <td>@if($contact->solved ==1) <i class="fa-solid fa-check"></i> @else <i class="fa-solid fa-xmark"></i> @endif</td>
            <td>
                <button data-bs-toggle="modal" data-bs-target="#view-{{$contact->id}}" class="btn btn-sm"><i class="fa-solid fa-eye"></i></button>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#resolve-{{$contact->id}}"><i class="fa-solid fa-ban"></i></button>
            </td>
            </tr>
            {{--@include('admin.users.include._block_modal')--}}
            @include('admin.contacts.include._view_message')
            @include('admin.contacts.include._resolved')
            @endforeach
        
        </tbody>
        <div style="" class="">{{$contacts->links()}}</div>
    </table>
</div>
</main>
@endsection 