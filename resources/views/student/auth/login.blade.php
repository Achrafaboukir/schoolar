@php($showNavbar = false)
@extends('layouts.student')
@section('title', __('app.student_login'))
@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="login-container" style="max-width: 900px; width: 100%; background: #fff; border-radius: 20px; box-shadow: 0 25px 50px rgba(0,0,0,0.15); overflow: hidden; display: flex; min-height: 600px;">
        <div class="login-sidebar" style="background: linear-gradient(135deg, #2563eb 0%, #38bdf8 100%); padding: 40px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: #fff; flex: 1;">
            <div class="sidebar-content">
                <div class="student-icon" style="font-size: 80px; margin-bottom: 20px; opacity: 0.9;">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h1 class="sidebar-title" style="font-size: 32px; font-weight: 700; margin-bottom: 15px;">{{ __('app.student_portal') }}</h1>
                <p class="sidebar-subtitle" style="font-size: 16px; opacity: 0.9; line-height: 1.6;">{{ __('app.student_portal_description') }}</p>
            </div>
        </div>
        <div class="login-form-section" style="padding: 50px; flex: 1; display: flex; flex-direction: column; justify-content: center;">
            <div class="form-header" style="text-align: center; margin-bottom: 40px;">
                <h2 class="form-title" style="font-size: 28px; font-weight: 600; color: #1e293b; margin-bottom: 10px;">{{ __('app.welcome_back') }}</h2>
                <p class="form-subtitle" style="color: #64748b; font-size: 16px;">{{ __('app.student_login_subtitle') }}</p>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('student.login.post') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="email" class="form-label">{{ __('app.email') }}</label>
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #64748b; z-index: 2;"></i>
                        <input type="email" class="form-control input-with-icon @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('app.enter_email') }}" style="padding-left: 50px;">
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label">{{ __('app.password') }}</label>
                    <div class="input-group">
                        <i class="fas fa-lock input-icon" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: #64748b; z-index: 2;"></i>
                        <input type="password" class="form-control input-with-icon @error('password') is-invalid @enderror" id="password" name="password" required autocomplete="current-password" placeholder="{{ __('app.enter_password') }}" style="padding-left: 50px;">
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{ __('app.remember_me') }}</label>
                </div>
                <button type="submit" class="btn btn-login w-100" style="background: linear-gradient(135deg, #2563eb 0%, #38bdf8 100%); border: none; border-radius: 12px; padding: 16px; font-size: 16px; font-weight: 600; color: #fff; margin-top: 10px;">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    {{ __('app.student_login') }}
                </button>
            </form>
            <div class="admin-link" style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <a href="{{ route('login') }}" style="color: #64748b; text-decoration: none; font-size: 14px; transition: color 0.3s ease;">
                    <i class="fas fa-user-tie me-1"></i>
                    {{ __('app.admin_login') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 