@extends('layouts.users')



@section('content')
    <div main id="main" class="main">
        <h1>Withdrawal</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Withdraw Funds</h5>
            </div>
            <div class="p-3 card-body">
                <form action="{{ route('withdrawal.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4 form-group">
                                <label for="">Account Number</label>
                                <input type="number" name="account" class="form-control @error('account') is-invalid @enderror" value="{{ old('account') }}">
                                @error('account') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4 form-group">
                                <label for="">Amount</label>
                                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
                                @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="bank" class="form-label">Select Bank</label>
                                <select class="form-control @error('bank') is-invalid @enderror" name="bank">
                                    <option value="">Open this select menu</option>
                                    @foreach ($banks['data'] as $bank)
                                        <option value="{{ $bank['code'] }}" {{ $bank['code'] == old('bank') ? 'selected' : '' }}>{{ $bank['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('bank') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 form-group">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
