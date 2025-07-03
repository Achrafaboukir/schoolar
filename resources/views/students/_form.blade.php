<form method="POST" action="{{ $action }}" id="studentForm" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card shadow-sm border-0 mb-0">
        <div class="card-body">
            <h5 class="mb-4"><i class="fas fa-user-graduate me-2 text-primary"></i> {{ __('students.student_information') }}</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('students.first_name') }}</label>
                    <input type="text" name="firstname" class="form-control" value="{{ $student->firstname ?? old('firstname') }}" placeholder="Ex: AHMED" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('students.last_name') }}</label>
                    <input type="text" name="lastname" class="form-control" value="{{ $student->lastname ?? old('lastname') }}" placeholder="Ex: boujdan" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('students.email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ $student->email ?? old('email') }}" placeholder="Ex: AHMED@GMAIL.COM" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('students.number') }}</label>
                    <input type="text" name="number" class="form-control" value="{{ $student->student_number ?? old('number') }}" placeholder="Ex: 066665555" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('students.password') }}</label>
                    <input type="password" name="password" class="form-control" placeholder="{{ isset($student) ? 'Leave blank to keep current password' : 'Enter password' }}" {{ isset($student) ? '' : 'required' }}>
                    @if(isset($student))
                        <small class="text-muted">{{ __('students.password_help') }}</small>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('students.status') }}</label>
                    <select name="status" class="form-select" required>
                        <option value="1" @if(isset($student) && $student->status == 'active') selected @endif>{{ __('students.status_active') }}</option>
                        <option value="0" @if(isset($student) && $student->status == 'inactive') selected @endif>{{ __('students.status_inactive') }}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('students.group') }}</label>
                    <select name="group" class="form-select" required>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" @if(isset($student) && $student->group_id == $group->id) selected @endif>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('students.date_of_birth') }}</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ isset($student) ? $student->date_of_birth?->format('Y-m-d') : old('date_of_birth') }}" required>
                </div>
            </div>
            <hr class="my-4">
            <h5 class="mb-4"><i class="fas fa-file-upload me-2 text-primary"></i> {{ __('students.documents') }}</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('students.baccaloriat') }}</label>
                    <input type="file" name="baccaloriat" class="form-control">
                    @if(isset($student) && $student->baccaloriat)
                        <div class="mt-2">
                            <small class="text-muted">{{ __('students.current_file') }}: {{ basename($student->baccaloriat) }}</small>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('students.picture') }}</label>
                    <input type="file" name="picture" class="form-control">
                    @if(isset($student) && $student->picture)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $student->picture) }}" alt="{{ __('students.student_picture') }}" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 d-flex justify-content-between gap-2 py-3">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>{{ __('students.cancel') }}</button>
            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>{{ $submitLabel }}</button>
        </div>
    </div>
</form> 