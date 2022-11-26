@extends('layouts.users')

@section('head')
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
    <h1>User Dashboard</h1>
    <!-- accordion begins -->

    <div class="wall">

        {{--<div class="card">
            <div class="card-body">
                <!-- <img src="" alt=""> -->
                <div class="inner-wall" style="display:flex; flex-direction:row; grid-gap:2rem;">
                    <div class="img-coin-logo"><i class="fa-brands fa-2x fa-bitcoin"></i></div>
                    <div>0.34</div>
                    <div class="">BTC</div>
                </div>
                <div><p>1BvBMSEYstWetqTFn5Au4m4GFg7xJaNVN2</p></div>
            </div>
        </div>--}}
    </div>
    <!-- accordion ends -->
    @include('pages.wall.partials.__message')
    <div class="card">
        <div class="card-body p-3">
            <div class="d-flex justify-content-between">
                <div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createWallet"><i class="fa-brands fa-bitcoin"></i> Add Wallet</button>
                </div>
                <div>
                    @if(auth()->user()->wallets->count() > 0)
                    <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#coinTransfer"><i class="fa-brands fa-bitcoin"></i> Coin Transfer</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="wall">
        @foreach($wallets as $wallet)
            <div class="card">
                <div class="card-body">
                    <div class="inner-wall" style="display:flex; flex-direction:row; grid-gap:2rem;">
                        {{-- <div class="img-coin-logo"><i class="fa-brands fa-2x fa-bitcoin"></i></div> --}}
                        <div class="img-coin-logo">
                            <img src="{{ asset("coin-logo/{$wallet->coin_type}.png") }}" style="width: 50px">
                        </div>
                        <div>{{ $wallet->balance }}</div>
                        <div class="">{{ Str::upper($wallet->coin_type) }}</div>
                    </div>
                    <div><small style="font-size:xx-small;">{{ $wallet->pass_phrase }}</small></div>
                </div>
                <div class="card-footer">
                    @if($wallet->locked_state ==0)
                    <button style="float: right;" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#lock-{{$wallet->id}}">Lock Wallet</button>
                    @elseif($wallet->locked_state == 2)
                    <span>Unlocking...</span>
                    <div style="float: right;" class="spinner-border text-danger" role="status">
                        <span class="visually-hidden">Unlocking...</span>
                    </div>
                    @else
                    <button class="btn btn-danger btn-sm" style="float: right;" data-bs-toggle="modal" data-bs-target="#unlock-{{$wallet->id}}">Unlock</button>
                    @endif
                </div>
            </div>
            @include('pages.wall.partials.__unlock_modal')
            @include('pages.wall.partials.__lock_confirmation')
        @endforeach
    </div>
    {{-- <div class="card">
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="row">#</th>
                            <th>Wallet(s)</th>
                            <th>Address</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wallets as $wallet)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ strtoupper($wallet->coin_type) }}</td>
                                <td>{{ $wallet->pass_phrase }}</td>
                                <td>{{ $wallet->balance }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No Records Found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
    @include('pages.wall.partials.__wallet_modal')
</div>

@endsection
