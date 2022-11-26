<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="create-faq" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.admin.faq.create') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Question</label>
                        <textarea name="question" id="" cols="30" rows="2"
                            class="form-control">{{ old('question') }}</textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Select FAQ Category</label>
                        <select name="category" id="" class="form-select">
                            <option value="">Select FAQ Category</option>
                            @foreach ($faqcategories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
        
                    </div>
                    <div class="form-group mt-4">
                        <label for="" class="form-label">Answer</label>
                        <textarea name="answer" id="" cols="30" rows="7"
                            class="form-control">{{ old('answer') }}</textarea>
                    </div>
                    <div class="form-group mt-3 text-right">
                        <button style="float:right;" class="btn btn-sm btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
        </div>
    </div>
</div>
