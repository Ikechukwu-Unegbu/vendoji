@extends('layouts.users')

@section('head')
    <style>
        .holder {
            background-color: #292745;
            padding: 2rem;
            border-radius: 15px;
            background-image: url('https://images.unsplash.com/photo-1516245834210-c4c142787335?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1469&q=80');
        }

        .wall .card-body {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            grid-gap: 2rem;
            padding: 1rem;
        }

        .wall .card {
            width: 100%;
            height: 7rem;
        }

        .options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 1rem;
        }

        @media(max-width:650px) {
            .options {
                display: grid;
                grid-template-columns: repeat(1, 1fr);
                grid-gap: 1rem;
            }

            .wall .card {
                width: 100%;
                height: 12rem;
            }

            .wall .card-body {

                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: center;
                /* grid-gap: 2rem; */
                padding: 2rem;
            }
        }

        .dashboard-card {
            box-shadow: 0 0 22px whitesmoke;
        }

        .card-top {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .card-top i {
            columns: blue !important;
        }

        .card-mid-balance {
            display: flex;
            /* flex-direction: ; */
            justify-content: center;
            align-items: center;
        }

        .card-mid-balance button {
            border-style: solid;
            border-color: black;
        }

        .fuctionalities {
            display: flex;
            justify-content: space-between;
            z-index: 1;
            margin-top: 3rem;
        }

        .card-top {
            padding-top: 1.2rem;
            margin-top: 1.2rem;
        }

        @media(max-width:600px) {
            .fuctionalities {
                grid-gap: 0.5rem;
            }
        }

        .fuctionalities button {
            background-color: white;
        }

        .fuctionalities button:hover {
            background-color: antiquewhite !important;
        }

        .fa-xustom {
            color: blue;
        }

        }


    </style>
@endsection

@section('content')
    <section class="section dashboard">
        <div main id="main" class="main">
            <!-- profile dashboard -->
            <div class="holder">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <div class="card-top "
                            style="padding-top:1.2rem; width:100% !important; display: flex; flex-direction:row; justify-content:space-between !important;">
                            <div class="">
                                <h4 class="text-left">Hi, <strong>{{ $loggedUser->name }}</strong></h4>
                            </div>
                            <div class=""><i class="fa-sharp fa-xustom fa-solid fa-face-smile"></i></div>
                        </div>
                        <div class="card-mid-balance">
                            <span style="display:none ;" id="ref_holder">{{ $refcode }}</span>
                            <button onclick="copyRef()" class="btn btn-default">Copy Your Referral Code</button>
                        </div>
                        <div>
                            Locked Fund :
                        </div>
                    </div>
                </div>
                <div class="fuctionalities">
                    <a href="{{ route('credit.offline') }}" class="btn bg-light text-dark  btn-sm">
                        <span>Deposit</span>
                        <i class="fa-solid fa-money-check-dollar"></i>
                    </a>
                    <a href="{{ route('offline.debit', [Auth::user()->id]) }}" class="btn bg-light text-dark btn-sm">
                        <span>Withdraw</span>
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </a>
                    <button class="btn btn-sm btn-default" data-bs-toggle="modal" data-bs-target="#coinTransfer">
                        <span>Transfer</span>
                        <i class="fa-sharp fa-solid fa-sack-dollar"></i>
                    </button>
                </div>
            </div>
            <!-- end of profile dashboard -->

            <div class="mt-5">
                <div class="card">
                    <div class="card-body">
                        <canvas id="BitCoinChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="wall mt-5">
                @foreach (auth()->user()->wallets as $wallet)
                    <div class="card">
                        <div class="card-body">
                            <div class="inner-wall" style="display:flex; flex-direction:row; grid-gap:2rem;">
                                <div class="img-coin-logo">
                                    <img src="{{ asset("coin-logo/{$wallet->coin_type}.png") }}" style="width: 50px">
                                </div>
                                <div>{{ $wallet->balance }}</div>
                                <div class="">{{ Str::upper($wallet->coin_type) }}</div>
                            </div>
                            <div><small style="font-size:xx-small;">{{ $wallet->pass_phrase }}</small></div>
                        </div>
                        <div class="card-footer">
                            @if ($wallet->locked_state == 0)
                                <button style="float: right;" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#lock-{{ $wallet->id }}">Lock Wallet</button>
                            @elseif($wallet->locked_state == 2)
                                <span>Unlocking...</span>
                                <div style="float: right;" class="spinner-border text-danger" role="status">
                                    <span class="visually-hidden">Unlocking...</span>
                                </div>
                            @else
                                <button class="btn btn-danger btn-sm" style="float: right;" data-bs-toggle="modal"
                                    data-bs-target="#unlock-{{ $wallet->id }}">Unlock</button>
                            @endif
                        </div>
                    </div>
                    @include('pages.wall.partials.__unlock_modal')
                    @include('pages.wall.partials.__lock_confirmation')
                @endforeach
            </div>

            <div class="mt-5 pt-4">
                <div class="card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>

                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Recent Activity</h5>

                        <div class="activity">
                            @foreach ($activities as $activity)
                                <div class="activity-item d-flex">
                                    <div class="activite-label">
                                        {{ $activity->created_at->format('d-m-Y') . ' ' . $activity->created_at->format('H:i A') }}
                                    </div>
                                    <i
                                        class='bi bi-circle-fill activity-badge text-{{ $activity->description == 'logged in' ? 'success' : ($activity->description == 'logged out' ? 'danger' : 'success') }} align-self-start'></i>
                                    <div class="activity-content">
                                        {{ ucwords($activity->description) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    @include('pages.wall.partials.__wallet_modal')
    <script src="{{asset('pages/js/user_dash.js')}}"></script>

@section('scripts')
    @parent
    <script>
        var ctx = document.getElementById("BitCoinChart");
        var BtcChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Bitcoin To Naira',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [],
                }]
            },
            options: {
                scales: {
                    xAxes: [],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        var BitCoinUpdateChart = function() {
            $.ajax({
                url: "{{ route('BitCoin') }}",
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log(data);
                    BtcChart.data.labels = data.label;
                    BtcChart.data.datasets[0].data = data.data;
                    BtcChart.update();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        BitCoinUpdateChart();
        setInterval(() => {
            BitCoinUpdateChart();
        }, 40000);

        var ctx = document.getElementById("USDChart");
        var USDChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'USD To Naira',
                    backgroundColor: 'rgb(255, 25, 0)',
                    borderColor: 'rgb(255, 25, 0)',
                    data: [],
                }]
            },
            options: {
                scales: {
                    xAxes: [],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        var USDUpdateChart = function() {
            $.ajax({
                url: "{{ route('UsdCoin') }}",
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    console.log(data);
                    USDChart.data.labels = data.label;
                    USDChart.data.datasets[0].data = data.data;
                    USDChart.update();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        USDUpdateChart();
        setInterval(() => {
            USDUpdateChart();
        }, 40000);
    </script>
    <!-- referral copying code -->
    <script>
        function base_url() {
        var pathparts = location.pathname.split('/');
        if (location.host == 'localhost') {
            var url = location.origin+'/'+pathparts[1].trim('/')+'/'; // http://localhost/myproject/
        }else{
            var url = location.origin; // http://stackoverflow.com
        }
            return url;
        }
        let url = base_url();
        let ref_link = url+'/register?ref='+"{{$refcode}}";
        console.log(`{{$refcode}}`);

        console.log(ref_link)
        let ref_link_holder = document.getElementById('ref_holder')
        ref_link_holder.value = ref_link;

        console.log('We are here')


        function copyRef(){
            
            let copyText = document.getElementById('ref_holder')
            //  document.body.appendChild(copyText); 
            console.log(copyText.value)
            //return;
            copyText.select();
            navigator.clipboard.writeText(copyText.value)
            // var feedbackModal = new bootstrap.Modal(document.getElementById('code_copied'))
            //         feedbackModal.show()
        }

    </script>
@endsection
