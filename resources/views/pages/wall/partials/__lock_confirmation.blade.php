
<!-- Modal -->
<div class="modal fade" id="lock-{{$wallet->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Locks</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="{{route('user.lock', [Auth::user()->id])}}" method="post">
                @csrf 
                <div class="form-group">
                    <label for="" class="form-label">Locate Lock Duration</label>
                    <select name="duration" class="form-select" aria-label="Default select example">
                        @foreach($locks as $lock)
                        <option value="{{$lock->duration}}">{{$lock->duration}} Month</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mt-4">
                    <label for="" class="form-label">Wallet</label>
                    <input type="text" readonly value="{{$wallet->pass_phrase}}" name="wallet" class="form-control">
                </div>
                <div class="form-group mt-4">
                    <label for="" class="form-label">Amount</label>
                    <input type="text" readonly value="{{$wallet->balance}}" name="amount" class="form-control">
                </div>
                <div class="form-group mt-4">
                    <label for="" class="form-label">Coin Type</label>
                    <input type="text" readonly value="{{$wallet->coin_type}}" name="type" class="form-control">
                </div>
                <div class="form-group mt-4">
                    <!-- <label for="" class="form-label"></label> -->
                    <a href="">Read More Wallet Locking</a>
                </div>
                <div class="form-group mt-4">
                    <button style="float:right;" class="btn btn-primary">Save Lock</button>
                </div>
            </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div> -->
    </div>
  </div>
</div>