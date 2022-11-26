

<!-- Modal -->
<div class="modal fade" id="new-lock" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Create Duration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('lock.store')}}" method="post" class="form">
            @csrf 
            <div class="form-group mt-3">
                <label for="" class="form-label">Duration</label>
                <input type="text" name="duration" class="form-control">
            </div>
            <div class="form-group mt-3">
                <button style="float: right;" class="btn btn-sm btn-primary">Create</button>
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