<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $course->title }} - {{ config('app.name', 'Akademi') }}</title>
    
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

        .course-header {
            background: var(--white);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .course-title {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 15px;
        }

        .course-meta {
            display: flex;
            gap: 30px;
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
            margin-right: 8px;
            color: var(--primary-color);
            width: 16px;
        }

        .course-description {
            color: var(--text-light);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .course-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-course {
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn-back {
            background: var(--text-light);
            color: var(--white);
        }

        .btn-back:hover {
            background: var(--text-dark);
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

        .section-title {
            font-size: 24px;
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

        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .document-card {
            background: var(--white);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .document-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .document-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--white);
            margin-bottom: 15px;
        }

        .document-icon.pdf {
            background: #EF4444;
        }

        .document-icon.doc {
            background: #3B82F6;
        }

        .document-icon.ppt {
            background: #F59E0B;
        }

        .document-icon.xls {
            background: #10B981;
        }

        .document-icon.other {
            background: var(--primary-color);
        }

        .document-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .document-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 12px;
            color: var(--text-light);
        }

        .document-description {
            color: var(--text-light);
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .btn-download {
            background: var(--primary-color);
            color: var(--white);
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn-download:hover {
            background: var(--primary-hover);
            color: var(--white);
        }

        .empty-documents {
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
            
            .course-header {
                padding: 20px;
            }
            
            .course-title {
                font-size: 24px;
            }
            
            .course-meta {
                gap: 15px;
            }
            
            .course-actions {
                flex-direction: column;
            }
            
            .btn-course {
                justify-content: center;
            }
            
            .documents-grid {
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
                    <li class="breadcrumb-item active">{{ $course->title }}</li>
                </ol>
            </nav>

            <!-- Course Header -->
            <div class="course-header">
                <h1 class="course-title">{{ $course->title }}</h1>
                
                <div class="course-meta">
                    <div class="meta-item">
                        <i class="fas fa-chalkboard-teacher"></i>
                        {{ $course->teacher ? $course->teacher->firstname . ' ' . $course->teacher->lastname : __('app.no_teacher') }}
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        {{ $course->start_date ? $course->start_date->format('M Y') : __('app.no_date') }}
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-file-alt"></i>
                        {{ $course->documents->count() }} {{ __('app.documents') }}
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-circle"></i>
                        {{ $course->status ? __('app.active') : __('app.inactive') }}
                    </div>
                </div>
                
                <p class="course-description">
                    {{ $course->description }}
                </p>
                
                <div class="course-actions">
                    <a href="{{ route('student.courses') }}" class="btn-course btn-back">
                        <i class="fas fa-arrow-left me-1"></i>
                        {{ __('app.back_to_courses') }}
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

            <!-- Course Documents -->
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title">
                        <i class="fas fa-file-alt"></i>
                        {{ __('app.course_documents') }}
                    </h2>
                    
                    @if($course->documents->count() > 0)
                        <div class="documents-grid">
                            @foreach($course->documents as $document)
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
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $document->created_at->format('M d, Y') }}
                                        </span>
                                        <span>
                                            <i class="fas fa-weight-hanging me-1"></i>
                                            {{ $document->formatted_file_size }}
                                        </span>
                                    </div>
                                    
                                    @if($document->description)
                                        <p class="document-description">
                                            {{ Str::limit($document->description, 100) }}
                                        </p>
                                    @endif
                                    
                                    <a href="{{ asset('storage/' . $document->file_path) }}" 
                                       class="btn-download" 
                                       target="_blank"
                                       download>
                                        <i class="fas fa-download me-1"></i>
                                        {{ __('app.download') }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-documents">
                            <div class="empty-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h3>{{ __('app.no_documents_yet') }}</h3>
                            <p>{{ __('app.no_documents_description') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 