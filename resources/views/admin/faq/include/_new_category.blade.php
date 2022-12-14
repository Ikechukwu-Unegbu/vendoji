<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary">
  Launch static backdrop modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="new-cate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('new.faq.cate')}}" method="post">
            @csrf
            <div class="form-group mt-3">
                <label for="" class="form-label">Name</label>
                <input type="text" name="name" class="form-control">
            </div>
            <div class="form-group mt-3">
                <label for="" class="form-label">Description</label>
                <textarea name="description" id="" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div class="form-group mt-3">
                <button style="float: right;" class="btn btn-sm btn-primary">Save</button>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Understood</button> -->
      </div>
    </div>
  </div>
</div>