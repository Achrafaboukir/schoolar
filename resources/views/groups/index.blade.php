@extends('layouts.dashboard')

@section('page-title', 'Group Management')

@section('content')
<div class="table-section">
    <div class="table-header">
        <div class="d-flex gap-3 align-items-center">
            <div class="search-box flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Search for a Group by name">
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addGroupModal">
                <i class="fas fa-plus me-2"></i>Add new group
            </button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>DEPARTMENT</th>
                <th>YEAR</th>
                <th>STATUS</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups ?? [] as $group)
            <tr>
                <td>{{ $group->id }}</td>
                <td>{{ $group->name }}</td>
                <td>{{ $group->department }}</td>
                <td>{{ $group->year }}</td>
                <td><span class="status-badge {{ $group->status }}">{{ strtoupper($group->status) }}</span></td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-icon btn-outline-danger delete-group" data-id="{{ $group->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-outline-primary edit-group" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editGroupModal"
                                data-group="{{ json_encode($group) }}">
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
            <span class="text-muted">Showing {{ $groups->firstItem() ?? 0 }} to {{ $groups->lastItem() ?? 0 }} of {{ $groups->total() ?? 0 }} results</span>
        </div>
        <div class="page-numbers">
            {{ $groups->links() }}
        </div>
    </div>
</div>

<!-- Add Group Modal -->
<div class="modal fade" id="addGroupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Add new group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addGroupForm" action="{{ route('groups.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department_id" required>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Year</label>
                            <input type="number" class="form-control" name="year" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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

<!-- Edit Group Modal -->
<div class="modal fade" id="editGroupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Edit group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editGroupForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department_id" required>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Year</label>
                            <input type="number" class="form-control" name="year" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="completed">Completed</option>
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
<div class="modal fade" id="deleteGroupModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Delete Group</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this group?</p>
                <form id="deleteGroupForm" method="POST">
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
@endsection
