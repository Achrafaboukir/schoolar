<form method="POST" action="{{ $action }}" id="groupForm">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card shadow-sm border-0 mb-0">
        <div class="card-body">
            <h5 class="mb-4"><i class="fas fa-users me-2 text-primary"></i> Group Information</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $group->name ?? old('name') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-select" required>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" @if(isset($group) && $group->department_id == $department->id) selected @endif>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Year</label>
                    <input type="number" name="year" class="form-control" value="{{ $group->year ?? old('year') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="1" @if(isset($group) && $group->status == 'active') selected @endif>Active</option>
                        <option value="0" @if(isset($group) && $group->status == 'inactive') selected @endif>Inactive</option>
                        <option value="3" @if(isset($group) && $group->status == 'completed') selected @endif>Completed</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 d-flex justify-content-between gap-2 py-3">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancel</button>
            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>{{ $submitLabel }}</button>
        </div>
    </div>
</form> 