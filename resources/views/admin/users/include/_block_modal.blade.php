<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" ">
  Launch static backdrop modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="block-{{$user->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Confirm Blocking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5 class="text-center">Are you sure you want to block this user - {{$user->name}}?</h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <a href="{{route('panel.users.block', [$user->id])}}" class="btn btn-primary btn-sm">Yes, Block</a>
      </div>
    </div>
  </div>
</div>