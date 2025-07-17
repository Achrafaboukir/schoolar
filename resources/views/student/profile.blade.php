@extends('layouts.student')
@section('title', __('app.profile') . ' - ' . config('app.name', 'Akademi'))
@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app.profile') }} - {{ config('app.name', 'Akademi') }}</title>
    
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
        .navbar{
            padding:1em;
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


        .main-content {
            padding: 2rem 0;
        }

        .profile-header {
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1rem;
            border: 3px solid var(--primary-color);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .profile-name {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .profile-email {
            color: var(--text-light);
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .profile-stats {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .stat-label {
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .profile-info {
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            background: var(--bg-light);
            border-radius: 8px;
        }

        .info-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .info-content h4 {
            font-size: 0.875rem;
            color: var(--text-light);
            margin-bottom: 0.25rem;
        }

        .info-content p {
            font-size: 1rem;
            color: var(--text-dark);
            font-weight: 500;
            margin: 0;
        }

        .feedback-section {
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .feedback-card {
            background: var(--bg-light);
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            border-left: 3px solid var(--primary-color);
        }

        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .feedback-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .feedback-course {
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .feedback-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .rating-stars {
            color: var(--accent-color);
        }

        .feedback-date {
            color: var(--text-light);
            font-size: 0.75rem;
        }

        .feedback-content {
            color: var(--text-dark);
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .empty-feedback {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-light);
        }

        .empty-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .breadcrumb-nav {
            margin-bottom: 1.25rem;
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.875rem;
        }

        .breadcrumb-item.active {
            color: var(--text-light);
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem 0;
            }
            
            .profile-header {
                padding: 1rem;
            }
            
            .profile-info {
                padding: 1rem;
            }
            
            .feedback-section {
                padding: 1rem;
            }
            
            .profile-name {
                font-size: 1.5rem;
            }
            
            .profile-stats {
                gap: 1rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
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
                    <li class="breadcrumb-item active">{{ __('app.profile') }}</li>
                </ol>
            </nav>

            <!-- Profile Header -->
            <div class="profile-header">
                @if($student->photo)
                    <img src="{{ asset($student->photo) }}" alt="{{ $student->full_name }}" class="profile-avatar">
                @else
                    <div class="profile-avatar" style="background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
                
                <h1 class="profile-name">{{ $student->full_name }}</h1>
                <p class="profile-email">{{ $student->email }}</p>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-number">{{ $student->group ? $student->group->courses->count() : 0 }}</div>
                        <div class="stat-label">{{ __('app.enrolled_courses') }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $student->feedback->count() }}</div>
                        <div class="stat-label">{{ __('app.submitted_feedback') }}</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $student->group ? $student->group->name : __('app.no_group') }}</div>
                        <div class="stat-label">{{ __('app.group') }}</div>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="profile-info">
                <h2 class="section-title">
                    <i class="fas fa-user-circle"></i>
                    {{ __('app.personal_information') }}
                </h2>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </div>
                        <div class="info-content">
                            <h4>{{ __('app.student_number') }}</h4>
                            <p>{{ $student->student_number }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="info-content">
                            <h4>{{ __('app.date_of_birth') }}</h4>
                            <p>{{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : __('app.not_specified') }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="info-content">
                            <h4>{{ __('app.group') }}</h4>
                            <p>{{ $student->group ? $student->group->name : __('app.no_group') }}</p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="info-content">
                            <h4>{{ __('app.status') }}</h4>
                            <p>{{ $student->status ? __('app.active') : __('app.inactive') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback History -->
            <div class="feedback-section">
                <h2 class="section-title">
                    <i class="fas fa-comments"></i>
                    {{ __('app.feedback_history') }}
                </h2>
                
                @if($student->feedback->count() > 0)
                    @foreach($student->feedback as $feedback)
                        <div class="feedback-card">
                            <div class="feedback-header">
                                <div>
                                    <h3 class="feedback-title">{{ $feedback->title }}</h3>
                                    <p class="feedback-course">
                                        <i class="fas fa-book me-1"></i>
                                        {{ $feedback->course->title }}
                                    </p>
                                </div>
                                <div class="feedback-rating">
                                    <div class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $feedback->rating ? '' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="feedback-date">{{ $feedback->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                            <p class="feedback-content">{{ $feedback->content }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="empty-feedback">
                        <div class="empty-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3>{{ __('app.no_feedback_yet') }}</h3>
                        <p>{{ __('app.no_feedback_description') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection