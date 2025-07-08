<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $course->title }} - {{ config('app.name', 'Akademi') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #1E3A8A;
            --primary-hover: #1E40AF;
            --secondary-color: #2DD4BF;
            --accent-color: #F472B6;
            --text-dark: #111827;
            --text-light: #6B7280;
            --border-color: #E2E8F0;
            --bg-light: #F9FAFB;
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
            line-height: 1.6;
        }

        .navbar {
            background: var(--primary-color);
            padding: 1rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--white);
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-link {
            color: var(--white);
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            font-size: 0.875rem;
        }

        .breadcrumb a {
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: var(--primary-hover);
        }

        .breadcrumb .separator {
            color: var(--text-light);
        }

        .course-hero {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .course-header {
            padding: 2rem;
            background: var(--gradient-primary);
            color: var(--white);
            position: relative;
            overflow: hidden;
        }

        .course-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        .course-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
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
        }

        .video-section {
            background: var(--white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .video-header {
            padding: 1.5rem 2rem;
            background: var(--gradient-secondary);
            color: var(--white);
        }

        .video-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .video-subtitle {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .video-container {
            position: relative;
            padding: 2rem;
            background: var(--white);
        }

        .video-player {
            width: 100%;
            height: 500px;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            background: #000;
        }

        .video-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding: 1rem;
            background: var(--bg-light);
            border-radius: 12px;
        }

        .video-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .video-duration {
            background: var(--primary-color);
            color: var(--white);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .video-quality {
            background: var(--secondary-color);
            color: var(--white);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: var(--primary-color);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(30, 58, 138, 0.3);
        }

        .btn-secondary {
            background: var(--secondary-color);
            color: var(--white);
        }

        .btn-secondary:hover {
            background: #14B8A6;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(45, 212, 191, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-dark);
            border: 2px solid var(--border-color);
        }

        .btn-outline:hover {
            background: var(--text-dark);
            color: var(--white);
            transform: translateY(-2px);
        }

        .btn-success {
            background: var(--accent-color);
            color: var(--white);
            cursor: default;
        }

        .documents-section {
            background: var(--white);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .document-card {
            background: var(--white);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .document-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            border-color: var(--primary-color);
        }

        .document-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--white);
            margin-bottom: 1rem;
        }

        .document-icon.pdf {
            background: linear-gradient(135deg, #DC2626, #EF4444);
        }

        .document-icon.doc {
            background: linear-gradient(135deg, #1E3A8A, #3B82F6);
        }

        .document-icon.ppt {
            background: linear-gradient(135deg, #F472B6, #EC4899);
        }

        .document-icon.xls {
            background: linear-gradient(135deg, #059669, #10B981);
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
            color: var(--text-light);
        }

        .document-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .document-description {
            color: var(--text-light);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .btn-download {
            background: var(--primary-color);
            color: var(--white);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-download:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-light);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            opacity: 0.5;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .no-video-placeholder {
            background: var(--bg-light);
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            padding: 3rem;
            text-align: center;
            color: var(--text-light);
            margin-bottom: 2rem;
        }

        .no-video-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
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
            }
            
            .video-player {
                height: 300px;
            }
            
            .action-buttons {
                justify-content: center;
            }
            
            .btn {
                flex: 1;
                justify-content: center;
            }
            
            .documents-grid {
                grid-template-columns: 1fr;
            }
            
            .nav-links {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .course-header {
                padding: 1.5rem;
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
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="main-container">
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <a class="navbar-brand" href="{{ route('student.dashboard') }}">
                    <i class="fas fa-graduation-cap" style="margin-right: 0.5rem;"></i>
                    {{ config('app.name', 'Akademi') }}
                </a>
                
                <div class="nav-links">
                    <a class="nav-link" href="{{ route('student.dashboard') }}">
                        <i class="fas fa-home" style="margin-right: 0.25rem;"></i>
                        {{ __('app.dashboard') }}
                    </a>
                    <a class="nav-link" href="{{ route('student.courses') }}">
                        <i class="fas fa-book" style="margin-right: 0.25rem;"></i>
                        {{ __('app.courses') }}
                    </a>
                    <a class="nav-link" href="{{ route('student.profile') }}">
                        <i class="fas fa-user" style="margin-right: 0.25rem;"></i>
                        {{ __('app.profile') }}
                    </a>
                    <form method="POST" action="{{ route('student.logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt" style="margin-right: 0.25rem;"></i>
                            {{ __('app.logout') }}
                        </button>
                    </form>
                </div>
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
                    this.style.opacity = '0.7';
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.opacity = '1';
                        window.location.href = this.href;
                    }, 2000);
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
        });
    </script>
</body>
</html>