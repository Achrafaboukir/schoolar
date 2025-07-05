@extends('layouts.student')
@section('title', __('app.student_dashboard'))
@section('content')
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

    .welcome-card {
        background: var(--gradient-primary);
        color: var(--white);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        transform: rotate(30deg);
    }

    .welcome-content {
        position: relative;
        z-index: 2;
    }

    .welcome-title {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        font-size: 1rem;
        opacity: 0.9;
    }

    .stats-card {
        background: var(--white);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .stats-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--white);
        margin-bottom: 1rem;
        margin-left: auto;
        margin-right: auto;
    }

    .stats-icon.courses {
        background: var(--primary-color);
    }

    .stats-icon.documents {
        background: var(--secondary-color);
    }

    .stats-icon.feedback {
        background: var(--accent-color);
    }

    .stats-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .stats-label {
        color: var(--text-light);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
    }

    .course-card {
        background: var(--white);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 1.5rem;
    }

    .course-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
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
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
    }

    .course-description {
        color: var(--text-light);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
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

    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
        color: var(--text-light);
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .welcome-card {
            padding: 1.5rem;
        }
        
        .welcome-title {
            font-size: 1.5rem;
        }
        
        .stats-card {
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        .course-card {
            padding: 1rem;
        }
        
        .course-actions {
            flex-direction: column;
        }
        
        .btn-course {
            justify-content: center;
        }
    }
</style>
<div class="welcome-card">
    <div class="welcome-content">
        <h1 class="welcome-title">{{ __('app.welcome') }}, {{ $student->firstname }}!</h1>
        <p class="welcome-subtitle">{{ __('app.student_dashboard_subtitle') }}</p>
    </div>
</div>
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
@endsection