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
      <li class="breadcrumb-item active">Search Results</li>
    </ol>
  </nav>
</div><!-- End Page Title -->
<div class="">
    @if(!isset($result))
        <div>
            <h1 class="text-center">Enter Search Keys</h1>
        </div>
    @elseif(count($result) <1 )
        <div><h1>No User Found</h1></div>
    @else
        @foreach($result as $res)
            <div class="card">
                <div class="card-body mt-2">
                    <h5 class="">
                        <a href="{{route('panel.users.show', [$res->name])}}"><span>{{$res->name}}</span> - <span>{{$res->email}}</span></a>
                    </h5>
                    
                </div>
            </div>
        @endforeach
    @endif
</div>
</main>
@endsection 