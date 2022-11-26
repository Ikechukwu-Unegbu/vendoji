
<!-- Modal -->
<div class="modal fade" id="bank-{{$bank->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Activate Account </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5 class="text-center text-dark">Are you sure about activating this account?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="{{route('panel.bank.activate', [$bank->id])}}" class="btn btn-sm btn-primary" >Yes, Proceed</a>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="bank-stop-{{$bank->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Deactivate Account</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5 class="text-center text-dark">Are you sure, about deactivate this account?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="{{route('panel.bank.deactivate', [$bank->id])}}" class="btn btn-sm btn-primary" >Yes, Proceed</a>
      </div>
    </div>
  </div>
</div>