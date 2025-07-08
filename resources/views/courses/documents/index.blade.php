@extends('layouts.dashboard')

@section('page-title', __('documents.management') . ' - ' . $course->title)

@section('content')
<div class="table-section">
    <div class="table-header">
        <div class="d-flex gap-3 align-items-center">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ __('documents.add_filter') }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">{{ __('documents.file_type') }}</a></li>
                    <li><a class="dropdown-item" href="#">{{ __('documents.upload_date') }}</a></li>
                </ul>
            </div>
            <div class="search-box flex-grow-1">
                <form method="GET" action="" class="w-100">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="{{ __('documents.search_placeholder') }}" value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>{{ __('documents.back_to_courses') }}
            </a>
            <button class="btn btn-outline-secondary">{{ __('documents.clear_all') }}</button>
            <button class="btn btn-primary" id="add-document-btn" data-bs-toggle="modal" data-bs-target="#documentModal">
                <i class="fas fa-plus me-2"></i>{{ __('documents.add_new') }}
            </button>
        </div>
    </div>
    
    <!-- Course Info Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="card-text text-muted">{{ $course->description }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1"><strong>{{ __('documents.teacher') }}:</strong> {{ $course->teacher->firstname ?? '' }} {{ $course->teacher->lastname ?? '' }}</p>
                    <p class="mb-1"><strong>{{ __('documents.group') }}:</strong> {{ $course->group->name ?? '' }}</p>
                    <p class="mb-0"><strong>{{ __('documents.status') }}:</strong> 
                        <span class="status-badge {{ $course->status ? 'active' : 'inactive' }}">
                            {{ $course->status ? __('documents.active') : __('documents.inactive') }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('documents.id') }}</th>
                <th>{{ __('documents.title') }}</th>
                <th>{{ __('documents.description') }}</th>
                <th>{{ __('documents.file_type') }}</th>
                <th>{{ __('documents.file_size') }}</th>
                <th>{{ __('documents.upload_date') }}</th>
                <th>{{ __('documents.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $document)
            <tr>
                <td>{{ $document->id }}</td>
                <td>{{ $document->title }}</td>
                <td>{{ Str::limit($document->description, 50) }}</td>
                <td>
                    <span class="badge bg-light text-dark">
                        <i class="fas fa-{{ $document->file_type === 'pdf' ? 'file-pdf' : ($document->file_type === 'image' ? 'image' : 'video') }} me-1"></i>
                        {{ strtoupper($document->file_type) }}
                    </span>
                </td>
                <td>{{ $document->formatted_file_size }}</td>
                <td>{{ $document->created_at->format('Y-m-d H:i') }}</td>
                <td class="actions-cell">
                    <div class="d-flex gap-2">
                        <a href="{{ route('courses.documents.download', [$course->id, $document->id]) }}" 
                           class="btn btn-sm btn-icon btn-outline-primary" 
                           title="{{ __('documents.download') }}">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="btn btn-sm btn-icon btn-outline-primary edit-document-btn" 
                                data-id="{{ $document->id }}" 
                                title="{{ __('documents.edit') }}" 
                                data-bs-toggle="modal" 
                                data-bs-target="#documentModal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-outline-danger delete-document" 
                                data-id="{{ $document->id }}" 
                                title="{{ __('documents.delete') }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">
                    <div class="text-muted">
                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                        <p>{{ __('documents.no_documents') }}</p>
                        <button class="btn btn-primary" id="add-first-document-btn" data-bs-toggle="modal" data-bs-target="#documentModal">
                            <i class="fas fa-plus me-2"></i>{{ __('documents.add_first_document') }}
                        </button>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($documents->hasPages())
    <div class="table-pagination">
        <div>
            <span class="text-muted">{{ __('documents.showing') }} {{ $documents->firstItem() ?? 0 }} {{ __('documents.to') }} {{ $documents->lastItem() ?? 0 }} {{ __('documents.of') }} {{ $documents->total() ?? 0 }} {{ __('documents.results') }}</span>
        </div>
        <div class="page-numbers">
            {{ $documents->links() }}
        </div>
    </div>
    @endif
</div>

<!-- Document CRUD Modal -->
<div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="document-modal-content">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteDocumentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">{{ __('documents.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('documents.delete_confirm') }}</p>
                <form id="deleteDocumentForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('documents.cancel') }}</button>
                        <button type="submit" class="btn btn-danger px-4">{{ __('documents.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Documents page script loaded');
    
    // Get the document modal
    const documentModal = document.getElementById('documentModal');
    
    // Add event listeners for modal cleanup
    if (documentModal) {
        documentModal.addEventListener('hidden.bs.modal', function() {
            console.log('Document modal hidden, cleaning up...');
            if (window.cleanupModalBackdrop) {
                window.cleanupModalBackdrop();
            }
        });
        
        documentModal.addEventListener('shown.bs.modal', function() {
            console.log('Document modal shown');
        });
    }
    
    // Add Document
    document.getElementById('add-document-btn').addEventListener('click', function(e) {
        console.log('Add document button clicked');
        loadDocumentForm('{{ route("courses.documents.create-form", $course->id) }}');
    });
    
    // Add First Document (when no documents exist)
    const addFirstDocumentBtn = document.getElementById('add-first-document-btn');
    if (addFirstDocumentBtn) {
        addFirstDocumentBtn.addEventListener('click', function(e) {
            console.log('Add first document button clicked');
            loadDocumentForm('{{ route("courses.documents.create-form", $course->id) }}');
        });
    }
    
    // Edit Document
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-document-btn') || e.target.closest('.edit-document-btn')) {
            const button = e.target.classList.contains('edit-document-btn') ? e.target : e.target.closest('.edit-document-btn');
            const documentId = button.getAttribute('data-id');
            console.log('Edit document button clicked for ID:', documentId);
            loadDocumentForm(`/courses/{{ $course->id }}/documents/${documentId}/edit-form`);
        }
    });
    
    // Delete Document
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-document') || e.target.closest('.delete-document')) {
            const button = e.target.classList.contains('delete-document') ? e.target : e.target.closest('.delete-document');
            const documentId = button.getAttribute('data-id');
            console.log('Delete document button clicked for ID:', documentId);
            
            const deleteModal = new bootstrap.Modal(document.getElementById('deleteDocumentModal'));
            const deleteForm = document.getElementById('deleteDocumentForm');
            deleteForm.action = `/courses/{{ $course->id }}/documents/${documentId}`;
            deleteModal.show();
        }
    });
    
    // Load document form
    function loadDocumentForm(url) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('document-modal-content').innerHTML = html;
                const modal = new bootstrap.Modal(document.getElementById('documentModal'));
                modal.show();
                
                // Initialize form handlers
                initializeDocumentForm();
            })
            .catch(error => {
                console.error('Error loading document form:', error);
                alert('Error loading document form');
            });
    }
    
    // Initialize document form handlers
    function initializeDocumentForm() {
        const form = document.getElementById('documentForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close modal and reload page
                        const modal = bootstrap.Modal.getInstance(document.getElementById('documentModal'));
                        modal.hide();
                        location.reload();
                    } else {
                        alert(data.message || 'Error saving document');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error saving document');
                });
            });
        }
    }
});
</script>
@endpush 