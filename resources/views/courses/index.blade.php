@extends('layouts.dashboard')

@section('page-title', __('courses.management'))

@section('content')
<div class="table-section">
    <div class="table-header">
        <div class="d-flex gap-3 align-items-center">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ __('courses.add_filter') }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">{{ __('courses.status') }}</a></li>
                    <li><a class="dropdown-item" href="#">{{ __('courses.teacher') }}</a></li>
                    <li><a class="dropdown-item" href="#">{{ __('courses.group') }}</a></li>
                </ul>
            </div>
            <div class="search-box flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="{{ __('courses.search_placeholder') }}">
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary">{{ __('courses.clear_all') }}</button>
            <button class="btn btn-primary" id="add-course-btn">
                <i class="fas fa-plus me-2"></i>{{ __('courses.add_new') }}
            </button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('courses.id') }}</th>
                <th>{{ __('courses.status') }}</th>
                <th>{{ __('courses.title') }}</th>
                <th>{{ __('courses.teacher') }}</th>
                <th>{{ __('courses.group') }}</th>
                <th>{{ __('courses.start_date') }}</th>
                <th>{{ __('courses.end_date') }}</th>
                <th>{{ __('courses.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses ?? [] as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td><span class="status-badge {{ $course->status ? 'active' : 'inactive' }}">
                    {{ $course->status ? 'ACTIVE' : 'INACTIVE' }}
                </span></td>
                <td>{{ $course->title }}</td>
                <td>{{ $course->teacher->firstname }} {{ $course->teacher->lastname }}</td>
                <td>{{ $course->group->name }}</td>
                <td>{{ $course->start_date->format('Y-m-d') }}</td>
                <td>{{ $course->end_date->format('Y-m-d') }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-icon btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-gears"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item edit-course-btn" 
                                   href="#" 
                                   data-id="{{ $course->id }}">
                                    <i class="fas fa-edit me-2"></i>{{ __('courses.edit') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item delete-course" 
                                   href="#" 
                                   data-id="{{ $course->id }}">
                                    <i class="fas fa-trash me-2"></i>{{ __('courses.delete') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item upload-document" 
                                   href="#" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#uploadDocumentModal"
                                   data-course-id="{{ $course->id }}">
                                    <i class="fas fa-upload me-2"></i>{{ __('courses.upload_document') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item view-documents" 
                                   href="#" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#viewDocumentsModal"
                                   data-course-id="{{ $course->id }}"
                                   data-course-title="{{ $course->title }}">
                                    <i class="fas fa-file me-2"></i>{{ __('courses.view_documents') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="table-pagination">
        <div>
            <span class="text-muted">{{ __('courses.showing') }} {{ $courses->firstItem() ?? 0 }} {{ __('courses.to') }} {{ $courses->lastItem() ?? 0 }} {{ __('courses.of') }} {{ $courses->total() ?? 0 }} {{ __('courses.results') }}</span>
        </div>
        <div class="page-numbers">
            {{ $courses->links() }}
        </div>
    </div>
</div>

<!-- Course CRUD Modal (AJAX content loaded here) -->
<div class="modal fade" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="course-modal-content">
      <!-- Modal content will be loaded here -->
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCourseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">{{ __('courses.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('courses.delete_confirm') }}</p>
                <form id="deleteCourseForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('courses.cancel') }}</button>
                        <button type="submit" class="btn btn-danger px-4">{{ __('courses.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Upload Document Modal -->
<div class="modal fade" id="uploadDocumentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">{{ __('courses.upload_document') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="uploadDocumentForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">{{ __('courses.document_title') }}</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ __('courses.document_description') }}</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('courses.document_type') }}</label>
                            <select class="form-select" name="file_type" required>
                                <option value="video">{{ __('courses.video') }}</option>
                                <option value="image">{{ __('courses.image') }}</option>
                                <option value="pdf">{{ __('courses.pdf') }}</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ __('courses.document_file') }}</label>
                            <input type="file" class="form-control" name="document" required>
                            <small class="text-muted">{{ __('courses.max_file_size') }}</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('courses.cancel') }}</button>
                        <button type="submit" class="btn btn-primary px-4">{{ __('courses.upload_document') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Documents Modal -->
<div class="modal fade" id="viewDocumentsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">{{ __('courses.course_documents') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="documents-container">
                    <div class="row g-3" id="documentsList">
                        <!-- Documents will be loaded here dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.documents-container {
    max-height: 60vh;
    overflow-y: auto;
}

.document-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
}

.document-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.document-icon.video {
    background: rgba(127, 86, 217, 0.1);
    color: var(--primary-color);
}

.document-icon.image {
    background: rgba(54, 179, 126, 0.1);
    color: #36B37E;
}

.document-icon.pdf {
    background: rgba(240, 68, 56, 0.1);
    color: #F04438;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Course
    document.getElementById('add-course-btn').addEventListener('click', function() {
        fetch("{{ route('courses.create-form') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('course-modal-content').innerHTML = html;
                new bootstrap.Modal(document.getElementById('courseModal')).show();
                
                // Add form submission handler
                setupFormSubmission();
            });
    });

    // Edit Course
    document.querySelectorAll('.edit-course-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            fetch(`/courses/${id}/edit-form`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('course-modal-content').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('courseModal')).show();
                    
                    // Add form submission handler
                    setupFormSubmission();
                });
        });
    });

    // Delete Course
    const deleteButtons = document.querySelectorAll('.delete-course');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const courseId = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('deleteCourseModal'));
            const form = document.getElementById('deleteCourseForm');
            form.action = `/courses/${courseId}`;
            modal.show();
        });
    });

    // Document Upload
    const uploadButtons = document.querySelectorAll('.upload-document');
    uploadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const courseId = this.dataset.courseId;
            const form = document.getElementById('uploadDocumentForm');
            form.action = `/courses/${courseId}/documents`;
        });
    });

    // View Documents
    const viewDocumentsButtons = document.querySelectorAll('.view-documents');
    viewDocumentsButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const courseId = this.dataset.courseId;
            const courseTitle = this.dataset.courseTitle;
            const modal = document.getElementById('viewDocumentsModal');
            const documentsList = document.getElementById('documentsList');
            
            try {
                const response = await fetch(`/courses/${courseId}/documents`);
                const data = await response.json();
                
                modal.querySelector('.modal-title').textContent = `Documents - ${courseTitle}`;
                
                documentsList.innerHTML = data.documents.map(doc => `
                    <div class="col-md-6">
                        <div class="document-card">
                            <div class="d-flex gap-3 align-items-center">
                                <div class="document-icon ${doc.file_type}">
                                    <i class="fas ${getDocumentIcon(doc.file_type)}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">${doc.title}</h6>
                                    <p class="text-muted small mb-1">${doc.description || ''}</p>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-light text-dark">${doc.formatted_file_size}</span>
                                        <span class="badge bg-light text-dark">${formatDate(doc.created_at)}</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="/storage/${doc.file_path}" 
                                       class="btn btn-sm btn-icon btn-outline-primary" 
                                       target="_blank"
                                       title="View/Download">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button class="btn btn-sm btn-icon btn-outline-danger delete-document"
                                            data-id="${doc.id}"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `).join('');

                // Add delete document handlers
                documentsList.querySelectorAll('.delete-document').forEach(btn => {
                    btn.addEventListener('click', async function() {
                        if (confirm('Are you sure you want to delete this document?')) {
                            const docId = this.dataset.id;
                            try {
                                await fetch(`/course-documents/${docId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                    }
                                });
                                this.closest('.col-md-6').remove();
                            } catch (error) {
                                console.error('Error deleting document:', error);
                                alert('Failed to delete document');
                            }
                        }
                    });
                });
            } catch (error) {
                console.error('Error loading documents:', error);
                documentsList.innerHTML = '<div class="col-12"><p class="text-danger">Failed to load documents</p></div>';
            }
        });
    });

    function getDocumentIcon(type) {
        switch (type) {
            case 'video': return 'fa-video';
            case 'image': return 'fa-image';
            case 'pdf': return 'fa-file-pdf';
            default: return 'fa-file';
        }
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString();
    }

    // Setup AJAX form submission
    function setupFormSubmission() {
        const form = document.getElementById('courseForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                // Disable submit button and show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                
                fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        // If there's a redirect, reload the page
                        window.location.reload();
                    } else {
                        return response.json();
                    }
                })
                .then(data => {
                    if (data && data.success) {
                        // Close modal and reload page
                        bootstrap.Modal.getInstance(document.getElementById('courseModal')).hide();
                        window.location.reload();
                    } else if (data && data.errors) {
                        // Show validation errors
                        showValidationErrors(data.errors);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // On error, reload page to show any flash messages
                    window.location.reload();
                })
                .finally(() => {
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
        }
    }

    // Show validation errors
    function showValidationErrors(errors) {
        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });

        // Show new errors
        Object.keys(errors).forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = errors[field][0];
                input.parentNode.appendChild(errorDiv);
            }
        });
    }
});
</script>
@endpush
