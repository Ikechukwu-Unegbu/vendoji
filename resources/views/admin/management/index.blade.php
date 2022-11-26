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
                    <li class="breadcrumb-item active">Administrative Mgt.</li>
                </ol>
            </nav>
            @include('partials._message')
        </div><!-- End Page Title -->
        <div class="">
            @include('admin.users.include._quick_stats')
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Active Administrator Tables</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th>Phone</th>
                                <th>Access</th>
                                @if(auth()->user()->access == 'superadmin')
                                    <th scope="col">Handle</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $admin)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->phone }}</td>
                                    <td>{{ ucwords($admin->access) }}</td>
                                    @if(auth()->user()->access == 'superadmin')
                                    <td>
                                        <button title="Apoint {{ $admin->name }} as Superadmin" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#appoint-{{ $admin->id }}"><i class="text-secondary fa-solid fa-check"></i></button>
                                        <button title="Revoke {{ $admin->name }}" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#revoke-{{ $admin->id }}"><i class="text-danger fa-solid fa-ban"></i></button>
                                    </td>
                                    @endif
                                </tr>
                                @include('admin.management.include.__admin_modal')
                            @endforeach

                        </tbody>
                        <div style="" class="">{{ $admins->links() }}</div>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
