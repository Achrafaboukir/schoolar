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
                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add new role
                </a>
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
                        @foreach((array) json_decode($role->permissions, true) as $perm)
                            <span class="badge bg-light text-dark">{{ $perm }}</span>
                        @endforeach
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
                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-icon btn-outline-primary">
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
@endsection
