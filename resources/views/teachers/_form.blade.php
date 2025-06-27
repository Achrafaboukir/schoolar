<form method="POST" action="{{ $action }}" id="teacherForm" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card shadow-sm border-0 mb-0">
        <div class="card-body">
            <h5 class="mb-4"><i class="fas fa-chalkboard-teacher me-2 text-primary"></i> Teacher Information</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-control" value="{{ $teacher->firstname ?? old('firstname') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" class="form-control" value="{{ $teacher->lastname ?? old('lastname') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $teacher->email ?? old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="number" class="form-control" value="{{ $teacher->number ?? old('number') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Group</label>
                    <select name="group_id" class="form-select" required>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" @if(isset($teacher) && $teacher->group_id == $group->id) selected @endif>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ isset($teacher) ? $teacher->date_of_birth?->format('Y-m-d') : old('date_of_birth') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="1" @if(isset($teacher) && $teacher->status == 1) selected @endif>Active</option>
                        <option value="0" @if(isset($teacher) && $teacher->status == 0) selected @endif>Inactive</option>
                    </select>
                </div>
            </div>
            <hr class="my-4">
            <h5 class="mb-4"><i class="fas fa-file-upload me-2 text-primary"></i> Documents</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    @if(isset($teacher) && $teacher->photo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Teacher Photo" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">CV</label>
                    <input type="file" name="cv" class="form-control">
                    @if(isset($teacher) && $teacher->cv)
                        <div class="mt-2">
                            <small class="text-muted">Current file: {{ basename($teacher->cv) }}</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 d-flex justify-content-between gap-2 py-3">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>Cancel</button>
            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>{{ $submitLabel }}</button>
        </div>
    </div>
</form> 