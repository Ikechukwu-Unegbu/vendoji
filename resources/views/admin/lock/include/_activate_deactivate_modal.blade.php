
<!-- activate modal -->
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="activate-{{$lock->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Activate Duration Entry </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <h5 class="text-center">Are you sure you want activate this?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="{{route('lock.activate', [$lock->id])}}" class="btn btn-sm btn-primary">Yes, activate</a>
      </div>
    </div>
  </div>
</div>


<!-- deactivate modal -->
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="deactivate-{{$lock->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deactivate Duration Entry</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Are you sure you want to deactivate this?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <a href="{{route('lock.deactivate', [$lock->id])}}" class="btn btn-primary btn-sm">Yes, Deactivate</a>
      </div>
    </div>
  </div>
</div>