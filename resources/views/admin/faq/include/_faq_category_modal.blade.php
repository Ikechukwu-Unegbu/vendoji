<!-- Modal -->
<div class="modal fade" id="edit-{{ $cate->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit {{ $cate->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.admin.faqcategory.edit', $cate->id) }}" method="POST">
                    @csrf
                    <div class="form-group mt-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $cate->name }}">
                    </div>
                    <div class="form-group mt-3">
                        <label for="" class="form-label">Description</label>
                        <textarea name="description" id="" cols="30" rows="5"
                            class="form-control">{{ $cate->description }}</textarea>
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


<div class="modal fade" id="delete-{{ $cate->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('panel.admin.faqcategory.delete', $cate->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Deletion Modal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 class="text-center">Are you sure about deleting this?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" href="{{ 'e' }}" class="btn btn-primary btn-sm"> Yes, delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
