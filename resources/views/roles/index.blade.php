@extends('layouts.dashboard')

@section('page-title', __('roles.management'))

@section('content')
<div class="content-wrapper">
    <div class="table-section">
        <div class="table-header">
            <div class="d-flex gap-3 align-items-center">
                <div class="search-box flex-grow-1">
                    <form method="GET" action="" class="w-100">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="{{ __('roles.search_placeholder') }}" value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary">{{ __('roles.clear_all') }}</button>
                <button class="btn btn-primary" id="openAddRoleModal" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                    <i class="fas fa-plus me-2"></i>{{ __('roles.add_new') }}
                </button>
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('roles.id') }}</th>
                    <th>{{ __('roles.name') }}</th>
                    <th>{{ __('roles.permissions') }}</th>
                    <th>{{ __('roles.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @php
                            $permissions = (array) json_decode($role->permissions, true);
                            $totalPermissions = count($permissions);
                            $displayPermissions = array_slice($permissions, 0, 3);
                        @endphp
                        @foreach($displayPermissions as $perm)
                            <span class="badge bg-light text-dark">{{ $perm }}</span>
                        @endforeach
                        @if($totalPermissions > 3)
                            <span class="badge bg-secondary text-white">+{{ $totalPermissions - 3 }} more</span>
                        @endif
                    </td>
                    <td class="actions-cell">
                        <div class="d-flex gap-2">
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" onclick="return confirm('{{ __('roles.delete_confirm') }}')" title="{{ __('roles.delete') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="#" class="btn btn-sm btn-icon btn-outline-primary edit-role" data-form-url="{{ route('roles.edit-form', $role) }}" title="{{ __('roles.edit') }}" data-bs-toggle="modal" data-bs-target="#editRoleModal">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">{{ __('roles.no_roles_found') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="table-pagination">
            <div>
                <span class="text-muted">{{ __('roles.showing') }} {{ $roles->firstItem() ?? 0 }} {{ __('roles.to') }} {{ $roles->lastItem() ?? 0 }} {{ __('roles.of') }} {{ $roles->total() ?? 0 }} {{ __('roles.results') }}</span>
            </div>
            <div class="page-numbers">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('roles.add_new') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="addRoleModalBody">
                <!-- Form will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('roles.edit') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="editRoleModalBody">
                <!-- Form will be loaded here -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Role page script loaded');
    
    // Get the role modals
    const addRoleModal = document.getElementById('addRoleModal');
    const editRoleModal = document.getElementById('editRoleModal');
    
    // Add event listeners for modal cleanup
    if (addRoleModal) {
        addRoleModal.addEventListener('hidden.bs.modal', function() {
            console.log('Add role modal hidden, cleaning up...');
            if (window.cleanupModalBackdrop) {
                window.cleanupModalBackdrop();
            }
        });
        
        addRoleModal.addEventListener('shown.bs.modal', function() {
            console.log('Add role modal shown');
        });
    }
    
    if (editRoleModal) {
        editRoleModal.addEventListener('hidden.bs.modal', function() {
            console.log('Edit role modal hidden, cleaning up...');
            if (window.cleanupModalBackdrop) {
                window.cleanupModalBackdrop();
            }
        });
        
        editRoleModal.addEventListener('shown.bs.modal', function() {
            console.log('Edit role modal shown');
        });
    }
    
    // Open Add Role Modal and load form - Simplified approach
    document.getElementById('openAddRoleModal').addEventListener('click', function(e) {
        console.log('Add role button clicked');
        e.preventDefault();
        e.stopPropagation();
        
        // First, show the modal immediately
        const modal = document.getElementById('addRoleModal');
        if (modal) {
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        }
        
        // Then load the content
        fetch("{{ route('roles.create-form') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('addRoleModalBody').innerHTML = html;
                console.log('Add role form loaded');
            })
            .catch(error => {
                console.error('Error loading add role form:', error);
            });
    });

    // Open Edit Role Modal and load form - Simplified approach
    document.querySelectorAll('.edit-role').forEach(btn => {
        btn.addEventListener('click', function(e) {
            console.log('Edit role button clicked');
            e.preventDefault();
            e.stopPropagation();
            
            const url = this.getAttribute('data-form-url');
            
            // First, show the modal immediately
            const modal = document.getElementById('editRoleModal');
            if (modal) {
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            }
            
            // Then load the content
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('editRoleModalBody').innerHTML = html;
                    console.log('Edit role form loaded');
                })
                .catch(error => {
                    console.error('Error loading edit role form:', error);
                });
        });
    });
    
    // Add touch event handlers for mobile
    if (window.innerWidth < 768) {
        console.log('Mobile detected, adding touch handlers');
        
        // Add touch handlers for buttons
        const addBtn = document.getElementById('openAddRoleModal');
        if (addBtn) {
            addBtn.addEventListener('touchstart', function(e) {
                console.log('Add role button touch start');
                this.style.transform = 'scale(0.95)';
            });
            
            addBtn.addEventListener('touchend', function(e) {
                console.log('Add role button touch end');
                this.style.transform = 'scale(1)';
                // Trigger click
                this.click();
            });
        }
        
        // Add touch handlers for edit buttons
        document.querySelectorAll('.edit-role').forEach(btn => {
            btn.addEventListener('touchstart', function(e) {
                console.log('Edit role button touch start');
                this.style.transform = 'scale(0.95)';
            });
            
            btn.addEventListener('touchend', function(e) {
                console.log('Edit role button touch end');
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
