@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="display-4 mb-4">About {{ config('app.name', 'Schoolar') }}</h1>
            
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="h4 mb-3">Our Mission</h2>
                    <p class="lead mb-4">
                        To provide a comprehensive and user-friendly platform that enhances the educational experience for both students and teachers.
                    </p>
                    
                    <h2 class="h4 mb-3">What We Offer</h2>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-graduation-cap fs-4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="h5 mb-2">Quality Education</h3>
                                    <p class="text-muted">Access to high-quality courses and learning materials.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-users fs-4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="h5 mb-2">Community</h3>
                                    <p class="text-muted">Connect with fellow students and experienced teachers.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-chart-line fs-4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="h5 mb-2">Progress Tracking</h3>
                                    <p class="text-muted">Monitor your academic progress with detailed analytics.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-mobile-alt fs-4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="h5 mb-2">Accessibility</h3>
                                    <p class="text-muted">Access your courses anytime, anywhere.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ url('/register') }}" class="btn btn-primary btn-lg">Join Us Today</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush 