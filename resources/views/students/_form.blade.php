<form method="POST" action="{{ $action }}" id="studentForm" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card shadow-sm border-0 mb-0">
        <div class="card-body">
            <h5 class="mb-4"><i class="fas fa-user-graduate me-2 text-primary"></i> Student Information</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-control" value="{{ $student->firstname ?? old('firstname') }}" placeholder="Ex: AHMED" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" class="form-control" value="{{ $student->lastname ?? old('lastname') }}" placeholder="Ex: boujdan" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $student->email ?? old('email') }}" placeholder="Ex: AHMED@GMAIL.COM" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Number</label>
                    <input type="text" name="number" class="form-control" value="{{ $student->number ?? old('number') }}" placeholder="Ex: 066665555" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="1" @if(isset($student) && $student->status == 'active') selected @endif>Active</option>
                        <option value="0" @if(isset($student) && $student->status == 'inactive') selected @endif>Inactive</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Group</label>
                    <select name="group" class="form-select" required>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" @if(isset($student) && $student->group_id == $group->id) selected @endif>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ isset($student) ? $student->date_of_birth?->format('Y-m-d') : old('date_of_birth') }}" required>
                </div>
            </div>
            <hr class="my-4">
            <h5 class="mb-4"><i class="fas fa-file-upload me-2 text-primary"></i> Documents</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Baccaloriat</label>
                    <input type="file" name="baccaloriat" class="form-control">
                    @if(isset($student) && $student->baccaloriat)
                        <div class="mt-2">
                            <small class="text-muted">Current file: {{ basename($student->baccaloriat) }}</small>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Picture</label>
                    <input type="file" name="picture" class="form-control">
                    @if(isset($student) && $student->picture)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $student->picture) }}" alt="Student Picture" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
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