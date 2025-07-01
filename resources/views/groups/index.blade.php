@extends('layouts.dashboard')

@section('page-title', __('groups.management'))

@section('content')
<div class="table-section">
    <div class="table-header">
        <div class="d-flex gap-3 align-items-center">
            <div class="search-box flex-grow-1">
                <form method="GET" action="" class="w-100">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="{{ __('groups.search_placeholder') }}" value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" id="add-group-btn" data-bs-toggle="modal" data-bs-target="#groupModal">
                <i class="fas fa-plus me-2"></i>{{ __('groups.add_new') }}
            </button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('groups.id') }}</th>
                <th>{{ __('groups.name') }}</th>
                <th>{{ __('groups.department') }}</th>
                <th>{{ __('groups.year') }}</th>
                <th>{{ __('groups.status') }}</th>
                <th>{{ __('groups.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups ?? [] as $group)
            <tr>
                <td>{{ $group->id }}</td>
                <td>{{ $group->name }}</td>
                <td>{{ $group->department ? $group->department->name : '' }}</td>
                <td>{{ $group->year }}</td>
                <td>
                    <span class="status-badge {{ $group->status }}">{{ strtoupper($group->status) }}</span>
                </td>
                <td class="actions-cell">
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-icon btn-outline-danger delete-group" data-id="{{ $group->id }}" title="{{ __('groups.delete') }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-outline-primary edit-group-btn" data-id="{{ $group->id }}" title="{{ __('groups.edit') }}" data-bs-toggle="modal" data-bs-target="#groupModal">
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
            <span class="text-muted">{{ __('groups.showing') }} {{ $groups->firstItem() ?? 0 }} {{ __('groups.to') }} {{ $groups->lastItem() ?? 0 }} {{ __('groups.of') }} {{ $groups->total() ?? 0 }} {{ __('groups.results') }}</span>
        </div>
        <div class="page-numbers">
            {{ $groups->links() }}
        </div>
    </div>
</div>

<!-- Group CRUD Modal (AJAX content loaded here) -->
<div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="groupModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="group-modal-content">
      <!-- Modal content will be loaded here -->
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteGroupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">{{ __('groups.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('groups.delete_confirm') }}</p>
                <form id="deleteGroupForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('groups.cancel') }}</button>
                        <button type="submit" class="btn btn-danger px-4">{{ __('groups.delete') }}</button>
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
    console.log('Group page script loaded');
    
    // Get the group modal
    const groupModal = document.getElementById('groupModal');
    
    // Add event listeners for modal cleanup
    if (groupModal) {
        // When modal is hidden, clean up any issues
        groupModal.addEventListener('hidden.bs.modal', function() {
            console.log('Group modal hidden, cleaning up...');
            // Call the cleanup function from dashboard.js
            if (window.cleanupModalBackdrop) {
                window.cleanupModalBackdrop();
            }
        });
        
        // When modal is shown, ensure proper state
        groupModal.addEventListener('shown.bs.modal', function() {
            console.log('Group modal shown');
        });
    }
    
    // Add Group - Simplified approach
    document.getElementById('add-group-btn').addEventListener('click', function(e) {
        console.log('Add group button clicked');
        e.preventDefault();
        e.stopPropagation();
        // Clear modal content to prevent old values flashing
        document.getElementById('group-modal-content').innerHTML = '';
        // First, show the modal immediately
        const modal = document.getElementById('groupModal');
        if (modal) {
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        }
        
        // Then load the content
        fetch("{{ route('groups.create-form') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('group-modal-content').innerHTML = html;
                console.log('Modal content loaded');
                
                // Add form submission handler
                setupFormSubmission();
            })
            .catch(error => {
                console.error('Error loading form:', error);
            });
    });

    // Edit Group - Simplified approach
    document.querySelectorAll('.edit-group-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            console.log('Edit group button clicked');
            e.preventDefault();
            e.stopPropagation();
            // Clear modal content to prevent old values flashing
            document.getElementById('group-modal-content').innerHTML = '';
            const id = this.getAttribute('data-id');
            
            // First, show the modal immediately
            const modal = document.getElementById('groupModal');
            if (modal) {
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            }
            
            // Then load the content
            fetch(`/groups/${id}/edit-form`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('group-modal-content').innerHTML = html;
                    console.log('Edit form loaded');
                    
                    // Add form submission handler
                    setupFormSubmission();
                })
                .catch(error => {
                    console.error('Error loading edit form:', error);
                });
        });
    });

    // Delete Group
    const deleteButtons = document.querySelectorAll('.delete-group');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const groupId = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('deleteGroupModal'));
            const form = document.getElementById('deleteGroupForm');
            form.action = `/groups/${groupId}`;
            modal.show();
        });
    });

    // Setup AJAX form submission
    function setupFormSubmission() {
        const form = document.getElementById('groupForm');
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
                        const modalInstance = bootstrap.Modal.getInstance(document.getElementById('groupModal'));
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
        const addBtn = document.getElementById('add-group-btn');
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
        document.querySelectorAll('.edit-group-btn').forEach(btn => {
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
