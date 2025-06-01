@extends('layouts.dashboard')

@section('page-title', 'Teacher Management')

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
                        <li><a class="dropdown-item" href="#">Status</a></li>
                        <li><a class="dropdown-item" href="#">Department</a></li>
                        <li><a class="dropdown-item" href="#">Date</a></li>
                    </ul>
                </div>
                <div class="search-box flex-grow-1">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Search for a Teacher by name or email">
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary">Clear all</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                    <i class="fas fa-plus me-2"></i>Add new teacher
                </button>
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>STATUS</th>
                    <th>FIRSTNAME</th>
                    <th>LASTNAME</th>
                    <th>EMAIL</th>
                    <th>NUMBER</th>
                    <th>DEPARTMENT</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers ?? [] as $teacher)
                <tr>
                    <td>{{ $teacher->id }}</td>
                    <td><span class="status-badge {{ strtolower($teacher->status) }}">{{ $teacher->status }}</span></td>
                    <td>{{ $teacher->firstname }}</td>
                    <td>{{ $teacher->lastname }}</td>
                    <td>{{ $teacher->email }}</td>
                    <td>{{ $teacher->number }}</td>
                    <td>{{ $teacher->department }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-icon btn-outline-danger delete-teacher" data-id="{{ $teacher->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-outline-primary edit-teacher" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editTeacherModal"
                                    data-teacher="{{ json_encode($teacher) }}">
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
                <span class="text-muted">Showing {{ $teachers->firstItem() ?? 0 }} to {{ $teachers->lastItem() ?? 0 }} of {{ $teachers->total() ?? 0 }} results</span>
            </div>
            <div class="page-numbers">
                {{ $teachers->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Teacher Modal -->
<div class="modal fade" id="addTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Add new teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First name</label>
                            <input type="text" class="form-control" name="firstname" placeholder="Ex: John" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last name</label>
                            <input type="text" class="form-control" name="lastname" placeholder="Ex: Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department" required>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Mathematics">Mathematics</option>
                                <option value="Physics">Physics</option>
                                <option value="Chemistry">Chemistry</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Ex: john.doe@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Number</label>
                            <input type="text" class="form-control" name="number" placeholder="Ex: 066665555" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of birth</label>
                            <input type="date" class="form-control" name="date_of_birth" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CV</label>
                            <input type="file" class="form-control" name="cv">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Picture</label>
                            <input type="file" class="form-control" name="picture">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Teacher Modal -->
<div class="modal fade" id="editTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Edit teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editTeacherForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First name</label>
                            <input type="text" class="form-control" name="firstname" placeholder="Ex: John" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last name</label>
                            <input type="text" class="form-control" name="lastname" placeholder="Ex: Doe" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-select" name="department" required>
                                <option value="Computer Science">Computer Science</option>
                                <option value="Mathematics">Mathematics</option>
                                <option value="Physics">Physics</option>
                                <option value="Chemistry">Chemistry</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Ex: john.doe@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Number</label>
                            <input type="text" class="form-control" name="number" placeholder="Ex: 066665555" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of birth</label>
                            <input type="date" class="form-control" name="date_of_birth">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CV</label>
                            <input type="file" class="form-control" name="cv">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Picture</label>
                            <input type="file" class="form-control" name="picture">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Validate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTeacherModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Delete Teacher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this teacher?</p>
                <form id="deleteTeacherForm" method="POST">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit Teacher
    const editButtons = document.querySelectorAll('.edit-teacher');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const teacher = JSON.parse(this.dataset.teacher);
            const form = document.getElementById('editTeacherForm');
            form.action = `/teachers/${teacher.id}`;
            form.querySelector('[name="firstname"]').value = teacher.firstname;
            form.querySelector('[name="lastname"]').value = teacher.lastname;
            form.querySelector('[name="email"]').value = teacher.email;
            form.querySelector('[name="number"]').value = teacher.number;
            form.querySelector('[name="department"]').value = teacher.department;
            form.querySelector('[name="status"]').value = teacher.status.toLowerCase();
            if (teacher.date_of_birth) {
                form.querySelector('[name="date_of_birth"]').value = teacher.date_of_birth;
            }
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
});
</script>
@endpush 