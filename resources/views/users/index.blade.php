@extends('layouts.dashboard')

@section('page-title', __('users.management'))
@section('content')
<div class="table-section">
    <div class="table-header">
        <div class="d-flex gap-3 align-items-center">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ __('users.add_filter') }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">{{ __('users.status') }}</a></li>
                    <li><a class="dropdown-item" href="#">{{ __('users.group') }}</a></li>
                    <li><a class="dropdown-item" href="#">Date</a></li>
                </ul>
            </div>
            <div class="search-box flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="{{ __('users.search_placeholder') }}">
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary">{{ __('users.clear_all') }}</button>
            <button class="btn btn-primary" id="add-user-btn" data-bs-toggle="modal" data-bs-target="#userModal">
                <i class="fas fa-plus me-2"></i>{{ __('users.add_new') }}
            </button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('users.name') }}</th>
                <th>{{ __('users.email') }}</th>
                <th>{{ __('users.role') }}</th>
                <th>{{ __('users.status') }}</th>
                <th>{{ __('users.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->name ?? '' }}</td>
                <td>
                    <span class="status-badge {{ $user->status ? 'active' : 'inactive' }}">{{ $user->status ? 'ACTIVE' : 'INACTIVE' }}</span>
                </td>
                <td class="actions-cell">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary btn-sm edit-user-btn" data-id="{{ $user->id }}" title="{{ __('users.edit') }}" data-bs-toggle="modal" data-bs-target="#userModal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm delete-user-btn" data-id="{{ $user->id }}" title="{{ __('users.delete') }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-warning btn-sm reset-password-user-btn" data-id="{{ $user->id }}" title="{{ __('users.reset_password') }}">
                            <i class="fas fa-key"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="table-pagination">
        <div>
            <span class="text-muted">{{ __('users.showing') }} {{ $users->firstItem() ?? 0 }} {{ __('users.to') }} {{ $users->lastItem() ?? 0 }} {{ __('users.of') }} {{ $users->total() ?? 0 }} {{ __('users.results') }}</span>
        </div>
        <div class="page-numbers">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- User CRUD Modal (AJAX content loaded here) -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="user-modal-content">
      <!-- Modal content will be loaded here -->
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('User page script loaded');
    
    // Get the user modal
    const userModal = document.getElementById('userModal');
    
    // Add event listeners for modal cleanup
    if (userModal) {
        // When modal is hidden, clean up any issues
        userModal.addEventListener('hidden.bs.modal', function() {
            console.log('User modal hidden, cleaning up...');
            // Call the cleanup function from dashboard.js
            if (window.cleanupModalBackdrop) {
                window.cleanupModalBackdrop();
            }
        });
        
        // When modal is shown, ensure proper state
        userModal.addEventListener('shown.bs.modal', function() {
            console.log('User modal shown');
        });
    }
    
    // Add User - Simplified approach
    document.getElementById('add-user-btn').addEventListener('click', function(e) {
        console.log('Add user button clicked');
        e.preventDefault();
        e.stopPropagation();
        
        // First, show the modal immediately
        const modal = document.getElementById('userModal');
        if (modal) {
            // Clear modal content to prevent old values flashing
            document.getElementById('user-modal-content').innerHTML = '';
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        }
        
        // Then load the content
        fetch("{{ route('users.create-form') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('user-modal-content').innerHTML = html;
                console.log('Modal content loaded');
            })
            .catch(error => {
                console.error('Error loading form:', error);
            });
    });

    // Edit User - Simplified approach
    document.querySelectorAll('.edit-user-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            console.log('Edit user button clicked');
            e.preventDefault();
            e.stopPropagation();
            
            const id = this.getAttribute('data-id');
            
            // First, show the modal immediately
            const modal = document.getElementById('userModal');
            if (modal) {
                // Clear modal content to prevent old values flashing
                document.getElementById('user-modal-content').innerHTML = '';
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            }
            
            // Then load the content
            fetch(`/users/${id}/edit-form`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('user-modal-content').innerHTML = html;
                    console.log('Edit form loaded');
                })
                .catch(error => {
                    console.error('Error loading edit form:', error);
                });
        });
    });
    
    // Add touch event handlers for mobile
    if (window.innerWidth < 768) {
        console.log('Mobile detected, adding touch handlers');
        
        // Add touch handlers for buttons
        const addBtn = document.getElementById('add-user-btn');
        if (addBtn) {
            addBtn.addEventListener('touchstart', function(e) {
                console.log('Add user button touch start');
                this.style.transform = 'scale(0.95)';
            });
            
            addBtn.addEventListener('touchend', function(e) {
                console.log('Add user button touch end');
                this.style.transform = 'scale(1)';
                // Trigger click
                this.click();
            });
        }
        
        // Add touch handlers for edit buttons
        document.querySelectorAll('.edit-user-btn').forEach(btn => {
            btn.addEventListener('touchstart', function(e) {
                console.log('Edit user button touch start');
                this.style.transform = 'scale(0.95)';
            });
            
            btn.addEventListener('touchend', function(e) {
                console.log('Edit user button touch end');
                this.style.transform = 'scale(1)';
                // Trigger click
                this.click();
            });
        });
    }
});
</script>
@endpush
@endsection
