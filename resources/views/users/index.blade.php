@extends('layouts.dashboard')

@section('page-title', 'User management')
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
                    <li><a class="dropdown-item" href="#">Group</a></li>
                    <li><a class="dropdown-item" href="#">Date</a></li>
                </ul>
            </div>
            <div class="search-box flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search for a user by name or email">
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary">Clear all</button>
            <button class="btn btn-primary" id="add-user-btn">
                <i class="fas fa-plus me-2"></i>Add new user
            </button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->name ?? '' }}</td>
                <td>{{ $user->status }}</td>
                <td>
                    <button class="btn btn-primary btn-sm edit-user-btn" data-id="{{ $user->id }}" title="Edit User"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger btn-sm delete-user-btn" data-id="{{ $user->id }}" title="Delete User"><i class="fas fa-trash"></i></button>
                    <button class="btn btn-warning btn-sm reset-password-user-btn" data-id="{{ $user->id }}" title="Reset Password"><i class="fas fa-key"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>

<!-- User CRUD Modal (AJAX content loaded here) -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="user-modal-content">
      <!-- Modal content will be loaded here -->
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add User
    document.getElementById('add-user-btn').addEventListener('click', function() {
        fetch("{{ route('users.create-form') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('user-modal-content').innerHTML = html;
                new bootstrap.Modal(document.getElementById('userModal')).show();
            });
    });

    // Edit User
    document.querySelectorAll('.edit-user-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            fetch(`/users/${id}/edit-form`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('user-modal-content').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('userModal')).show();
                });
        });
    });

});
</script>
@endpush
@endsection
