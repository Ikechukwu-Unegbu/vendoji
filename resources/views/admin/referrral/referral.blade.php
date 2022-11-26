@extends('layouts.admin')

@section('header')
<link rel="stylesheet" href="{{asset('shared_dasboard\css\admin\user\index.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .cards-holder{
        display:grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-gap: 1rem;
    }
    .cards-holder .card{
        height: 6rem;
    }
    .cards-holder .card .card-body{
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
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
    <div>
        <div class="cards-holder">
            <div class="card bg-dark text-light">
                <div class="card-body text-light">
                    <h5 class="text-light">80</h5>
                </div>
            </div>
            <div class="card bg-primary text-light">
                <div class="card-body text-light">
                    <h5 class="text-light">80</h5>
                </div>
            </div>
            <div class="card bg-info text-light">
                <div class="card-body text-light">
                    <h5 class="text-light">80</h5>
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Referral Rule</button>
        </div>
        <!-- referral table -->
        <table class="table">
            <thead>
                <h4 class="text-center text-dark">
                    Referral Table
                </h4>
            </thead>
            <thead>
                <tr>
                <th scope="col">id</th>
                <th scope="col">Username</th>
                <th scope="col">User Code</th>
                <th scope="col">Referrer</th>
                <th>No. Referred</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                <th scope="row">{{$user->id}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->mycode}}</td>
                <td>{{$user->myref}}</td>
                <td>@if($user->getMReferrer($user->id) > 0){{$user->getMReferrer($user->id)}} @else -- @endif</td>
                <td>
                    <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#code-{{$user->id}}">
                        <i class="fa-solid fa-user-pen"></i>
                    </button>
                </td>
                </tr>
                @include('admin.referrral.includes._change_code_modal')
                @endforeach
            </tbody>
        </table>
        <!-- end of referral table -->
    </div>   
</main>
@include('admin.referrral.includes._ref_rule')
@endsection 