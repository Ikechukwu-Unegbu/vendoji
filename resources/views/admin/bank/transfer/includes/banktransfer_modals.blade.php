<!-- Modal -->
<div class="modal fade" id="info-{{ $trfer->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $trfer->user->name }} ({{ $trfer->user->id }})
                    Details
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="deet_holder">
                    {{-- <div class="deets">
                <span>Bank Name: </span>
                <span>{{$trfer->bank_name}}</span>
            </div>
            <div class="deets">
                <span>Account Name: </span>
                <span>{{$trfer->account_name}}</span>
            </div>
            <div class="deets">
                <span>Account Number: </span>
                <span>{{$trfer->account_number}}</span>
            </div> --}}

                    <form action="{{ route('panel.admin.amounttocredit.store', [$trfer->id]) }}" method="POST">
                        @csrf
                        <div class="form-group mt-4">
                            <!-- <label for="" class="form-label">User Wallets:</label> -->
                            <select class="form-select" aria-label="Default select example" name="user_wallet" required />
                                @php $userWalletCreditRequest = $trfer->user->wallets->where('coin_type', $trfer->coin_type)->first() @endphp
                                <option value="">Select Recieving User Wallet</option>
                                <option value="{{ $userWalletCreditRequest->id }}" {{ $trfer->user_wallet_id == $userWalletCreditRequest->id ? 'selected' : '' }}>
                                    {{ Str::upper($userWalletCreditRequest->coin_type) . ' - ' . $userWalletCreditRequest->pass_phrase }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <!-- <label for="" class="form-label"> </label> -->
                            <select class="form-select" aria-label="Default select example" name="master_wallet" required />
                                <option value="">Select Source Master Wallet</option>
                                @foreach ($masterWallets as $mswallet)
                                    <option value="{{ $mswallet->id }}" {{ $trfer->master_wallet_id == $mswallet->id ? 'selected' : '' }}>
                                        {{ Str::upper($mswallet->coin_type) . ' - ' . $mswallet->pass_phrase }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-4">
                            <label for="" class="form-label">Amount</label>
                            <input type="number" step="any" class="form-control" name="amount" value="{{ $trfer->amount_send ?? '' }}" required />
                        </div>
                        <div class="form-gorup mt-4">
                            <button class="btn btn-sm btn-primary">Send</button>
                        </div>
                    </form>
                    <hr>
                    <hr>
                    <div class="deets">
                        <span>BTC Wallets: </span>
                        <span>
                            <ul style="color: black;">
                                @foreach ($trfer->user->wallets as $wallet)
                                    <li style="color:black;">{{ $wallet->coin_type }}:{{ $wallet->pass_phrase }}</li>
                                @endforeach
                            </ul>
                        </span>
                    </div>
                    <!-- <div class="deets">
                <span>Doge Wallet: </span>
                <span></span>
            </div>
            <div class="deets">
                <span>Litcoin Wallet: </span>
                <span></span>
            </div> -->
                    <div style="padding: 1rem; display:flex; grid-gap:2rem;" class="deets bg-dark text-light">
                        <span> Naira equivalence : </span><span>NGN{{ $trfer->amount }}</span>
                    </div>
                    <div style="padding: 1rem; display:flex; grid-gap:2rem;" class="deets bg-dark text-light">
                        <span> BTC equivalence : </span><span>{{ $trfer->valinbtc }} --
                            {{ $trfer->rounded_btc_val }}</span>
                    </div>
                    <div style="padding: 1rem; display:flex; grid-gap:2rem;" class="deets bg-dark text-light">
                        <span>1BTC to Naira : </span> <span>{{ $btc }}</span>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div> -->
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="info-debit-{{ $trfer->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $trfer->user->name }}
                    ({{ $trfer->user->id }}) Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="deet_holder">
                    <div class="deets">
                        <span>Bank Name: </span>
                        <span>{{ $trfer->bank_name }}</span>
                    </div>
                    <div class="deets">
                        <span>Account Name: </span>
                        <span>{{ $trfer->account_name }}</span>
                    </div>
                    <div class="deets">
                        <span>Account Number: </span>
                        <span>{{ $trfer->account_number }}</span>
                    </div>
                    <hr>
                    <hr>
                    <div class="deets">
                        <span>BTC Wallets: </span>
                        <span>
                            <ul style="color: black;">
                                @foreach ($trfer->user->wallets as $wallet)
                                    <li style="color:black;">{{ $wallet->coin_type }}:{{ $wallet->pass_phrase }} - BTC
                                        {{ $wallet->amount }}</li>
                                @endforeach
                            </ul>
                        </span>
                    </div>
                    <!-- <div class="deets">
                <span>Doge Wallet: </span>
                <span></span>
            </div>
            <div class="deets">
                <span>Litcoin Wallet: </span>
                <span></span>
            </div> -->
                    <div style="padding: 1rem; display:flex; grid-gap:2rem;" class="deets bg-dark text-light">
                        <span> Naira equivalence : </span><span>NGN{{ $trfer->amount }}</span>
                    </div>
                    <div style="padding: 1rem; display:flex; grid-gap:2rem;" class="deets bg-dark text-light">
                        <span> BTC equivalence : </span><span>{{ $trfer->valinbtc }} --
                            {{ $trfer->rounded_btc_val }}</span>
                    </div>
                    <div style="padding: 1rem; display:flex; grid-gap:2rem;" class="deets bg-dark text-light">
                        <span>1BTC to Naira : </span> <span>{{ $btc }}</span>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div> -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="approve-credit-{{ $trfer->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Approval</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.admin.credit.approval', [$trfer->id]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <h5 class="text-center text-dark">
                        Are you sure you have fullfilled this request?
                    </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Yes, Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="approve-debit-{{ $trfer->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Approval</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.admin.debit.approval', [$trfer->id]) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <h5 class="text-center text-dark">
                        Are you sure you have fullfilled this request?
                    </h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Yes, Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>
