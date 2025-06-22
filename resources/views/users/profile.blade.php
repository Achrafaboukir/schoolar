@extends('layouts.dashboard')

@section('page-title', 'My Profile')

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Profile Information Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>Profile Information</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">First Name</label>
                            <input type="text" name="firstname" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname', $user->firstname) }}" required>
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname', $user->lastname) }}" required>
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Number</label>
                            <input type="text" name="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number', $user->number) }}" required>
                            @error('number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{ old('date_of_birth', $user->date_of_birth?->format('Y-m-d')) }}" required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Photo</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0"><i class="fas fa-lock me-2 text-primary"></i>Change Password</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key me-2"></i>Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Profile Summary Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Profile" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ $user->firstname }}+{{ $user->lastname }}&background=7F56D9&color=fff&size=120" alt="Profile" class="rounded-circle">
                    @endif
                </div>
                <h5 class="mb-1">{{ $user->firstname }} {{ $user->lastname }}</h5>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <p class="text-muted mb-3">{{ $user->role->name ?? 'No Role' }}</p>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h6 class="mb-1">{{ $user->number }}</h6>
                            <small class="text-muted">Number</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h6 class="mb-1">{{ $user->date_of_birth?->format('M d, Y') }}</h6>
                        <small class="text-muted">Birth Date</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 