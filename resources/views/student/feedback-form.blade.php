<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app.give_feedback') }} - {{ $course->title }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #4F46E5;
            --primary-hover: #3730A3;
            --secondary-color: #10B981;
            --accent-color: #F59E0B;
            --text-dark: #1F2937;
            --text-light: #6B7280;
            --border-color: #E5E7EB;
            --bg-light: #F9FAFB;
            --white: #FFFFFF;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
        }

        .navbar {
            background: var(--gradient-primary);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--white) !important;
        }

        .nav-link {
            color: var(--white) !important;
            font-weight: 500;
            transition: opacity 0.3s ease;
        }

        .nav-link:hover {
            opacity: 0.8;
        }

        .main-content {
            padding: 30px 0;
        }

        .feedback-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .page-header {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .course-info {
            color: var(--text-light);
            font-size: 16px;
            margin-bottom: 20px;
        }

        .feedback-form {
            background: var(--white);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 14px;
            display: block;
        }

        .form-control {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 15px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: var(--bg-light);
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: var(--white);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #EF4444;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .rating-group {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 10px;
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
            font-size: 24px;
            color: #E5E7EB;
            transition: all 0.3s ease;
        }

        .rating-option:hover .rating-star,
        .rating-option input[type="radio"]:checked ~ .rating-star {
            color: #F59E0B;
        }

        .rating-label {
            font-size: 12px;
            color: var(--text-light);
            margin-top: 5px;
        }

        .form-check {
            margin: 20px 0;
        }

        .form-check-input {
            border: 2px solid var(--border-color);
            border-radius: 6px;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-light);
            font-size: 14px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
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
            color: var(--white);
        }

        .btn-submit {
            background: var(--secondary-color);
            color: var(--white);
        }

        .btn-submit:hover {
            background: #059669;
            color: var(--white);
        }

        .invalid-feedback {
            font-size: 12px;
            color: #EF4444;
            margin-top: 5px;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: var(--white);
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: var(--white);
        }

        .breadcrumb-nav {
            margin-bottom: 20px;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-light);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 16px;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .alert-danger {
            background: #FEF2F2;
            color: #DC2626;
            border-left: 4px solid #EF4444;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px 0;
            }
            
            .page-header {
                padding: 20px;
            }
            
            .feedback-form {
                padding: 25px;
            }
            
            .page-title {
                font-size: 24px;
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
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                <i class="fas fa-graduation-cap me-2"></i>
                {{ config('app.name', 'Akademi') }}
            </a>
            
            <div class="navbar-nav ms-auto">
                <a class="nav-link me-3" href="{{ route('student.dashboard') }}">
                    <i class="fas fa-home me-1"></i>
                    {{ __('app.dashboard') }}
                </a>
                <a class="nav-link me-3" href="{{ route('student.courses') }}">
                    <i class="fas fa-book me-1"></i>
                    {{ __('app.courses') }}
                </a>
                <a class="nav-link me-3" href="{{ route('student.profile') }}">
                    <i class="fas fa-user me-1"></i>
                    {{ __('app.profile') }}
                </a>
                <form method="POST" action="{{ route('student.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-1"></i>
                        {{ __('app.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </nav>

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