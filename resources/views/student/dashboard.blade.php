<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app.student_dashboard') }} - {{ config('app.name', 'Akademi') }}</title>
    
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

        .welcome-card {
            background: var(--gradient-secondary);
            color: var(--white);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: rotate(45deg);
        }

        .welcome-content {
            position: relative;
            z-index: 2;
        }

        .welcome-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .stats-card {
            background: var(--white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--white);
            margin-bottom: 15px;
        }

        .stats-icon.courses {
            background: var(--gradient-primary);
        }

        .stats-icon.documents {
            background: var(--gradient-secondary);
        }

        .stats-icon.feedback {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }

        .stats-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .stats-label {
            color: var(--text-light);
            font-size: 14px;
            font-weight: 500;
        }

        .section-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
        }

        .course-card {
            background: var(--white);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }

        .course-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .course-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .course-teacher {
            color: var(--text-light);
            font-size: 14px;
            margin-bottom: 15px;
        }

        .course-description {
            color: var(--text-light);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .course-actions {
            display: flex;
            gap: 10px;
        }

        .btn-course {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-view {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-view:hover {
            background: var(--primary-hover);
            color: var(--white);
        }

        .btn-feedback {
            background: var(--secondary-color);
            color: var(--white);
        }

        .btn-feedback:hover {
            background: #059669;
            color: var(--white);
        }

        .empty-state {
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

        @media (max-width: 768px) {
            .main-content {
                padding: 20px 0;
            }
            
            .welcome-card {
                padding: 20px;
            }
            
            .welcome-title {
                font-size: 24px;
            }
            
            .stats-card {
                padding: 20px;
                margin-bottom: 15px;
            }
            
            .course-card {
                padding: 20px;
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
            <!-- Welcome Card -->
            <div class="welcome-card">
                <div class="welcome-content">
                    <h1 class="welcome-title">{{ __('app.welcome') }}, {{ $student->firstname }}!</h1>
                    <p class="welcome-subtitle">{{ __('app.student_dashboard_subtitle') }}</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-icon courses">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stats-number">{{ $courses->count() }}</div>
                        <div class="stats-label">{{ __('app.enrolled_courses') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-icon documents">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stats-number">{{ $courses->sum(function($course) { return $course->documents->count(); }) }}</div>
                        <div class="stats-label">{{ __('app.available_documents') }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-icon feedback">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="stats-number">{{ $student->feedback->count() }}</div>
                        <div class="stats-label">{{ __('app.submitted_feedback') }}</div>
                    </div>
                </div>
            </div>

            <!-- Recent Courses -->
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title">{{ __('app.your_courses') }}</h2>
                    
                    @if($courses->count() > 0)
                        <div class="row">
                            @foreach($courses->take(6) as $course)
                                <div class="col-lg-6 col-xl-4">
                                    <div class="course-card">
                                        <h3 class="course-title">{{ $course->title }}</h3>
                                        <p class="course-teacher">
                                            <i class="fas fa-chalkboard-teacher me-1"></i>
                                            {{ $course->teacher ? $course->teacher->firstname . ' ' . $course->teacher->lastname : __('app.no_teacher') }}
                                        </p>
                                        <p class="course-description">
                                            {{ Str::limit($course->description, 100) }}
                                        </p>
                                        <div class="course-actions">
                                            <a href="{{ route('student.course.details', $course->id) }}" class="btn-course btn-view">
                                                <i class="fas fa-eye me-1"></i>
                                                {{ __('app.view_course') }}
                                            </a>
                                            @if(!$student->feedback->where('course_id', $course->id)->count())
                                                <a href="{{ route('student.course.feedback', $course->id) }}" class="btn-course btn-feedback">
                                                    <i class="fas fa-comment me-1"></i>
                                                    {{ __('app.give_feedback') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($courses->count() > 6)
                            <div class="text-center mt-4">
                                <a href="{{ route('student.courses') }}" class="btn btn-primary">
                                    {{ __('app.view_all_courses') }}
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h3>{{ __('app.no_courses_yet') }}</h3>
                            <p>{{ __('app.no_courses_description') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 