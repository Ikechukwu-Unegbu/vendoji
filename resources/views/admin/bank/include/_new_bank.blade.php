
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Bank</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('panel.bank.store')}}" method="post">
            @csrf 
            <div class="form-group mt-3">
                <label for="" class="form-label">Bank Name</label>
                <input type="text" name="bank_name"class="form-control">
            </div>
            <div class="form-group mt-3">
                <label for="" class="form-label">Account Number</label>
                <input type="text" name="account_number" class="form-control">
            </div>
            <div class="form-group mt-3">
                <label for="" class="form-label">Account Name</label>
                <input type="text" name="account_name" class="form-control">
            </div>
            <div class="form-group mt-3">
                <label for="" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group mt-3">
                <button style="float: right;" class="btn btn-primary btn-sm">
                    Save
                </button>
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