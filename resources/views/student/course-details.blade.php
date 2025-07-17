@extends('layouts.student')
@section('title', $course->title . ' - ' . config('app.name', 'Akademi'))
@section('content')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $course->title }} - {{ config('app.name', 'Akademi') }}</title>
    
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

        /* Course Hero */
        .course-hero {
            background: var(--bg-white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }

        .course-header {
            padding: 3rem 2rem;
            background: var(--gradient-primary);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .course-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .course-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .course-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
            line-height: 1.2;
        }

        .course-meta {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            position: relative;
            z-index: 2;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            opacity: 0.9;
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }

        .meta-item i {
            width: 1.2rem;
            text-align: center;
        }

        .course-description {
            font-size: 1.1rem;
            line-height: 1.7;
            opacity: 0.95;
            position: relative;
            z-index: 2;
            max-width: 800px;
        }

        /* Video Section */
        .video-section {
            background: var(--bg-white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }

        .video-header {
            padding: 2rem;
            background: var(--gradient-secondary);
            color: white;
        }

        .video-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .video-subtitle {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .video-container {
            position: relative;
            padding: 2rem;
            background: var(--bg-white);
        }

        .video-player {
            width: 100%;
            height: 500px;
            border-radius: 12px;
            box-shadow: var(--shadow-xl);
            background: #000;
            border: none;
        }

        .video-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding: 1.5rem;
            background: var(--bg-light);
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .video-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .video-duration, .video-quality {
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .video-quality {
            background: var(--success-color);
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background: #0284c7;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-dark);
            border: 2px solid var(--border-color);
        }

        .btn-outline:hover {
            background: var(--text-dark);
            color: white;
            transform: translateY(-2px);
        }

        .btn-success {
            background: var(--success-color);
            color: white;
            cursor: default;
        }

        /* Documents Section */
        .documents-section {
            background: var(--bg-white);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            width: 48px;
            height: 48px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .document-card {
            background: var(--bg-white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .document-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-color);
        }

        .document-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: white;
            margin-bottom: 1rem;
        }

        .document-icon.pdf {
            background: linear-gradient(135deg, #dc2626, #ef4444);
        }

        .document-icon.doc {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
        }

        .document-icon.ppt {
            background: linear-gradient(135deg, #ea580c, #f97316);
        }

        .document-icon.xls {
            background: linear-gradient(135deg, #059669, #10b981);
        }

        .document-icon.other {
            background: linear-gradient(135deg, #6b7280, #9ca3af);
        }

        .document-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .document-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .document-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .document-description {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .btn-download {
            background: var(--primary-color);
            color: white;
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

        .btn-download:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* Empty States */
        .empty-state, .no-video-placeholder {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
            background: var(--bg-light);
            border-radius: 12px;
            border: 2px dashed var(--border-color);
        }

        .empty-icon, .no-video-icon {
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
            .documents-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            
            .course-title {
                font-size: 2rem;
            }
            
            .course-meta {
                gap: 1rem;
                flex-direction: column;
            }
            
            .meta-item {
                width: fit-content;
            }
            
            .video-player {
                height: 300px;
            }
            
            .action-buttons {
                justify-content: center;
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .documents-grid {
                grid-template-columns: 1fr;
            }
            
            .video-controls {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
            
            .video-info {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .course-header {
                padding: 2rem 1.5rem;
            }
            
            .course-title {
                font-size: 1.75rem;
            }
            
            .video-container {
                padding: 1rem;
            }
            
            .video-player {
                height: 250px;
            }
            
            .documents-section {
                padding: 1.5rem;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
        }

        /* Loading Animation */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

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
            <a href="{{ route('student.courses') }}">{{ __('app.my_courses') }}</a>
            <span class="separator">
                <i class="fas fa-chevron-right"></i>
            </span>
            <span>{{ $course->title }}</span>
        </div>

        <!-- Course Hero -->
        <div class="course-hero">
            <div class="course-header">
                <h1 class="course-title">{{ $course->title }}</h1>
                
                <div class="course-meta">
                    <div class="meta-item">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>{{ $course->teacher ? $course->teacher->firstname . ' ' . $course->teacher->lastname : __('app.no_teacher') }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $course->start_date ? $course->start_date->format('M Y') : __('app.no_date') }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-file-alt"></i>
                        <span>{{ $course->documents->count() }} {{ __('app.documents') }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-circle"></i>
                        <span>{{ $course->status ? __('app.active') : __('app.inactive') }}</span>
                    </div>
                </div>
                
                <p class="course-description">
                    {{ $course->description }}
                </p>
            </div>
        </div>

        <!-- Video Section -->
        @php
            $videos = $course->documents->filter(function($document) {
                return $document->file_type === 'video';
            });
        @endphp
        
        @if($videos->count() > 0)
            @foreach($videos as $document)
                <div class="video-section">
                    <div class="video-header">
                        <h2 class="video-title">{{ $document->title }}</h2>
                        <p class="video-subtitle">{{ $document->description ?? 'Course Video Content' }}</p>
                    </div>
                    
                    <div class="video-container">
                        <video class="video-player" controls poster="{{ asset('storage/' . $document->thumbnail_path ?? '') }}">
                            <source src="{{ asset('storage/' . $document->file_path) }}" type="{{ $document->mime_type }}">
                            Your browser does not support the video tag.
                        </video>
                        
                        <div class="video-controls">
                            <div class="video-info">
                                <span class="video-duration">{{ $document->duration ?? 'N/A' }}</span>
                                <span class="video-quality">{{ $document->quality ?? 'HD' }}</span>
                            </div>
                            
                            <div class="action-buttons">
                                <a href="{{ route('student.courses') }}" class="btn btn-outline">
                                    <i class="fas fa-arrow-left"></i>
                                    {{ __('app.back_to_courses') }}
                                </a>
                                @if($student->feedback->where('course_id', $course->id)->count())
                                    <span class="btn btn-success">
                                        <i class="fas fa-check"></i>
                                        {{ __('app.feedback_submitted') }}
                                    </span>
                                @else
                                    <a href="{{ route('student.course.feedback', $course->id) }}" class="btn btn-secondary">
                                        <i class="fas fa-comment"></i>
                                        {{ __('app.give_feedback') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="no-video-placeholder">
                <div class="no-video-icon">
                    <i class="fas fa-video"></i>
                </div>
                <h3 class="empty-title">{{ __('app.no_videos_yet') }}</h3>
                <p>{{ __('app.no_videos_description') }}</p>
            </div>
        @endif

        <!-- Documents Section -->
        <div class="documents-section">
            <div class="section-header">
                <div class="section-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <h2 class="section-title">{{ __('app.course_documents') }}</h2>
            </div>
            
            @php
                $documents = $course->documents->filter(function($document) {
                    return $document->file_type !== 'video';
                });
            @endphp
            
            @if($documents->count() > 0)
                <div class="documents-grid">
                    @foreach($documents as $document)
                        <div class="document-card">
                            @php
                                $fileExtension = pathinfo($document->file_path, PATHINFO_EXTENSION);
                                $iconClass = 'other';
                                if (in_array(strtolower($fileExtension), ['pdf'])) {
                                    $iconClass = 'pdf';
                                } elseif (in_array(strtolower($fileExtension), ['doc', 'docx'])) {
                                    $iconClass = 'doc';
                                } elseif (in_array(strtolower($fileExtension), ['ppt', 'pptx'])) {
                                    $iconClass = 'ppt';
                                } elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx'])) {
                                    $iconClass = 'xls';
                                }
                            @endphp
                            
                            <div class="document-icon {{ $iconClass }}">
                                <i class="fas fa-file-{{ $iconClass === 'other' ? 'alt' : $iconClass }}"></i>
                            </div>
                            <h3 class="document-title">{{ $document->title }}</h3>
                            <div class="document-meta">
                                <span>
                                    <i class="fas fa-calendar"></i>
                                    {{ $document->created_at->format('M d, Y') }}
                                </span>
                                <span>
                                    <i class="fas fa-weight-hanging"></i>
                                    {{ $document->formatted_file_size }}
                                </span>
                            </div>
                            @if($document->description)
                                <p class="document-description">
                                    {{ Str::limit($document->description, 100) }}
                                </p>
                            @endif
                            <a href="{{ route('student.course.documents.download', ['course' => $course->id, 'document' => $document->id]) }}" class="btn-download">
                                <i class="fas fa-download"></i>
                                {{ __('app.download') }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="empty-title">{{ __('app.no_documents_yet') }}</h3>
                    <p>{{ __('app.no_documents_description') }}</p>
                </div>
            @endif
        </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add loading state to download buttons
            document.querySelectorAll('.btn-download').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Downloading...';
                    this.classList.add('loading');
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('loading');
                        window.location.href = this.href;
                    }, 1000);
                });
            });

            // Video player enhancements
            document.querySelectorAll('.video-player').forEach(video => {
                video.addEventListener('play', function() {
                    console.log('Video started playing');
                });
                
                video.addEventListener('pause', function() {
                    console.log('Video paused');
                });
            });

            // Add hover effects to document cards
            document.querySelectorAll('.document-card').forEach(card => {
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
@endsection