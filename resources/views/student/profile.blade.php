<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app.profile') }} - {{ config('app.name', 'Akademi') }}</title>
    
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

        .profile-header {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            border: 4px solid var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-name {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .profile-email {
            color: var(--text-light);
            font-size: 16px;
            margin-bottom: 20px;
        }

        .profile-stats {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .stat-label {
            color: var(--text-light);
            font-size: 14px;
        }

        .profile-info {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 10px;
            color: var(--primary-color);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: var(--bg-light);
            border-radius: 10px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--primary-color);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .info-content h4 {
            font-size: 14px;
            color: var(--text-light);
            margin-bottom: 5px;
        }

        .info-content p {
            font-size: 16px;
            color: var(--text-dark);
            font-weight: 500;
            margin: 0;
        }

        .feedback-section {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .feedback-card {
            background: var(--bg-light);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid var(--primary-color);
        }

        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .feedback-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .feedback-course {
            color: var(--text-light);
            font-size: 14px;
        }

        .feedback-rating {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .rating-stars {
            color: #F59E0B;
        }

        .feedback-date {
            color: var(--text-light);
            font-size: 12px;
        }

        .feedback-content {
            color: var(--text-dark);
            font-size: 14px;
            line-height: 1.6;
        }

        .empty-feedback {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .empty-icon {
            font-size: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
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

        @media (max-width: 768px) {
            .main-content {
                padding: 20px 0;
            }
            
            .profile-header {
                padding: 20px;
            }
            
            .profile-info {
                padding: 20px;
            }
            
            .feedback-section {
                padding: 20px;
            }
            
            .profile-name {
                font-size: 24px;
            }
            
            .profile-stats {
                gap: 20px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
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
                    <li class="breadcrumb-item active">{{ __('app.profile') }}</li>
                </ol>
            </nav>

            <!-- Profile Header -->
            <div class="profile-header">
                @if($student->photo)
                    <img src="{{ asset($student->photo) }}" alt="{{ $student->full_name }}" class="profile-avatar">
                @else
                    <div class="profile-avatar" style="background: var(--gradient-primary); display: flex; align-items: center; justify-content: center; color: white; font-size: 48px;">
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