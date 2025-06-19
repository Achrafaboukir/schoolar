<form method="POST" action="{{ $action }}" id="userForm" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <!-- NOTE: To make the modal larger, update the modal-dialog in index.blade.php to use 'modal-lg' -->
    <div class="card shadow-sm border-0 mb-0">
        <div class="card-body">
            <h5 class="mb-4"><i class="fas fa-user me-2 text-primary"></i> User Information</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">First Name</label>
                    <input type="text" name="firstname" class="form-control" value="{{ $user->firstname ?? old('firstname') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="lastname" class="form-control" value="{{ $user->lastname ?? old('lastname') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email ?? old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" @if(!isset($user)) required @endif autocomplete="new-password">
                    @if(isset($user))
                        <small class="text-muted">Leave blank to keep current password.</small>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <select name="role_id" class="form-select" required>
                        @foreach($roles as $role)
                            @if(empty($role->is_teacher) || !$role->is_teacher)
                                <option value="{{ $role->id }}" @if(isset($user) && $user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Number</label>
                    <input type="text" name="number" class="form-control" value="{{ $user->number ?? old('number') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="1" @if(isset($user) && $user->status == 1) selected @endif>Active</option>
                        <option value="0" @if(isset($user) && $user->status == 0) selected @endif>Inactive</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ isset($user) ? $user->date_of_birth?->format('Y-m-d') : old('date_of_birth') }}" required>
                </div>
            </div>
            <hr class="my-4">
            <h5 class="mb-4"><i class="fas fa-file-upload me-2 text-primary"></i> Photo</h5>
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <label class="form-label">Photo</label>
                    <input type="file" name="photo" class="form-control mb-2">
                    @if(isset($user) && $user->photo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
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
