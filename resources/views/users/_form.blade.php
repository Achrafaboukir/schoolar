<form method="POST" action="{{ $action }}" id="userForm" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <!-- NOTE: To make the modal larger, update the modal-dialog in index.blade.php to use 'modal-lg' -->
    <div class="card shadow-sm border-0 mb-0">
        <div class="card-body">
            <h5 class="mb-4"><i class="fas fa-user me-2 text-primary"></i> {{ __('users.user_information') }}</h5>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">{{ __('users.first_name') }}</label>
                    <input type="text" name="firstname" class="form-control" value="{{ $user->firstname ?? old('firstname') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('users.last_name') }}</label>
                    <input type="text" name="lastname" class="form-control" value="{{ $user->lastname ?? old('lastname') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('users.email') }}</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email ?? old('email') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('users.password') }}</label>
                    <input type="password" name="password" class="form-control" @if(!isset($user)) required @endif autocomplete="new-password">
                    @if(isset($user))
                        <small class="text-muted">{{ __('users.leave_blank_password') }}</small>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('users.role') }}</label>
                    <select name="role_id" class="form-select" required>
                        @foreach($roles as $role)
                            @if(empty($role->is_teacher) || !$role->is_teacher)
                                <option value="{{ $role->id }}" @if(isset($user) && $user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('users.number') }}</label>
                    <input type="text" name="number" class="form-control" value="{{ $user->number ?? old('number') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('users.status') }}</label>
                    <select name="status" class="form-select" required>
                        <option value="1" @if(isset($user) && $user->status == 1) selected @endif>{{ __('users.status_active') }}</option>
                        <option value="0" @if(isset($user) && $user->status == 0) selected @endif>{{ __('users.status_inactive') }}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('users.date_of_birth') }}</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ isset($user) ? $user->date_of_birth?->format('Y-m-d') : old('date_of_birth') }}" required>
                </div>
            </div>
            <hr class="my-4">
            <h5 class="mb-4"><i class="fas fa-file-upload me-2 text-primary"></i> {{ __('users.photo') }}</h5>
            <div class="row g-3 align-items-center">
                <div class="col-md-6">
                    <label class="form-label">{{ __('users.photo') }}</label>
                    <input type="file" name="photo" class="form-control mb-2">
                    @if(isset($user) && $user->photo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ __('users.user_photo') }}" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 d-flex justify-content-between gap-2 py-3">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>{{ __('users.cancel') }}</button>
            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>{{ $submitLabel }}</button>
        </div>
    </div>
</form>
