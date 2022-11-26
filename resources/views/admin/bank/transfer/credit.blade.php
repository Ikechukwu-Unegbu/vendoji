@extends('layouts.admin')

@section('header')
<link rel="stylesheet" href="{{asset('shared_dasboard\css\admin\user\index.css')}}">
<style>
    .form{
        display: grid;
        grid-template-columns: 5fr 1fr;
        margin-bottom: 3rem;

    }
</style>
@endsection

@section('content')
<main id="main" class="main">

<div class="pagetitle">
  <h1>User Funding</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Funding</li>
    </ol>
  </nav>
  @include('partials._message')
</div><!-- End Page Title -->
    <!-- <div class=""> -->
       {{-- @include('admin.users.include._quick_stats')--}}
    <div class="container">
        <div class="">
            <form class="form" action="{{route('panel.banktransfer.search')}}" method="get">
                @csrf
                <div class="form-group">
                    <input type="text" name="search_term" class="form-control">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">name</th>
              <th scope="col">amount</th>
              <!-- <th scope="col">type</th> -->
              {{--<th scope="col">Wallet</th>--}}
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
              {{--<td>
                @if($trfer->type == 1)
                  <span style="font-weight:bold; color: green;">Credit</span>
                @else
                 <span style="font-weight:bold; color:red;"> Debit</span>
                @endif
              </td>--}}
              {{--<td>
                <ul>
                  @foreach($trfer->user->wallets as $wallet )
                    <li>{{$wallet->coin_type}}:{{$wallet->pass_phrase}}</li>
                  @endforeach
                </ul>

              </td>--}}
              <td>
                @if($trfer->approval == 1)
                  <span class="text-dark text-center">Approved</span>
                @else
                  <span class="text-dark text-center">Pending...</span>
                @endif
              </td>
              <td style="display:flex; flex-direction:row;grid-gap:1rem;">
                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#approve-credit-{{$trfer->id}}">Approve</button>
                <button class="btn btn-sm btn-dark" data-bs-toggle="modal" data-bs-target="#info-{{$trfer->id}}">Info</button>
              </td>
            </tr>
            @include('admin.bank.transfer.includes.banktransfer_modals')
            @endforeach

          </tbody>
        </table>
        </div>
    </div>
</div>
</main>

@endsection
