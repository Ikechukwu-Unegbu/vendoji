<!-- Modal -->
@foreach ($admins as $admin)
<div class="modal fade" id="appoint-{{ $admin->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="appoint-{{ $admin->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="appoint-{{ $admin->id }}">Appoint {{ $admin->name }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.admins.appoint', $admin->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center">
                        <h3>Are you Sure?</h3>
                        <h5>You want to Appoint <strong class="text-danger">{{ $admin->name }}</strong> as <strong>Superadmin</strong></h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Appoint</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="revoke-{{ $admin->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="revoke-{{ $admin->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="revoke-{{ $admin->id }}">Revoke {{ $admin->name }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('panel.admins.revoke', $admin->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center">
                        <h3>Are you Sure?</h3>
                        <h5>You want to Revoke <strong class="text-danger">{{ $admin->name }}</strong></h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-ban"></i> Revoke</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
