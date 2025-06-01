@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="display-4 mb-4">Contact Us</h1>
            
            <div class="row">
                <div class="col-md-5 mb-4 mb-md-0">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h2 class="h4 mb-4">Get in Touch</h2>
                            
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-envelope fs-4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="h6 mb-1">Email</h3>
                                    <p class="text-muted mb-0">support@schoolar.com</p>
                                </div>
                            </div>
                            
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-phone fs-4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="h6 mb-1">Phone</h3>
                                    <p class="text-muted mb-0">+1 (555) 123-4567</p>
                                </div>
                            </div>
                            
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-map-marker-alt fs-4 text-primary"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h3 class="h6 mb-1">Address</h3>
                                    <p class="text-muted mb-0">
                                        123 Education Street<br>
                                        Learning City, ED 12345<br>
                                        United States
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h2 class="h4 mb-4">Send us a Message</h2>
                            
                            <form action="{{ url('/contact-us') }}" method="POST">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                                </div>
                                
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Send Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush 