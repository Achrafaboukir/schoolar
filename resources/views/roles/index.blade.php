@extends('layouts.dashboard')

@section('page-title', 'Role Management')

@section('content')
<div class="content-wrapper">
    <div class="table-section">
        <div class="table-header">
            <div class="d-flex gap-3 align-items-center">
                <div class="search-box flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search roles by name">
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary">Clear all</button>
                <button class="btn btn-primary" id="openAddRoleModal">
                    <i class="fas fa-plus me-2"></i>Add new role
                </button>
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>PERMISSIONS</th>
                    <th>ACTIONS</th>
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
                    <td>
                        <div class="d-flex gap-2">
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" onclick="return confirm('Are you sure you want to delete this role?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="#" class="btn btn-sm btn-icon btn-outline-primary edit-role" data-form-url="{{ route('roles.edit-form', $role) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">No roles found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="table-pagination">
            <div>
                <span class="text-muted">Showing {{ $roles->firstItem() ?? 0 }} to {{ $roles->lastItem() ?? 0 }} of {{ $roles->total() ?? 0 }} results</span>
            </div>
            <div class="page-numbers">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg"><!-- modal-lg for large modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="addRoleModalBody">
                <!-- Form will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg"><!-- modal-lg for large modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
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
    // Open Add Role Modal and load form
    document.getElementById('openAddRoleModal').addEventListener('click', function() {
        fetch("{{ route('roles.create-form') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('addRoleModalBody').innerHTML = html;
                new bootstrap.Modal(document.getElementById('addRoleModal')).show();
            });
    });

    // Open Edit Role Modal and load form
    document.querySelectorAll('.edit-role').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('data-form-url');
            fetch(url)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('editRoleModalBody').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('editRoleModal')).show();
                });
        });
    });
});
</script>
@endpush
@endsection
