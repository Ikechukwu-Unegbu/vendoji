@extends('layouts.users')

@section('head')
<style>
    .accordion-item{
        padding: 1rem;
    }
    .options .card-body{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        grid-gap: 2rem;
    }
    .options .card{
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
    }
</style>
@endsection

@section('content')
<div main id="main" class="main" >
    <h1>User Dashboard</h1>
    <!-- accordion begins -->
    <div class="options">
        <div class="card">
            <div class="card-body">
                <div class="card-left">
                    <i class="fa-brands fa-bitcoin fa-4x"></i>
                </div>
                <div class="card-right">
                    <button class="btn btn-sm btn-primary">Pay With Bitcoin</button>
                </div>
            </div>
        </div>
        <!-- btc card ends -->
        <div class="card">
            <div class="card-body">
                <div class="card-left">
                    <i class="fa-brands fa-4x fa-ethereum"></i>
                </div>
                <div class="card-right">
                    <button class="btn btn-sm btn-primary">Pay With Bitcoin</button>
                </div>
            </div>
        </div>
        <!-- ethereum card ends -->
        <div class="card">
            <div class="card-body">
                <div class="card-left">
                    <!-- <i class="fa-brands fa-bitcoin fa-4x"></i> -->
                    <i class="fa-solid fa-4x fa-building-columns"></i>
                </div>
                <div class="card-right">
                    <button type="button" id="show" class="btn btn-sm btn-primary">Fund With Fiat</button>
                </div>
            </div>
        </div>

    </div>
    <div id="showCard" class="card" style="display: none">
        <div class="card-body p-4">
            {{-- <form id="onSubmitPayment" > --}}
            <form action="{{ route('payment.initiate') }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label for="amount" class="form-label">Enter Amount</label>
                    <input type="number" id="amount" class="form-control" name="amount" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary">Make Payment</button>
                </div>
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Transaction History</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="row">#</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Payment Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>&#8358; {{ number_format($transaction->amount), 2 }}</td>
                                <td>
                                    <span class="bg-{{ ($transaction) ? 'success' : 'danger' }} badge badge-sm">
                                        {{ ($transaction) ? 'Successful' : 'Failed' }}
                                    </span>
                                </td>
                                <td>{{ ucwords($transaction->payment_type) }}</td>
                                <td>
                                    <a href="" class="btn btn-sm btn-primary"><i class="fa fa-list"></i></a>
                                </td>
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
    </div>
    <!-- accordion ends -->
</div>
@endsection
@section('scripts')

    <script>
        $('#showCard').hide()
    </script>
    <script>
        $('#show').click(function(){
            $('#showCard').slideToggle('2000')
        });
    </script>
    {{-- <script src="https://checkout.flutterwave.com/v3.js"></script> --}}
    {{-- <script>
        $(function() {
            $('#onSubmitPayment').submit(function (e){
                e.preventDefault();
                var amount = $('#amount').val();
                makePayment(amount);
            });
        })

        function makePayment(amount) {
            FlutterwaveCheckout({
                public_key: "FLWPUBK_TEST-SANDBOXDEMOKEY-X",
                // tx_ref: "titanic-48981487343MDI0NzMx",
                tx_ref: "RX1_{{ substr(rand(0, time()), 0, 7) }}",
                amount,
                currency: "NGN",
                payment_options: "card, mobilemoneyghana, ussd",
                //redirect_url: "https://glaciers.titanic.com/handle-flutterwave-payment",
                customer: {
                email: "{{ auth()->user()->email }}",
                phone_number: "{{ auth()->user()->phone }}",
                name: "{{ auth()->user()->name }}",
                },
                customizations: {
                title: "FlexStart",
                description: "Wallet Funding",
                logo: "https://www.logolynx.com/images/logolynx/22/2239ca38f5505fbfce7e55bbc0604386.jpeg",
                },
            });
            }
    </script> --}}
@endsection
