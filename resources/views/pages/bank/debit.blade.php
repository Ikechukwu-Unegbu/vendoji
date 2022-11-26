@extends('layouts.users')

@section('head')

@endsection

@section('content')
    <section class="section dashboard">
        <div main id="main" class="main">
            <h1>User Dashboard</h1>

            <div class="container">
                <h6><strong>Percentage Lock: {{ auth()->user()->banktransfers->last()->percentage_lock ?? '' }}%</strong></h6>
                @php
                    if(!empty(auth()->user()->banktransfers->last()->percentage_lock)){
                        $percentage = 100-auth()->user()->banktransfers->last()->percentage_lock."%";
                    }else{
                        $percentage = 0;
                    }
                @endphp
                <small><strong>Note: You are allowed to withdraw {{ $percentage }} from your available balance</strong></small>
                <div class="form-debit">
                    <form action="{{ route('debit.store', [Auth::user()->id]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            @include('partials._message')
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="form-label">Amount to Withdraw</label>
                            <input type="number" name="amount" value="{{ old('amount') }}" class="form-control">
                            <small><span></span></small>
                            <small><span></span></small>
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="form-label">Select Coin</label>
                            <select class="form-select @error('coin') is-invalid @enderror"
                            aria-label="Default select example" name="coin">
                                <option value="">Open this select menu</option>
                                @foreach(auth()->user()->wallets as $wallet)
                                    <option value="{{ $wallet->coin_type }}">{{ Str::upper($wallet->coin_type) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="form-label">Bank Name </label>
                            <input type="text" name="bank_name" value="{{ old('bank_name') }}" class="form-control">
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="form-label">Bank Account </label>
                            <input type="number" name="account_number" value="{{ old('account_number') }}"
                                class="form-control">
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="form-label">Account Name </label>
                            <input type="text" class="form-control" value="{{ old('account_name') }}" name="account_name">
                            <!-- <small><span></span></small>
                            <small><span></span></small> -->
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="form-label">Password </label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <!-- <div class="form-group mt-3">
                            <label for="" class="form-label"></label>
                        </div> -->
                        <div class="form-group mt-4">
                            <button style="float: right;" class="btn btn-md btn-primary">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
