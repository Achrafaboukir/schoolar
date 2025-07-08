@extends('layouts.dashboard')

@section('page-title', __('courses.course_documents'))

@section('content')
<div class="container mt-4">
    <h2>{{ __('courses.course_documents') }} - {{ $course->title }}</h2>
    <div class="mb-3">
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">&larr; {{ __('courses.back_to_courses') }}</a>
        <button class="btn btn-primary" id="addDocumentBtn">
            <i class="fas fa-plus me-1"></i> {{ __('courses.upload_document') }}
        </button>
    </div>
    <!-- Upload Document Modal -->
    <div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploadDocumentModalLabel">{{ __('courses.upload_document') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="uploadDocumentForm" method="POST" enctype="multipart/form-data" action="{{ route('courses.documents.store', $course->id) }}">
            @csrf
            <div class="modal-body">
              <div class="mb-3">
                <label for="title" class="form-label">{{ __('courses.document_title') }}</label>
                <input type="text" class="form-control" id="title" name="title" required>
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">{{ __('courses.document_description') }}</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
              </div>
              <div class="mb-3">
                <label for="file_type" class="form-label">{{ __('courses.document_type') }}</label>
                <select class="form-select" id="file_type" name="file_type" required>
                  <option value="pdf">PDF</option>
                  <option value="image">Image</option>
                  <option value="video">Video</option>
                  <option value="other">Other</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="document" class="form-label">{{ __('courses.document_file') }}</label>
                <input type="file" class="form-control" id="document" name="document" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('courses.cancel') }}</button>
              <button type="submit" class="btn btn-primary">{{ __('courses.upload_document') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Edit Document Modal -->
    <div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editDocumentModalLabel">{{ __('courses.edit_document') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="editDocumentForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="mb-3">
                <label for="edit_title" class="form-label">{{ __('courses.document_title') }}</label>
                <input type="text" class="form-control" id="edit_title" name="title" required>
              </div>
              <div class="mb-3">
                <label for="edit_description" class="form-label">{{ __('courses.document_description') }}</label>
                <textarea class="form-control" id="edit_description" name="description" required></textarea>
              </div>
              <div class="mb-3">
                <label for="edit_file_type" class="form-label">{{ __('courses.document_type') }}</label>
                <select class="form-select" id="edit_file_type" name="file_type" required>
                  <option value="pdf">PDF</option>
                  <option value="image">Image</option>
                  <option value="video">Video</option>
                  <option value="other">Other</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="edit_document" class="form-label">{{ __('courses.document_file') }} ({{ __('courses.optional') }})</label>
                <input type="file" class="form-control" id="edit_document" name="document">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('courses.cancel') }}</button>
              <button type="submit" class="btn btn-primary">{{ __('courses.save_changes') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Documents Table -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>{{ __('courses.document_title') }}</th>
                <th>{{ __('courses.document_type') }}</th>
                <th>{{ __('courses.document_file') }}</th>
                <th>{{ __('courses.document_description') }}</th>
                <th>{{ __('courses.actions') }}</th>
            </tr>
        </thead>
        <tbody>
        @forelse($documents as $doc)
            <tr>
                <td>{{ $doc->title }}</td>
                <td>{{ ucfirst($doc->file_type) }}</td>
                <td>
                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank">{{ __('courses.view') }}</a>
                </td>
                <td>{{ $doc->description }}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary edit-document-btn" 
                        data-id="{{ $doc->id }}"
                        data-title="{{ $doc->title }}"
                        data-description="{{ $doc->description }}"
                        data-type="{{ $doc->file_type }}"
                        data-bs-toggle="modal" data-bs-target="#editDocumentModal">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('courses.documents.destroy', [$course->id, $doc->id]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('courses.delete_confirm') }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">{{ __('courses.no_documents') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show upload modal
    document.getElementById('addDocumentBtn').addEventListener('click', function() {
        document.getElementById('uploadDocumentForm').reset();
        var uploadModal = new bootstrap.Modal(document.getElementById('uploadDocumentModal'));
        uploadModal.show();
    });

    // Populate and show edit modal
    document.querySelectorAll('.edit-document-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('edit_title').value = this.dataset.title;
            document.getElementById('edit_description').value = this.dataset.description;
            document.getElementById('edit_file_type').value = this.dataset.type;
            var form = document.getElementById('editDocumentForm');
            form.action = `/courses/{{ $course->id }}/documents/${this.dataset.id}`;
        });
    });
});
</script>
@endpush
