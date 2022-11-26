

<!-- Modal -->
<div class="modal fade" id="delete-{{$faq->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deletion Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5 class="text-center">Are you sure about deleting this?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <a href="{{route('faq.del', [$faq->id])}}" class="btn btn-primary btn-sm"> Yes, delete</a>
      </div>
    </div>
  </div>
</div>