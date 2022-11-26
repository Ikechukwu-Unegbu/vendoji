@extends('layouts.admin')

@section('header')
<link rel="stylesheet" href="{{asset('shared_dasboard\css\admin\user\index.css')}}">
<style>
  .card-holder{
    display:flex;
    grid-gap: 2rem;
    padding-top: 5rem;
  }
</style>
@endsection

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <!-- <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav> -->
  @include('partials._message')
</div><!-- End Page Title -->
    <!-- <div class=""> -->
       {{-- @include('admin.users.include._quick_stats')--}}
    <div class="container">
        <!-- <div class="">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Add Bank 
            </button>
        </div> -->
        <div class="card-holder">
        {{--<table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">name</th>
              <th scope="col">amount</th>
              <th scope="col">type</th>
              <th scope="col">Approv</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($trnsfers as $trfer)
            <tr>
              <th scope="row">{{$trfer->id}}</th>
              <td><a href="{{route('panel.users.show', [$trfer->user->id])}}">{{$trfer->user->name}}</a></td>
              <td>{{$trfer->amount}}</td>
              <td>
                @if($trfer->type == 1)
                  <span style="font-weight:bold; color: green;">Credit</span>
                @else
                 <span style="font-weight:bold; color:red;"> Debit</span>
                @endif
              </td>
              <td>
                @if($trfer->approval == 1)
                  <span class="text-dark text-center">Approved</span>
                @else 
                  <span class="text-dark text-center">Pending...</span>
                @endif
              </td>
              <td>
                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#approve-{{$trfer->id}}">Approve</button>
                <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#info-{{$trfer->id}}">Info</button>
              </td>
            </tr>
            @include('admin.bank.transfer.includes.banktransfer_modals')
            @endforeach
         
          </tbody>
        </table>--}}
          <div class="card">
            <div class="card-body">
              <a href="{{route('panel.banktransfer.credit')}}" class="btn btn-sm btn-primary">Credit</a>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <a href="{{route('panel.banktransfer.debit')}}" class="btn btn-sm btn-secondary">
                Debit
              </a>
            </div>
          </div>
        </div>
    </div>
</div>
</main>

@endsection 