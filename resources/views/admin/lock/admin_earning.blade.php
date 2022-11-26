@extends('layouts.admin')

@section('header')
    <link rel="stylesheet" href="{{ asset('shared_dasboard\css\admin\user\index.css') }}">
    <style>
        .card-holder {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 2rem;
        }

        .card-holder .card {
            width: 100%;
            height: 4rem;
        }
    </style>
@endsection

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">

            @include('partials._message')
        </div><!-- End Page Title -->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <h5>BTC {{ $allbtc }} Earned</h5>
                        <h6>{{ $settings['btc_percentage'] ?? 0 }}%</h6>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <h5>Doge {{ $alldoge }} Earned</h5>
                        <h6>{{ $settings['doge_percentage'] ?? 0 }}%</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-3 text-center">
                        <h5>LTC {{ $all_ltc }} Earned </h5>
                        <h6>{{ $settings['lite_percentage'] ?? 0 }}%</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-end mb-4">
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#create_earning"><i class="fa fa-money"></i> Edit Percentage Earning</button>
        </div>

        <div class="">
            <table class="table">
                <thead>
                    <h3 class="text-center">Admin Earnings</h3>
                </thead>
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Coin</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($earnings as $earning)
                        @if (count($earnings) < 1)
                            <h3 class="text-center">No Earnings Yet</h3>
                        @else
                            <tr>
                                <th scope="row">{{ $id }}</th>
                                <td>{{ $earning->cointype }}</td>
                                <td>{{ $earning->amount }}</td>
                                <td>
                                    @if ($earning->model == 'Lock')
                                        Locking
                                    @else
                                        Ulocking
                                    @endif
                                </td>
                                <td>@mdo</td>
                            </tr>
                        @endif
                    @endforeach

                </tbody>
            </table>
            <div class="">
                {{ $earnings->links() }}
            </div>
        </div>
    </main>
    @include('admin.lock.include._earning_modals')
@endsection
