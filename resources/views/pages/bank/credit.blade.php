@extends('layouts.users')

@section('head')

@endsection

@section('content')
<section class="section dashboard"  style="height: 100vh !important;"">
    <div main id="main" class="main">
        <!-- <h1>User Dashboard</h1> -->

    <div class="container" style="height: 100vh !important;">
        <div class="form-debit">
            <form action="{{route('credit.store', [Auth::user()->id])}}" method="post">
                @csrf
                <div class="form-group">
                    @include('partials._message')
                </div>
                <div class="form-group mt-4">
                    <label for="" class="form-label">How much do you want to credit? </label>
                    <input type="number" name="amount" value="{{old('amount')}}" class="form-control">
                    <small><span></span></small>
                    <small><span></span></small>
                </div>
                <div class="form-group mt-3">
                    <label for="" class="form-label">Select Wallet to Credit</label>
                    <select name="wallet" class="form-select">
                        <option value="">Open this select menu</option>
                        @foreach($wallets as $__wallet)
                            <option value="{{ $__wallet->coin_type }}">{{ Str::upper($__wallet->coin_type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="" class="form-label">Selecting Locking Duration</label>
                    <select name="locking_duration" class="form-select" >
                        <option selected value="0">None</option>
                        @foreach($locks as $lock)
                        <option value="{{$lock->duration}}">{{$lock->duration}} Months</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-4">
                    <label for="" class="form-label">Enter Locking Percentage? </label>
                    <input type="number" name="locking_percentage" value="{{old('locking_percentage')}}" class="form-control">
                    <small><span></span></small>
                    <small><span></span></small>
                </div>

                <div class="form-group mt-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" required id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            I have read and understood the <a href=""> Locking terms and conditions</a>.
                        </label>
                    </div>
                </div>


                <div class="form-group mt-4">
                    <button style="float: right;" class="btn btn-md btn-primary">Next</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</section>

@endsection
