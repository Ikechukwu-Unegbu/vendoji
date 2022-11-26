@extends('layouts.admin')

@section('header')
    <link rel="stylesheet" href="{{ asset('shared_dasboard\css\admin\user\index.css') }}">
@endsection

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Newsletters</li>
                </ol>
            </nav>
            @include('partials._message')
        </div><!-- End Page Title -->
        <div class="card-holder">
            <div class="card bg-primary">
                <div class="card-body">
                    <h5 class="text-center">Total Subscribed</h5>
                    <h5 class="text-center">{{ $subscribed }}</h5>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header p-2">
                <h4 class="card-title">Subscribed Users</h4>
            </div>
            <div class="card-body">
                <div class="table-respponsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Email</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($newsletters as $newsletter)
                                <tr>
                                  <th scope="row">{{$loop->index+1}}</th>
                                  <td>{{$newsletter->email}}</td>
                                  <td>{{$newsletter->created_at->format('d-M-Y')}}</td>                          
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div style="" class="">{{$newsletters->links()}}</div>
            </div>
        </div>
    </main>
@endsection
