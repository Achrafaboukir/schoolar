<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app.my_courses') }} - {{ config('app.name', 'Akademi') }}</title>
    
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

        .navbar {
            background: var(--primary-color);
            padding: 1rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--white) !important;
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: var(--white) !important;
            font-weight: 500;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            transform: translateY(-2px);
        }

        .main-content {
            padding: 2rem 0;
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

        .page-subtitle {
            color: var(--text-light);
            font-size: 1rem;
        }

        .course-card {
            background: var(--white);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 1.5rem;
            height: 100%;
        }

        .course-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .course-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .course-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .course-teacher {
            color: var(--text-light);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
        }

        .course-teacher i {
            margin-right: 0.5rem;
        }

        .course-status {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
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
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .course-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            color: var(--text-light);
            font-size: 0.875rem;
        }

        .meta-item i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }

        .course-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-course {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn-view {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-view:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .btn-feedback {
            background: var(--secondary-color);
            color: var(--white);
        }

        .btn-feedback:hover {
            background: #14B8A6;
            transform: translateY(-2px);
        }

        .btn-feedback-submitted {
            background: var(--accent-color);
            color: var(--white);
            cursor: default;
        }

        .btn-feedback-submitted:hover {
            background: var(--accent-color);
            transform: none;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 1rem;
            color: var(--text-light);
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
 volumes: 0.5;
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
            
            .page-header {
                padding: 1rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .course-card {
                padding: 1rem;
            }
            
            .course-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .course-status {
                margin-top: 0.5rem;
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