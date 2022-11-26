
<!-- Modal -->
<div class="modal fade" id="unlock-{{$wallet->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Unlock Wallet</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="{{route('user.lock.cancel', [Auth::user()->id, $wallet->id])}}" method="post">
                @csrf 
               <div class="form-group mt-3">
               <div class="form-check">
                    <input class="form-check-input" name="check" required type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Are you sure about this? 
                    </label>
                    </div>
               </div>
               <div class="form-group mt-3">
                    <label for="" class="form-label">Why Are you unlocking?</label>
                    <select class="form-select" name="cancel_reason" aria-label="Default select example">
                        <!-- <option selected>Open this select menu</option> -->
                        <option value="1">Personal problems</option>
                        <option value="2">School fees</option>
                        <option value="3">Health crisis</option>
                        <option value="5">Daily Expenses</option>
                        <option value="4">Others</option>
                    </select>
               </div>
               <div class="form-group mt-4">
                    <button style="float: right;" class="btn btn-primary">Send</button>
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