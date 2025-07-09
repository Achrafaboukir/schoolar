<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('app.my_courses') }} - {{ config('app.name', 'Akademi') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #1e40af;
            --primary-dark: #1e3a8a;
            --primary-light: #3b82f6;
            --secondary-color: #0ea5e9;
            --accent-color: #06b6d4;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --bg-light: #f8fafc;
            --bg-white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --gradient-primary: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
            --gradient-secondary: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
            font-size: 16px;
        }

        /* Navigation */
        .navbar {
            background: var(--bg-white);
            border-bottom: 1px solid var(--border-color);
            padding: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: var(--shadow-sm);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
            gap: 0.75rem;
        }

        .logo {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            font-weight: 800;
        }

        .logo img {
            width: 24px;
            height: 24px;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background: var(--bg-light);
        }

        .nav-link.active {
            color: var(--primary-color);
            background: var(--primary-color);
            color: white;
        }

        .logout-btn {
            background: var(--danger-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        /* Mobile Navigation */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.25rem;
            cursor: pointer;
            padding: 0.5rem;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--bg-white);
                border-top: 1px solid var(--border-color);
                flex-direction: column;
                padding: 1rem;
                gap: 0.5rem;
            }
            
            .nav-links.show {
                display: flex;
            }
            
            .nav-link {
                width: 100%;
                justify-content: flex-start;
            }
        }

        /* Main Container */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.2s ease;
            font-weight: 500;
        }

        .breadcrumb a:hover {
            color: var(--primary-dark);
        }

        .breadcrumb .separator {
            color: var(--text-light);
        }

        /* Page Header */
        .page-header {
            background: var(--bg-white);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* Course Grid */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .course-card {
            background: var(--bg-white);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow-md);
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
        }

        .course-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-color);
        }

        .course-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .course-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .course-teacher {
            color: var(--text-muted);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .course-status {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background: #fee2e2;
            color: #991b1b;
        }

        .course-description {
            color: var(--text-muted);
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
            color: var(--text-muted);
            font-size: 0.875rem;
            gap: 0.5rem;
        }

        .meta-item i {
            color: var(--primary-color);
        }

        .course-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-course {
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: var(--shadow-sm);
        }

        .btn-view {
            background: var(--primary-color);
            color: white;
        }

        .btn-view:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-feedback {
            background: var(--secondary-color);
            color: white;
        }

        .btn-feedback:hover {
            background: #0284c7;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-feedback-submitted {
            background: var(--success-color);
            color: white;
            cursor: default;
        }

        .btn-feedback-submitted:hover {
            background: var(--success-color);
            transform: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
            background: var(--bg-white);
            border-radius: 12px;
            border: 2px dashed var(--border-color);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
            color: var(--text-light);
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .course-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            
            .page-header {
                padding: 1.5rem;
            }
            
            .page-title {
                font-size: 1.75rem;
            }
            
            .course-grid {
                grid-template-columns: 1fr;
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

        @media (max-width: 480px) {
            .page-header {
                padding: 1.25rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
            
            .course-card {
                padding: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                <div class="logo">
                    <img src="{{ asset('storage/logo.png') }}" alt="{{ config('app.name', 'Akademi') }}" />
                </div>
                <span>{{ config('app.name', 'Akademi') }}</span>
            </a>
            
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <i class="fas fa-bars"></i>
            </button>
            
            <div class="nav-links" id="navLinks">
                <a class="nav-link" href="{{ route('student.dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span>{{ __('app.dashboard') }}</span>
                </a>
                <a class="nav-link active" href="{{ route('student.courses') }}">
                    <i class="fas fa-book"></i>
                    <span>{{ __('app.courses') }}</span>
                </a>
                <a class="nav-link" href="{{ route('student.profile') }}">
                    <i class="fas fa-user"></i>
                    <span>{{ __('app.profile') }}</span>
                </a>
                <form method="POST" action="{{ route('student.logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>{{ __('app.logout') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('student.dashboard') }}">
                <i class="fas fa-home"></i>
                {{ __('app.dashboard') }}
            </a>
            <span class="separator">
                <i class="fas fa-chevron-right"></i>
            </span>
            <span>{{ __('app.my_courses') }}</span>
        </div>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">{{ __('app.my_courses') }}</h1>
            <p class="page-subtitle">{{ __('app.courses_subtitle') }}</p>
        </div>

        <!-- Courses Grid -->
        @if($courses->count() > 0)
            <div class="course-grid">
                @foreach($courses as $course)
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
                                <i class="fas fa-eye"></i>
                                {{ __('app.view_course') }}
                            </a>
                            
                            @if($student->feedback->where('course_id', $course->id)->count())
                                <span class="btn-course btn-feedback-submitted">
                                    <i class="fas fa-check"></i>
                                    {{ __('app.feedback_submitted') }}
                                </span>
                            @else
                                <a href="{{ route('student.course.feedback', $course->id) }}" class="btn-course btn-feedback">
                                    <i class="fas fa-comment"></i>
                                    {{ __('app.give_feedback') }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="empty-title">{{ __('app.no_courses_yet') }}</h3>
                <p>{{ __('app.no_courses_description') }}</p>
            </div>
        @endif
    </div>

    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const navLinks = document.getElementById('navLinks');
            navLinks.classList.toggle('show');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const navLinks = document.getElementById('navLinks');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            
            if (!navLinks.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                navLinks.classList.remove('show');
            }
        });

        // Add hover effects to cards
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.course-card').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>