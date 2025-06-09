<form method="POST" action="{{ $action }}" id="userForm" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">First Name</label>
        <input type="text" name="firstname" class="form-control" value="{{ $user->firstname ?? old('firstname') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Last Name</label>
        <input type="text" name="lastname" class="form-control" value="{{ $user->lastname ?? old('lastname') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email ?? old('email') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role_id" class="form-control" required>
            @foreach($roles as $role)
                <option value="{{ $role->id }}" @if(isset($user) && $user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Number</label>
        <input type="text" name="number" class="form-control" value="{{ $user->number ?? old('number') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Department</label>
        <input type="text" name="department" class="form-control" value="{{ $user->department ?? old('department') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-control" required>
            <option value="active" @if(isset($user) && $user->status == 'active') selected @endif>Active</option>
            <option value="inactive" @if(isset($user) && $user->status == 'inactive') selected @endif>Inactive</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Date of Birth</label>
        <input type="date" name="date_of_birth" class="form-control" value="{{ isset($user) ? $user->date_of_birth?->format('Y-m-d') : old('date_of_birth') }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Photo</label>
        <input type="file" name="photo" class="form-control">
        @if(isset($user) && $user->photo)
            <img src="{{ asset('storage/' . $user->photo) }}" alt="User Photo" width="50">
        @endif
    </div>
    <div class="mb-3">
        <label class="form-label">CV</label>
        <input type="file" name="cv" class="form-control">
        @if(isset($user) && $user->cv)
            <a href="{{ asset('storage/' . $user->cv) }}" target="_blank">View CV</a>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</form>
