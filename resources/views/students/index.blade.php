@extends('layouts.dashboard')

@section('page-title', 'Student management')

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
                    <input type="text" class="form-control border-start-0" placeholder="Search for a Student by name or email">
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary">Clear all</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                <i class="fas fa-plus me-2"></i>Add new student
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
                <th>GROUP</th>
                <th>ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students ?? [] as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td><span class="status-badge {{ $student->status }}">{{ strtoupper($student->status) }}</span></td>
                <td>{{ $student->firstname }}</td>
                <td>{{ $student->lastname }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->number }}</td>
                <td>{{ $student->group->name }}</td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-icon btn-outline-danger delete-student" data-id="{{ $student->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-outline-primary edit-student" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editStudentModal"
                                data-student="{{ json_encode($student) }}">
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
            <span class="text-muted">Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() ?? 0 }} results</span>
        </div>
        <div class="page-numbers">
            {{ $students->links() }}
        </div>
    </div>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Add new student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addStudentForm" action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First name</label>
                            <input type="text" class="form-control" name="firstname" placeholder="Ex: AHMED" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last name</label>
                            <input type="text" class="form-control" name="lastname" placeholder="Ex: boujdan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Group</label>
                            <select class="form-select" name="group" required>
                                @foreach($groups ?? [] as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Ex: AHMED@GMAIL.COM" required>
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
                            <label class="form-label">Baccaloriat</label>
                            <input type="file" class="form-control" name="baccaloriat">
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

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Edit student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editStudentForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First name</label>
                            <input type="text" class="form-control" name="firstname" placeholder="Ex: AHMED" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last name</label>
                            <input type="text" class="form-control" name="lastname" placeholder="Ex: boujdan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Group</label>
                            <select class="form-select" name="group" required>
                                <option value="3ISI">3ISI</option>
                                <option value="4ISI">4ISI</option>
                                <option value="5ISI">5ISI</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Ex: AHMED@GMAIL.COM" required>
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
                            <label class="form-label">Baccaloriat</label>
                            <input type="file" class="form-control" name="baccaloriat">
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
<div class="modal fade" id="deleteStudentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Delete Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this student?</p>
                <form id="deleteStudentForm" method="POST">
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
    // Edit Student
    const editButtons = document.querySelectorAll('.edit-student');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const student = JSON.parse(this.dataset.student);
            const form = document.getElementById('editStudentForm');
            form.action = `/students/${student.id}`;
            form.querySelector('[name="firstname"]').value = student.firstname;
            form.querySelector('[name="lastname"]').value = student.lastname;
            form.querySelector('[name="email"]').value = student.email;
            form.querySelector('[name="number"]').value = student.number;
            form.querySelector('[name="group"]').value = student.group;
            form.querySelector('[name="status"]').value = student.status;
            if (student.date_of_birth) {
                form.querySelector('[name="date_of_birth"]').value = student.date_of_birth;
            }
        });
    });

    // Delete Student
    const deleteButtons = document.querySelectorAll('.delete-student');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('deleteStudentModal'));
            const form = document.getElementById('deleteStudentForm');
            form.action = `/students/${studentId}`;
            modal.show();
        });
    });
});
</script>
@endpush