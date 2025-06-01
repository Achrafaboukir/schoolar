@extends('layouts.dashboard')

@section('page-title', 'User Management')

@section('content')
<div class="content-wrapper">
    <div class="table-section">
        <div class="table-header">
            <div class="d-flex gap-3 align-items-center">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Add filter
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Role</a></li>
                        <li><a class="dropdown-item" href="#">Status</a></li>
                        <li><a class="dropdown-item" href="#">Date</a></li>
                    </ul>
                </div>
                <div class="search-box flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search users by name or email">
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary">Clear all</button>
                <a href="{{ route('users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add new user
                </a>
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ROLE</th>
                    <th>STATUS</th>
                    <th>NAME</th>
                    <th>EMAIL</th>
                    <th>NUMBER</th>
                    <th>DEPARTMENT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td><span class="status-badge {{ strtolower($user->status) }}">{{ $user->status }}</span></td>
                    <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->number }}</td>
                    <td>{{ $user->department ?? '-' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" 
                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('users.edit', $user) }}" 
                               class="btn btn-sm btn-icon btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('users.reset-password', $user) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-icon btn-outline-warning"
                                        onclick="return confirm('Are you sure you want to reset this user\'s password?')">
                                    <i class="fas fa-key"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="table-pagination">
            <div>
                <span class="text-muted">Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() ?? 0 }} results</span>
            </div>
            <div class="page-numbers">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.content-wrapper {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

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

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    text-transform: uppercase;
}

.status-badge.active {
    background-color: #d1fae5;
    color: #059669;
}

.status-badge.inactive {
    background-color: #fee2e2;
    color: #dc2626;
}
</style>
@endpush 