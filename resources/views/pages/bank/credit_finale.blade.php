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
        <div class="form-debit">
           <div class="">
            <h5 class="text-center text-dark">Make Your Transfer to The Account Number Below Using the Code as Narration</h5>
            <h5 class="text-center text-dark">or</h5>
            <h4 class="text-center text-dark">You can Send Your Transfer Reciept to {{$bank->phone ?? ''}}</h4>
            <div class="deet-holder">
                <div class="deets">
                    <span class="key">Bank Name : </span>
                    <span>{{$bank->bank_name ?? '' }}</span>
                </div>
                <div class="deets">
                    <span class="key">Account Name: </span>
                    <span>{{$bank->account_name ?? '' }}</span>
                </div>
                <div class="deets">
                    <span class="key">Account Number: </span>
                    <span class="">{{$bank->account_number ?? '' }}</span>
                </div>
                <div class="deets">
                    <span class="key">Narration Code: </span>
                    <span class="">{{$banktransfer->trxid ?? '' }}</span>
                </div>

            </div>
           </div>
        </div>
    </div>
    </div>
</section>

@endsection
