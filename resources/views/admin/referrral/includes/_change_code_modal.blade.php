

<!-- Modal -->
<div class="modal fade" id="code-{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Changing {{$user->name}}'s Code</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form action="{{ route('panel.admin.refcode.update', $user->id) }}" class="form" method="POST">
                @csrf
                <div class="form-group mt-3">
                    <label for="" class="form-label">User Code</label>
                    <input type="text" name="referral_code" value="{{$user->mycode}}" class="form-control">
                </div>
                <div class="form-group mt-3">
                    <button style="float: right;" class="btn btn-info btn-sm">
                        save
                    </button>
                </div>
            </form>
      </div>
   
    </div>
  </div>
</div>