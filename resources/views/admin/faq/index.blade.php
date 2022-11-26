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
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
            @include('partials._message')
        </div><!-- End Page Title -->

        <div class="container">
            <div class="card">
                <div class="card-body p-3">
                    <div class="text-end">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#create-faq"><i class="fa fa-plus-circle"></i> Add FAQ</button>
                    </div>
                </div>
            </div>
            @foreach ($faqs as $faq)
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-center card-title">{{ $faq->question }} <span><small
                                    style="color:blue;">{{ $faq->faqcategory->name ?? '' }}</small></span></h4>
                        <div class="">
                            {!! $faq->answer !!}
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#edit-{{ $faq->id }}">Edit</button>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#delete-{{ $faq->id }}">Delete</button>
                        </div>
                    </div>
                </div>
                @include('admin.faq.include._delete_confirm')
                @include('admin.faq.include._edit_')
            @endforeach
            @include('admin.faq.include._create_')


            <div class=""></div>
            {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </main>
@endsection
