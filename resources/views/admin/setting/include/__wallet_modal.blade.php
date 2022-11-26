<div class="modal fade" id="coinTransfer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="coinTransfer" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="coinTransfer">Coin Transfer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.admin.wallet.transfer') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group mb-4">
                        <label for="address" class="form-label">Select Your Address <span class="text-danger">*</span></label>
                        <select class="form-select @error('address') is-invalid @enderror"
                            aria-label="Default select example" name="address">
                            <option value="">Open this select menu</option>
                            @foreach($wallets->where('coin_type', 'btc') as $wallet)
                                <option value="{{ $wallet->id }}">{{ strtoupper($wallet->coin_type) }} - {{ $wallet->pass_phrase }}</option>
                            @endforeach
                        </select>
                        @error('address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="coin_address" class="form-label">Enter Receiver's Address <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('coin_address') is-invalid @enderror"
                            name="coin_address" id="coin_address">
                        @error('coin_address')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="amount" class="form-label">Enter Amount <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('amount') is-invalid @enderror"
                            name="amount" id="amount">
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="password" class="form-label">Enter Your Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" id="password" placeholder="******">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="submit" class="btn btn-primary"> Send</button>
                </div>
            </form>
        </div>
    </div>
</div>