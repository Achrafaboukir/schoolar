@extends('layouts.student')
@section('title', __('app.give_feedback') . ' - ' . $course->title)
@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app.give_feedback') }} - {{ $course->title }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #1E3A8A; /* Deep Navy */
            --primary-hover: #1E40AF; /* Slightly lighter navy for hover */
            --secondary-color: #2DD4BF; /* Soft Teal */
            --accent-color: #F472B6; /* Warm Coral */
            --text-dark: #111827; /* Charcoal */
            --text-light: #6B7280; /* Slate Gray */
            --border-color: #E2E8F0; /* Light Slate */
            --bg-light: #F9FAFB; /* Off-White */
            --white: #FFFFFF;
            --gradient-primary: linear-gradient(135deg, #1E3A8A 0%, #2DD4BF 100%);
            --gradient-secondary: linear-gradient(135deg, #F472B6 0%, #F9A8D4 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.5;
        }

        .navbar{
            padding:1em;
        }
        
        .main-content {
            padding: 2rem 0;
        }

        .feedback-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .page-header {
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .course-info {
            color: var(--text-light);
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .feedback-form {
            background: var(--white);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #DC2626;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .rating-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            margin-top: 0.5rem;
        }

        .rating-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .rating-option input[type="radio"] {
            display: none;
        }

        .rating-star {
            font-size: 1.25rem;
            color: var(--border-color);
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .rating-option:hover .rating-star,
        .rating-option input[type="radio"]:checked ~ .rating-star {
            color: var(--accent-color);
            transform: scale(1.1);
        }

        .rating-label {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-top: 0.25rem;
        }

        .form-check {
            margin: 1rem 0;
        }

        .form-check-input {
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .form-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: inline-flex;
            align-items: center;
            border: none;
            cursor: pointer;
        }

        .btn-back {
            background: var(--text-light);
            color: var(--white);
        }

        .btn-back:hover {
            background: var(--text-dark);
            transform: translateY(-2px);
        }

        .btn-submit {
            background: var(--secondary-color);
            color: var(--white);
        }

        .btn-submit:hover {
            background: #14B8A6;
            transform: translateY(-2px);
        }

        .invalid-feedback {
            font-size: 0.75rem;
            color: #DC2626;
            margin-top: 0.25rem;
        }

        .breadcrumb-nav {
            margin-bottom: 1.25rem;
            max-width:800px;
            margin:0 auto;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
        }

        .breadcrumb-item.active {
            color: var(--text-light);
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .alert-danger {
            background: #FEF2F2;
            color: #DC2626;
            border-left: 3px solid #DC2626;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem 0;
            }
            
            .page-header {
                padding: 1rem;
            }
            
            .feedback-form {
                padding: 1.25rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
            
            .btn {
                justify-content: center;
            }
        }
    </style>
</head>
<body>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Breadcrumb -->
            <nav class="breadcrumb-nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('student.dashboard') }}">
                            <i class="fas fa-home me-1"></i>
                            {{ __('app.dashboard') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('student.courses') }}">{{ __('app.my_courses') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('student.course.details', $course->id) }}">{{ $course->title }}</a>
                    </li>
                    <li class="breadcrumb-item active">{{ __('app.give_feedback') }}</li>
                </ol>
            </nav>

            <div class="feedback-container">
                <!-- Page Header -->
                <div class="page-header">
                    <h1 class="page-title">{{ __('app.give_feedback') }}</h1>
                    <p class="course-info">
                        <i class="fas fa-book me-1"></i>
                        {{ $course->title }}
                    </p>
                </div>

                <!-- Feedback Form -->
                <div class="feedback-form">
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

                    <form method="POST" action="{{ route('student.course.feedback.submit', $course->id) }}">
                        @csrf
                        
                        <div class="form-group">
                            <label for="title" class="form-label">{{ __('app.feedback_title') }} *</label>
                            <input type="text"
                                   class="form-control @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   required
                                   placeholder="{{ __('app.enter_feedback_title') }}">
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content" class="form-label">{{ __('app.feedback_content') }} *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content"
                                      name="content"
                                      required
                                      placeholder="{{ __('app.enter_feedback_content') }}">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">{{ __('app.course_rating') }} *</label>
                            <div class="rating-group">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="rating-option">
                                        <input type="radio" name="rating" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                                        <div class="rating-star">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-label">{{ $i }}</span>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_anonymous" name="is_anonymous" {{ old('is_anonymous') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_anonymous">
                                {{ __('app.submit_anonymously') }}
                            </label>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('student.course.details', $course->id) }}" class="btn btn-back">
                                <i class="fas fa-arrow-left me-1"></i>
                                {{ __('app.back_to_course') }}
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-paper-plane me-1"></i>
                                {{ __('app.submit_feedback') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection