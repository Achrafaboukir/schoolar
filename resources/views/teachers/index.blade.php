@extends('layouts.dashboard')

@section('page-title', __('teachers.management'))

@section('content')
<div class="table-section">
    <div class="table-header">
        <div class="d-flex gap-3 align-items-center">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ __('teachers.add_filter') }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">{{ __('teachers.status') }}</a></li>
                    <li><a class="dropdown-item" href="#">{{ __('teachers.group') }}</a></li>
                    <li><a class="dropdown-item" href="#">Date</a></li>
                </ul>
            </div>
            <div class="search-box flex-grow-1">
                <form method="GET" action="" class="w-100">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="{{ __('teachers.search_placeholder') }}" value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary">{{ __('teachers.clear_all') }}</button>
            <button class="btn btn-primary" id="add-teacher-btn" data-bs-toggle="modal" data-bs-target="#teacherModal">
                <i class="fas fa-plus me-2"></i>{{ __('teachers.add_new') }}
            </button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('teachers.id') }}</th>
                <th>{{ __('teachers.firstname') }}</th>
                <th>{{ __('teachers.lastname') }}</th>
                <th>{{ __('teachers.email') }}</th>
                <th>{{ __('teachers.number') }}</th>
                <th>{{ __('teachers.group') }}</th>
                <th>{{ __('teachers.status') }}</th>
                <th>{{ __('teachers.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
            <tr>
                <td>{{ $teacher->id }}</td>
                <td>{{ $teacher->firstname }}</td>
                <td>{{ $teacher->lastname }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->number }}</td>
                <td>{{ $teacher->group->name ?? '' }}</td>
                <td>
                    <span class="status-badge {{ $teacher->status ? 'active' : 'inactive' }}">{{ $teacher->status ? 'ACTIVE' : 'INACTIVE' }}</span>
                </td>
                <td class="actions-cell">
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-icon btn-outline-danger delete-teacher" data-id="{{ $teacher->id }}" title="{{ __('teachers.delete') }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-outline-primary edit-teacher-btn" data-id="{{ $teacher->id }}" title="{{ __('teachers.edit') }}" data-bs-toggle="modal" data-bs-target="#teacherModal">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="table-pagination">
        <div>
            <span class="text-muted">{{ __('teachers.showing') }} {{ $teachers->firstItem() ?? 0 }} {{ __('teachers.to') }} {{ $teachers->lastItem() ?? 0 }} {{ __('teachers.of') }} {{ $teachers->total() ?? 0 }} {{ __('teachers.results') }}</span>
        </div>
        <div class="page-numbers">
            {{ $teachers->links() }}
        </div>
    </div>
</div>

<!-- Teacher CRUD Modal (AJAX content loaded here) -->
<div class="modal fade" id="teacherModal" tabindex="-1" role="dialog" aria-labelledby="teacherModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="teacher-modal-content">
      <!-- Modal content will be loaded here -->
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">{{ __('teachers.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('teachers.delete_confirm') }}</p>
                <form id="deleteTeacherForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('teachers.cancel') }}</button>
                        <button type="submit" class="btn btn-danger px-4">{{ __('teachers.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.search-box .input-group {
    border-radius: 8px;
    overflow: hidden;
}

.search-box .form-control {
    padding: 12px;
}

.search-box .input-group-text {
    padding: 0 12px;
}

.btn-icon {
    width: 32px;
    height: 32px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    border-radius: 16px;
    border: none;
}

.modal-header {
    padding: 24px 24px 0;
}

.modal-body {
    padding: 24px;
}

.form-label {
    font-weight: 500;
    margin-bottom: 8px;
}

.form-control, .form-select {
    padding: 8px 12px;
    border-radius: 8px;
}

.form-control::placeholder {
    color: #6c757d;
    opacity: 0.8;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Teacher page script loaded');
    
    // Get the teacher modal
    const teacherModal = document.getElementById('teacherModal');
    
    // Add event listeners for modal cleanup
    if (teacherModal) {
        // When modal is hidden, clean up any issues
        teacherModal.addEventListener('hidden.bs.modal', function() {
            console.log('Teacher modal hidden, cleaning up...');
            // Call the cleanup function from dashboard.js
            if (window.cleanupModalBackdrop) {
                window.cleanupModalBackdrop();
            }
        });
        
        // When modal is shown, ensure proper state
        teacherModal.addEventListener('shown.bs.modal', function() {
            console.log('Teacher modal shown');
        });
    }
    
    // Add Teacher - Simplified approach
    document.getElementById('add-teacher-btn').addEventListener('click', function(e) {
        console.log('Add teacher button clicked');
        e.preventDefault();
        e.stopPropagation();
        // Clear modal content to prevent old values flashing
        document.getElementById('teacher-modal-content').innerHTML = '';
        // First, show the modal immediately
        const modal = document.getElementById('teacherModal');
        if (modal) {
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        }
        // Then load the content
        fetch("{{ route('teachers.create-form') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('teacher-modal-content').innerHTML = html;
                console.log('Modal content loaded');
                
                // Add form submission handler
                setupFormSubmission();
            })
            .catch(error => {
                console.error('Error loading form:', error);
            });
    });

    // Edit Teacher - Simplified approach
    document.querySelectorAll('.edit-teacher-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            console.log('Edit teacher button clicked');
            e.preventDefault();
            e.stopPropagation();
            // Clear modal content to prevent old values flashing
            document.getElementById('teacher-modal-content').innerHTML = '';
            const id = this.getAttribute('data-id');
            // First, show the modal immediately
            const modal = document.getElementById('teacherModal');
            if (modal) {
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            }
            // Then load the content
            fetch(`/teachers/${id}/edit-form`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('teacher-modal-content').innerHTML = html;
                    console.log('Edit form loaded');
                    
                    // Add form submission handler
                    setupFormSubmission();
                })
                .catch(error => {
                    console.error('Error loading edit form:', error);
                });
        });
    });

    // Delete Teacher
    const deleteButtons = document.querySelectorAll('.delete-teacher');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const teacherId = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('deleteTeacherModal'));
            const form = document.getElementById('deleteTeacherForm');
            form.action = `/teachers/${teacherId}`;
            modal.show();
        });
    });

    // Setup AJAX form submission
    function setupFormSubmission() {
        const form = document.getElementById('teacherForm');
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
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('teacherModal'));
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                        // Clean up after closing
                        setTimeout(() => {
                            if (window.cleanupModalBackdrop) {
                                window.cleanupModalBackdrop();
                            }
                        }, 100);
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
    
    // Add touch event handlers for mobile
    if (window.innerWidth < 768) {
        console.log('Mobile detected, adding touch handlers');
        
        // Add touch handlers for buttons
        const addBtn = document.getElementById('add-teacher-btn');
        if (addBtn) {
            addBtn.addEventListener('touchstart', function(e) {
                console.log('Add button touch start');
                this.style.transform = 'scale(0.95)';
            });
            
            addBtn.addEventListener('touchend', function(e) {
                console.log('Add button touch end');
                this.style.transform = 'scale(1)';
                // Trigger click
                this.click();
            });
        }
        
        // Add touch handlers for edit buttons
        document.querySelectorAll('.edit-teacher-btn').forEach(btn => {
            btn.addEventListener('touchstart', function(e) {
                console.log('Edit button touch start');
                this.style.transform = 'scale(0.95)';
            });
            
            btn.addEventListener('touchend', function(e) {
                console.log('Edit button touch end');
                this.style.transform = 'scale(1)';
                // Trigger click
                this.click();
            });
        });
    }
});
</script>
@endpush