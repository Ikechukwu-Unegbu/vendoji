@extends('layouts.users')

@section('head')
<style>
    .deets{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 50% !important;
    }
    .deet-holder{
        justify-self: center !important;
        /* width: 50% !important; */
        /* display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center; */
        margin-top: 4rem;
        border-top-style: solid;
        border-top-width: 2px;
    }
</style>
@endsection

@section('content')
<section class="section dashboard">
    <div main id="main" class="main">
        <!-- <h1>User Dashboard</h1> -->

    <div class="container">
        <div  class="form-debit p-5 m-5" style="display:flex; flex-direction:column; grid-gap:3rem; justify-content:center !important;">
                <h4 class="text-center text-dark">Thank You, Your debit request is being processed.</h4>
                <a class="btn btn-sm btn-success" href="{{route('dashboard')}}">Back Home</a>
        </div>
    </div>
    </div>
</section>

@endsection