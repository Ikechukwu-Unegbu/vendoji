
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="" style="display: flex; flex-direction:column;">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Update Referral Rule</h1>
        <h1 class="modal-title fs-5">Rate: {{$refrule->reward}} -- Min Amount: {{$refrule->min_amount}}</h1>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('ref.update.rule')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="" class="form-label">Reward in Percentage</label>
                <input type="text" name="reward" class="form-control" value="{{$refrule->reward}} ">
            </div>
            <div class="form-group mt-3">
                <label for="" class="form-label">
                    Min Amount to Reward
                </label>
                <input type="text" name="min_amount" class="form-control" value="{{$refrule->min_amount}}">
            </div>

            <div class="form-group mt-3">
                <button style="float: right;" class="btn btn-sm btn-primary">
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
