<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="edit-{{ $faq->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('faq.update', [$faq->id]) }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="" class="form-label">Question</label>
                        <textarea name="question" id="" cols="30" rows="3"
                            class="form-control">{{ $faq->question }}</textarea>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Select FAQ Category</label>
                        <select name="category" id="" class="form-select">
                            <option value="">Select FAQ Category</option>
                            @foreach ($faqcategories as $category)
                                <option value="{{ $category->id }}" {{ $faq->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="form-group mt-4">
                        <label for="" class="form-label">Answer</label>
                        <textarea name="answer" id="" cols="30" rows="7"
                            class="form-control">{!! $faq->answer !!}</textarea>
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
