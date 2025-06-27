<form method="POST" action="{{ $action }}" id="courseForm" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card shadow-sm border-0 mb-0">
        <div class="card-body">
            <h5 class="mb-4"><i class="fas fa-book me-2 text-primary"></i> Course Information</h5>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Course Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $course->title ?? old('title') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $course->description ?? old('description') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teacher</label>
                    <select name="teacher_id" class="form-select" required>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @if(isset($course) && $course->teacher_id == $teacher->id) selected @endif>{{ $teacher->firstname }} {{ $teacher->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Group</label>
                    <select name="group_id" class="form-select" required>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" @if(isset($course) && $course->group_id == $group->id) selected @endif>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ isset($course) ? $course->start_date?->format('Y-m-d') : old('start_date') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ isset($course) ? $course->end_date?->format('Y-m-d') : old('end_date') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="1" @if(isset($course) && $course->status == 1) selected @endif>Active</option>
                        <option value="0" @if(isset($course) && $course->status == 0) selected @endif>Inactive</option>
                    </select>
                </div>
            </div>
            
            @if(!isset($course))
            <hr class="my-4">
            <h5 class="mb-4"><i class="fas fa-file-upload me-2 text-primary"></i> Course Materials</h5>
            <div class="row g-3">
                <div class="col-12" id="documentInputs">
                    <div class="document-input mb-3">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Document Title</label>
                                <input type="text" class="form-control" name="documents[0][title]">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="documents[0][description]" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Document Type</label>
                                <select class="form-select" name="documents[0][file_type]">
                                    <option value="video">Video</option>
                                    <option value="image">Image</option>
                                    <option value="pdf">PDF</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">File</label>
                                <input type="file" class="form-control" name="documents[0][file]">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                    <button type="button" class="btn btn-outline-secondary w-100" id="addMoreDocuments">
                        <i class="fas fa-plus me-2"></i>Add Another Document
                    </button>
                </div>
            </div>
            @endif
        </div>
        <div class="card-footer bg-white border-0 d-flex justify-content-between gap-2 py-3">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancel</button>
            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>{{ $submitLabel }}</button>
        </div>
    </div>
</form>

@if(!isset($course))
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle dynamic document inputs
    let documentCounter = 1;
    
    function createDocumentInput(index) {
        return `
            <div class="document-input mb-3">
                <div class="row g-3">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Document ${index + 1}</h6>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-document">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Document Title</label>
                        <input type="text" class="form-control" name="documents[${index}][title]">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="documents[${index}][description]" rows="2"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Document Type</label>
                        <select class="form-select" name="documents[${index}][file_type]">
                            <option value="video">Video</option>
                            <option value="image">Image</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">File</label>
                        <input type="file" class="form-control" name="documents[${index}][file]">
                    </div>
                </div>
            </div>
        `;
    }

    document.getElementById('addMoreDocuments')?.addEventListener('click', function() {
        const documentsContainer = document.getElementById('documentInputs');
        documentsContainer.insertAdjacentHTML('beforeend', createDocumentInput(documentCounter++));
    });

    // Handle document removal
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-document')) {
            e.target.closest('.document-input').remove();
        }
    });
});
</script>
@endif 