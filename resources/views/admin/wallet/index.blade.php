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
          <li class="breadcrumb-item active">Wallets</li>
        </ol>
      </nav>
    
    <!-- accordion ends -->

    <div class="card">
        <div class="card-body p-3">
            <div class="text-end">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createWallet"><i class="fa-brands fa-bitcoin"></i> Create Wallet For User</button>
            </div>
        </div>
    </div>

    <div class="card" id="userWallets" style="display: none">
        {{-- <div class="card-header">
            <div class="text-end">
                <button class="btn btn-primary btn-md" data-bs-toggle="modal" data-bs-target="#createWallet"><i class="fa fa-plus"></i> Create New Wallet</button>
            </div>
        </div> --}}

        <div class="card-header">
            <div class="my-2">
                <div>
                    <div class="input-group mb-3">
                        <select class="form-select" name="" id="walletUser">
                            <option value="">Select Search Type</option>
                            <option value="user">User</option>
                            <option value="wallet">Wallet</option>
                        </select>
                        <input type="text" class="form-control" placeholder="Search..." name="search" id="search">
                        <button id="action" class="btn btn-primary" type="submit">Search</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small><span class="text-danger" id="optionErr"></span></small>
                    </div>
                    <div class="col-6">
                        <small><span class="text-danger" id="searchErr"></span></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="row">#</th>
                            <th>User</th>
                            <th>Wallet</th>
                            <th>Address</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody id="walletUserInfo">
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="card" id="spinner">
        <div class="card-body ">
            <div class="text-center pt-4"><i style="font-size: 50px" class="fas fa-spinner fa-spin fa-3x"></i><p>Please wait</p></div>
        </div>
    </div>
    {{-- <div id="userWallets"></div> --}}
    @include('admin.wallet.include.__wallet_modal')
</div>

@endsection

@push('scripts')
    <script>
        $.ajax({
            url: "{{ route('admin.wallet.balance') }}",
            type: 'GET',
            dataType: 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                var wallets = "";
                var i = 1;
                if(response.data.length > 0) {
                    $.each(response.data, function(key, value) {
                        wallets += "<tr><td>"+ i++ +"</td><td>"+ value.user.name +"</td><td>"+ value.coin_type.toUpperCase() +"</td><td>"+ value.pass_phrase +"</td><td>"+ value.balance +"</td></tr>";
                    });
                } else {
                    wallets = "<tr><td class='text-center' colspan='5'>No Records Found!</td></tr>"
                }
                $('#spinner').hide();
                $("#userWallets").show();
                $("#walletUserInfo").append(wallets);
            }
        });

        $("#action").click(function() {
            let option = $("#walletUser").val();
            let search = $("#search").val();
            $.ajax({
                url: "{{ route('panel.wallet.user') }}",
                dataType: "JSON",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {option, search},
                success: function(resp) {
                    var wallets = "";
                    var i = 1;
                    if(resp.data.length > 0) {
                        $.each(resp.data, function(key, value) {
                            wallets += "<tr><td>"+ i++ +"</td><td>"+ value.user.name +"</td><td>"+ value.coin_type.toUpperCase() +"</td><td>"+ value.pass_phrase +"</td><td>"+ value.balance +"</td></tr>";
                        });
                    } else {
                        wallets = "<tr><td class='text-center' colspan='5'>No Records Found!</td></tr>"
                    }
                    $("#optionErr").hide();
                    $("#searchErr").hide();
                    $("#walletUserInfo").html(wallets);
                },
                error: function(errors) {
                    $("#optionErr").text(errors.responseJSON.errors.option);
                    $("#searchErr").text(errors.responseJSON.errors.search);
                }
            })
        })

    </script>
@endpush
