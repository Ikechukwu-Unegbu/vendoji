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
    <div>
        <button  data-bs-toggle="modal" data-bs-target="#new-cate" class="btn btn-sm btn-primary" style="float: right;">New Category</button>
    </div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
      <th scope="col">No. of Faq</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
        @foreach($cates as $cate)
        <tr>
            <th scope="row">{{$cate->id}}</th>
            <td>{{$cate->name}}</td>
            <td>{{$cate->description}}</td>
            <td>{{ $cate->faq->count() }}</td>
            <td>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#edit-{{$cate->id}}"><i class="fa-solid fa-edit"></i></button>
                <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#delete-{{$cate->id}}"><i class="fa-solid fa-trash-can text-danger"></i></button>
            </td>
        </tr>
        @include('admin.faq.include._faq_category_modal')
        @endforeach
  </tbody>
</table>
@include('admin.faq.include._new_category')
</main>
@endsection
