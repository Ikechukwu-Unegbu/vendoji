<!-- Modal -->
<div class="modal fade" id="create_earning" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Percentage Earning</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.earning.percentage') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="wallet_percentage" class="form-label">Enter Percentage <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('wallet_percentage') is-invalid @enderror"
                            name="wallet_percentage" id="wallet_percentage">
                        @error('wallet_percentage')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <label for="wallet" class="form-label">Select Wallet <span class="text-danger">*</span></label>
                        <select class="form-select @error('wallet') is-invalid @enderror"
                            aria-label="Default select example" name="wallet">
                            <option value="">Open this select menu</option>
                            <option value="btc">BTC</option>
                            <option value="lite">LITE</option>
                            <option value="doge">DOGE</option>
                        </select>
                        @error('wallet')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
