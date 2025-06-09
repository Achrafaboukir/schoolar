@extends('layouts.dashboard')

@section('page-title', 'Course Management')

@section('content')
<div class="table-section">
    <div class="table-header">
        <div class="d-flex gap-3 align-items-center">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    Add filter
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Status</a></li>
                    <li><a class="dropdown-item" href="#">Teacher</a></li>
                    <li><a class="dropdown-item" href="#">Group</a></li>
                </ul>
            </div>
            <div class="search-box flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search for a course by title">
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary">Clear all</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCourseModal">
                <i class="fas fa-plus me-2"></i>Add new course
            </button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>STATUS</th>
                <th>TITLE</th>
                <th>TEACHER</th>
                <th>GROUP</th>
                <th>START DATE</th>
                <th>END DATE</th>
                <th>ACTIONS</th>
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
                                <a class="dropdown-item edit-course" 
                                   href="#" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#editCourseModal"
                                   data-course="{{ json_encode($course) }}">
                                    <i class="fas fa-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item delete-course" 
                                   href="#" 
                                   data-id="{{ $course->id }}">
                                    <i class="fas fa-trash me-2"></i>Delete
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item upload-document" 
                                   href="#" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#uploadDocumentModal"
                                   data-course-id="{{ $course->id }}">
                                    <i class="fas fa-upload me-2"></i>Upload Document
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item view-documents" 
                                   href="#" 
                                   data-bs-toggle="modal" 
                                   data-bs-target="#viewDocumentsModal"
                                   data-course-id="{{ $course->id }}"
                                   data-course-title="{{ $course->title }}">
                                    <i class="fas fa-file me-2"></i>View Documents
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
            <span class="text-muted">Showing {{ $courses->firstItem() ?? 0 }} to {{ $courses->lastItem() ?? 0 }} of {{ $courses->total() ?? 0 }} results</span>
        </div>
        <div class="page-numbers">
            {{ $courses->links() }}
        </div>
    </div>
</div>

<!-- Add Course Modal -->
<div class="modal fade" id="addCourseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Add new course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addCourseForm" action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Course Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teacher</label>
                            <select class="form-select" name="teacher_id" required>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->firstname }} {{ $teacher->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Group</label>
                            <select class="form-select" name="group_id" required>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <hr class="my-4">
                            <h6 class="mb-3">Course Materials</h6>
                        </div>
                        
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
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Course Modal -->
<div class="modal fade" id="editCourseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Edit course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editCourseForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Course Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Teacher</label>
                            <select class="form-select" name="teacher_id" required>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->firstname }} {{ $teacher->lastname }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Group</label>
                            <select class="form-select" name="group_id" required>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCourseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Delete Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this course?</p>
                <form id="deleteCourseForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger px-4">Delete</button>
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
                <h5 class="modal-title">Upload Course Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="uploadDocumentForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Document Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Document Type</label>
                            <select class="form-select" name="file_type" required>
                                <option value="video">Video</option>
                                <option value="image">Image</option>
                                <option value="pdf">PDF</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Document File</label>
                            <input type="file" class="form-control" name="document" required>
                            <small class="text-muted">Max file size: 100MB</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Upload</button>
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
                <h5 class="modal-title">Course Documents</h5>
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

    // Edit Course
    const editButtons = document.querySelectorAll('.edit-course');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const course = JSON.parse(this.dataset.course);
            const form = document.getElementById('editCourseForm');
            form.action = `/courses/${course.id}`;
            form.querySelector('[name="title"]').value = course.title;
            form.querySelector('[name="description"]').value = course.description;
            form.querySelector('[name="teacher_id"]').value = course.teacher_id;
            form.querySelector('[name="group_id"]').value = course.group_id;
            form.querySelector('[name="status"]').value = course.status;
            
            // Format dates for input fields
            const startDate = new Date(course.start_date);
            const endDate = new Date(course.end_date);
            form.querySelector('[name="start_date"]').value = startDate.toISOString().split('T')[0];
            form.querySelector('[name="end_date"]').value = endDate.toISOString().split('T')[0];
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

    @if ($errors->any())
        var addCourseModal = new bootstrap.Modal(document.getElementById('addCourseModal'));
        addCourseModal.show();
    @endif
});
</script>
@endpush
