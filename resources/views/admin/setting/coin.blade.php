@extends('layouts.admin')

@section('header')
<style>
    .accordion-item{
        padding: 1rem;
    }
    .wall .card-body{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        grid-gap: 2rem;
        padding: 1rem;
    }
    .wall .card{
        width: 100%;
        height: 7rem;
    }
    .options {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 1rem;
    }
    @media(max-width:650px){
        .options {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            grid-gap: 1rem;
        }
        .wall .card{
        width: 100%;
        height: 12rem;
    }
        .wall .card-body{

            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            /* grid-gap: 2rem; */
            padding: 2rem;
        }
    }
</style>
@endsection

@section('content')
<div main id="main" class="main" >
    <h1>Dashboard</h1>
    <!-- accordion begins -->
    <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Settings</li>
          <li class="breadcrumb-item active">Manage Coins</li>
        </ol>
      </nav>
    <div class="wall">

       {{-- <div class="card">
            <div class="card-body">
                <!-- <img src="" alt=""> -->
                <div class="inner-wall" style="display:flex; flex-direction:row; grid-gap:2rem;">
                    <div class="img-coin-logo"><i class="fa-brands fa-2x fa-bitcoin"></i></div>
                    <div>0.34</div>
                    <div class="">BTC</div>
                </div>
                <div><p>1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2</p></div>
            </div>
        </div>
    </div>--}}
    <!-- accordion ends -->
    @include('admin.setting.include.__message')
    <div class="card">
        <div class="card-body p-3">
            <div class="text-end">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#coinTransfer"><i class="fa-brands fa-bitcoin"></i> Coin Trasfer</button>
            </div>
        </div>
    </div>
    <div class="wall">
        @foreach($wallets as $wallet)
            <div class="card">
                <div class="card-body">
                    <div class="inner-wall" style="display:flex; flex-direction:row; grid-gap:2rem;">
                        <div class="img-coin-logo"><i class="fa-brands fa-2x fa-bitcoin"></i></div>
                        <div>{{ $wallet->balance }}</div>
                        <div class="">{{ Str::upper($wallet->coin_type) }}</div>
                    </div>
                    <div><p>{{ $wallet->pass_phrase }}</p></div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- <div id="userWallets"></div> --}}
    @include('admin.setting.include.__wallet_modal')
</div>

@endsection

@push('scripts')

@endpush
