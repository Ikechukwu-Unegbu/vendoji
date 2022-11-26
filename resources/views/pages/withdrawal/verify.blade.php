@extends('layouts.users')
@section('content')
    <div main id="main" class="main">
        <h1>Verify OTP</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">OTP</h5>
            </div>
            <div class="p-3 card-body">
                <form action="{{ route('otp.verified', [$otp->slug, $trx->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="mb-4 text-center form-group">
                                <label for="" class="form-label">Enter OTP</label>
                                <p class="text-danger"><small>Check your email for the OTP</small></p>
                                <input type="number" name="otp" class="form-control form-control-lg @error('otp') is-invalid @enderror" value="{{ old('otp') }}">
                                @error('otp') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mt-2 text-center form-group">
                                <button type="submit" class="btn btn-primary btn-md">Verify OTP</button>
                                <button type="button" class="btn btn-info btn-md">Resend OTP</button>
                            </div>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
