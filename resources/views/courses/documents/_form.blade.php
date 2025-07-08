<form method="POST" action="{{ $action }}" id="documentForm" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card shadow-sm border-0 mb-0">
        <div class="card-body">
            <h5 class="mb-4"><i class="fas fa-file-upload me-2 text-primary"></i> {{ __('documents.document_information') }}</h5>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">{{ __('documents.document_title') }}</label>
                    <input type="text" name="title" class="form-control" value="{{ $document->title ?? old('title') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">{{ __('documents.document_description') }}</label>
                    <textarea name="description" class="form-control" rows="3">{{ $document->description ?? old('description') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('documents.document_type') }}</label>
                    <select name="file_type" class="form-select" required>
                        <option value="">{{ __('documents.select_file_type') }}</option>
                        <option value="pdf" @if(isset($document) && $document->file_type === 'pdf') selected @endif>{{ __('documents.pdf') }}</option>
                        <option value="image" @if(isset($document) && $document->file_type === 'image') selected @endif>{{ __('documents.image') }}</option>
                        <option value="video" @if(isset($document) && $document->file_type === 'video') selected @endif>{{ __('documents.video') }}</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">{{ __('documents.document_file') }}</label>
                    <input type="file" name="document" class="form-control" accept=".pdf,image/*,video/*" {{ isset($document) ? '' : 'required' }}>
                    <small class="text-muted">{{ __('documents.max_file_size') }}</small>
                    @if(isset($document))
                        <div class="mt-2">
                            <small class="text-muted">{{ __('documents.current_file') }}: {{ basename($document->file_path) }}</small>
                            <br>
                            <small class="text-muted">{{ __('documents.leave_blank_to_keep') }}</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 d-flex justify-content-between gap-2 py-3">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>{{ __('documents.cancel') }}</button>
            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>{{ $submitLabel }}</button>
        </div>
    </div>
</form> 