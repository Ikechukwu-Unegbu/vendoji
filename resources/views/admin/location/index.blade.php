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
                    <li class="breadcrumb-item"><a href="{{ url('/panel') }}">Home</a></li>
                    <li class="breadcrumb-item active">User Location</li>
                </ol>
            </nav>
            @include('partials._message')
        </div><!-- End Page Title -->
        <div class="">
            <div class="card">
                <div class="card-header">
                    <div class="my-2">
                        <form action="{{ route('panel.user.location.index') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="date" class="form-control" name="start_date">
                                <input type="date" class="form-control" name="end_date">
                                <button class="btn btn-primary" type="submit">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User</th>
                                <th scope="col">User IP</th>
                                <th>Country</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($locations as $location)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $location->user->name }}</td>
                                    <td>{{ $location->ip }}</td>
                                    <td>{{ $location->country_name }}</td>
                                    <td>{{ $location->city_name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#preview-{{ $location->id }}"><i class="fa fa-list"></i> View</button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td class="text-center" colspan="6">No Records Found!</td></tr>
                            @endforelse

                        </tbody>
                        <div style="" class="">{{ $locations->links() }}</div>
                    </table>
                </div>
            </div>
        </div>
    </main>
    @include('admin.location.include.__location_modal')
@endsection
