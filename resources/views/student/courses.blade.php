<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app.my_courses') }} - {{ config('app.name', 'Akademi') }}</title>
    
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

        .page-subtitle {
            color: var(--text-light);
            font-size: 16px;
        }

        .course-card {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 25px;
            height: 100%;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .course-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .course-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .course-teacher {
            color: var(--text-light);
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .course-teacher i {
            margin-right: 5px;
        }

        .course-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-active {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-inactive {
            background: #FEE2E2;
            color: #991B1B;
        }

        .course-description {
            color: var(--text-light);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .course-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            color: var(--text-light);
            font-size: 14px;
        }

        .meta-item i {
            margin-right: 5px;
            color: var(--primary-color);
        }

        .course-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-course {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
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

        .btn-feedback-submitted {
            background: var(--accent-color);
            color: var(--white);
            cursor: default;
        }

        .btn-feedback-submitted:hover {
            background: var(--accent-color);
            color: var(--white);
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: var(--text-light);
        }

        .empty-icon {
            font-size: 80px;
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
            
            .page-header {
                padding: 20px;
            }
            
            .page-title {
                font-size: 24px;
            }
            
            .course-card {
                padding: 20px;
            }
            
            .course-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .course-status {
                margin-top: 10px;
            }
            
            .course-actions {
                flex-direction: column;
            }
            
            .btn-course {
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
                    <li class="breadcrumb-item active">{{ __('app.my_courses') }}</li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="page-header">
                <h1 class="page-title">{{ __('app.my_courses') }}</h1>
                <p class="page-subtitle">{{ __('app.courses_subtitle') }}</p>
            </div>

            <!-- Courses Grid -->
            @if($courses->count() > 0)
                <div class="row">
                    @foreach($courses as $course)
                        <div class="col-lg-6 col-xl-4">
                            <div class="course-card">
                                <div class="course-header">
                                    <div>
                                        <h3 class="course-title">{{ $course->title }}</h3>
                                        <p class="course-teacher">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                            {{ $course->teacher ? $course->teacher->firstname . ' ' . $course->teacher->lastname : __('app.no_teacher') }}
                                        </p>
                                    </div>
                                    <span class="course-status {{ $course->status ? 'status-active' : 'status-inactive' }}">
                                        {{ $course->status ? __('app.active') : __('app.inactive') }}
                                    </span>
                                </div>
                                
                                <p class="course-description">
                                    {{ Str::limit($course->description, 120) }}
                                </p>
                                
                                <div class="course-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-calendar"></i>
                                        {{ $course->start_date ? $course->start_date->format('M Y') : __('app.no_date') }}
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-file-alt"></i>
                                        {{ $course->documents->count() }} {{ __('app.documents') }}
                                    </div>
                                </div>
                                
                                <div class="course-actions">
                                    <a href="{{ route('student.course.details', $course->id) }}" class="btn-course btn-view">
                                        <i class="fas fa-eye me-1"></i>
                                        {{ __('app.view_course') }}
                                    </a>
                                    
                                    @if($student->feedback->where('course_id', $course->id)->count())
                                        <span class="btn-course btn-feedback-submitted">
                                            <i class="fas fa-check me-1"></i>
                                            {{ __('app.feedback_submitted') }}
                                        </span>
                                    @else
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 