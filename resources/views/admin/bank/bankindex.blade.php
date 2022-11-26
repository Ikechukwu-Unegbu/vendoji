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
    <div class="container">
        <div class="">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add Bank 
            </button>
        </div>
        <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Bank Name</th>
                <th scope="col">Account No.</th>
                <th scope="col">Account Name</th>
                <th>Phone</th>
                <th scope="col">Actions</th>
              
                </tr>
            </thead>
            <tbody>
               @foreach($banks as $bank)
               <tr>
                    <th scope="row">{{$bank->id}}</th>
                    <td>{{$bank->bank_name}}</td>
                    <td>{{$bank->account_number}}</td>
                    <td>{{$bank->account_name}}</td>
                    <td>{{$bank->phone}}</td>
                    <td>
                        @if($bank->state == 0)
                        <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#bank-{{$bank->id}}">Activate</button>
                        @else 
                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#bank-stop-{{$bank->id}}">Deactivate</button>
                        @endif
                    </td>
                </tr>
                @include('admin.bank.include._activate_deactivate_modals')
               @endforeach
               
            </tbody>
        </table>
        </div>
    </div>
</div>
</main>
@include('admin.bank.include._new_bank')
@endsection 