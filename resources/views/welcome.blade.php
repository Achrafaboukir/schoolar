@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row align-items-center py-5">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-4">Welcome to {{ config('app.name', 'Schoolar') }}</h1>
            <p class="lead text-muted mb-4">Your comprehensive school management solution for students, teachers, and administrators.</p>
            @guest
                <div class="d-grid gap-2 d-md-flex">
                    <a href="{{ url('/login') }}" class="btn btn-primary btn-lg px-4 me-md-2">Get Started</a>
                    <a href="{{ url('/register') }}" class="btn btn-outline-secondary btn-lg px-4">Sign Up</a>
                </div>
            @else
                <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg px-4">Go to Dashboard</a>
            @endguest
        </div>
        <div class="col-lg-6">
            <img src="{{ asset('images/hero-illustration.svg') }}" alt="Education Illustration" class="img-fluid">
        </div>
    </div>

    <!-- Features Section -->
    <div class="row py-5">
        <div class="col-12 text-center mb-5">
            <h2 class="h1 mb-4">Why Choose Us?</h2>
            <p class="lead text-muted">Everything you need to manage your educational journey</p>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-book-reader fa-3x text-primary"></i>
                    </div>
                    <h3 class="h4 mb-3">Course Management</h3>
                    <p class="text-muted mb-0">Easily manage your courses, assignments, and learning materials in one place.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-chart-line fa-3x text-primary"></i>
                    </div>
                    <h3 class="h4 mb-3">Progress Tracking</h3>
                    <p class="text-muted mb-0">Monitor your academic progress with detailed analytics and insights.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-users fa-3x text-primary"></i>
                    </div>
                    <h3 class="h4 mb-3">Collaboration</h3>
                    <p class="text-muted mb-0">Connect with teachers and fellow students for enhanced learning experience.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="row py-5">
        <div class="col-12">
            <div class="bg-primary text-white rounded-3 p-5 text-center">
                <h2 class="mb-4">Ready to Get Started?</h2>
                <p class="lead mb-4">Join thousands of students and educators who are already using {{ config('app.name', 'Schoolar') }}.</p>
                @guest
                    <a href="{{ url('/register') }}" class="btn btn-light btn-lg px-4">Create Your Account</a>
                @else
                    <a href="{{ url('/dashboard') }}" class="btn btn-light btn-lg px-4">Go to Dashboard</a>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .feature-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: rgba(13, 110, 253, 0.1);
    }
</style>
@endpush
