@extends('layouts.admin')

@section('header')
<link rel="stylesheet" href="{{asset('shared_dasboard\css\admin\user\index.css')}}">
@endsection

@section('content')
<main id="main" class="main">

    <div class="pagetitle">

    @include('partials._message')
    </div><!-- End Page Title -->
    <div class="">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Username</th>
      <th scope="col">Amount</th>
      <th scope="col">
        Action
      </th>
    </tr>
  </thead>
  <tbody>
    @foreach($unlocks as $unlock)
    <tr>
      <th scope="row">{{$unlock->id}}</th>
      <td>{{$unlock->user->name}}</td>
      <td>{{$unlock->userlock->cointype}} {{$unlock->userlock->amount}}</td>
      <td>
        <button class="btn btn-sm btn-primary"  data-bs-toggle="modal" data-bs-target="#unlock-approve-{{$unlock->id}}">Action</button>
      </td>
    </tr>
        @include('admin.lock.include._cancel_page_modals')
    @endforeach
  </tbody>
</table>
    </div>
</main>

@endsection 