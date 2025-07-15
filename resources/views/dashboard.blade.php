@extends('layouts.dashboard')

@section('page-title', __('app.dashboard'))

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon students">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_students'] }}</div>
            <div class="stat-label">{{ __('app.students') }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon teachers">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_teachers'] }}</div>
            <div class="stat-label">{{ __('app.teachers') }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon courses">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_courses'] }}</div>
            <div class="stat-label">{{ __('app.courses') }}</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon groups" style="color: #fff;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_groups'] }}</div>
            <div class="stat-label">{{ __('app.groups') }}</div>
        </div>
    </div>
</div>

<div class="table-section">
    <div class="table-header">
        <h2 class="table-title">{{ __('dashboard.teachers_overview') }}</h2>
        <a href="{{ url('/teachers') }}" class="btn btn-link">{{ __('dashboard.see_all') }}</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('dashboard.teacher') }}</th>
                <th>{{ __('dashboard.department') }}</th>
                <th>{{ __('dashboard.status') }}</th>
                <th>{{ __('dashboard.courses') }}</th>
                <th>{{ __('dashboard.contact') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        @if($teacher->photo)
                            <img src="{{ asset($teacher->photo) }}" alt="{{ $teacher->full_name }}" class="rounded-circle" width="32" height="32">
                        @else
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px">
                                <i class="fas fa-user"></i>
                            </div>
                        @endif
                        <div>
                            <div class="fw-medium">{{ $teacher->full_name }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $teacher->department }}</td>
                <td>
                    <span class="status-badge {{ strtolower($teacher->status) }}">
                        {{ __($teacher->status) }}
                    </span>
                </td>
                <td>
                    <div class="d-flex flex-column">
                        <div class="fw-medium">{{ $teacher->teachingCourses->count() }} {{ __('dashboard.courses') }}</div>
                        <div class="text-muted small">
                            @foreach($teacher->teachingCourses->take(2) as $course)
                                {{ $course->title }}{{ !$loop->last ? ', ' : '' }}
                            @endforeach
                            @if($teacher->teachingCourses->count() > 2)
                                <span class="text-muted">...</span>
                            @endif
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex flex-column">
                        <div>{{ $teacher->email }}</div>
                        <div class="text-muted small">{{ $teacher->number }}</div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-section">
    <div class="table-header">
        <h2 class="table-title">{{ __('dashboard.recent_courses') }}</h2>
        <a href="{{ url('/courses') }}" class="btn btn-link">{{ __('dashboard.see_all') }}</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('dashboard.title') }}</th>
                <th>{{ __('dashboard.teacher') }}</th>
                <th>{{ __('dashboard.group') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers->flatMap->teachingCourses->take(5) as $course)
            <tr>
                <td>{{ $course->title }}</td>
                <td>{{ $course->teacher->full_name }}</td>
                <td>{{ $course->group->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="table-section">
    <div class="table-header">
        <h2 class="table-title">{{ __('dashboard.recent_feedbacks') }}</h2>
        <a href="{{ route('feedback.index') }}" class="btn btn-link">{{ __('dashboard.see_all') }}</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('dashboard.id') }}</th>
                <th>{{ __('dashboard.name') }}</th>
                <th>{{ __('dashboard.teacher') }}</th>
                <th>{{ __('dashboard.group') }}</th>
                <th>{{ __('dashboard.course') }}</th>
                <th>{{ __('dashboard.content') }}</th>
                <th>{{ __('app.anonymity') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentFeedbacks as $feedback)
            <tr>
                <td>{{ $feedback->id }}</td>
                <td>
                    @if($feedback->is_anonymous)
                        {{ __('dashboard.anonymous') }}
                    @elseif($feedback->student)
                        {{ $feedback->student->full_name }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $feedback->course && $feedback->course->teacher ? $feedback->course->teacher->full_name : 'N/A' }}</td>
                <td>{{ $feedback->course && $feedback->course->group ? $feedback->course->group->name : 'N/A' }}</td>
                <td>{{ $feedback->course ? $feedback->course->title : 'N/A' }}</td>
                <td>{{ $feedback->content }}</td>
                <td>
                    @if($feedback->is_anonymous)
                        <span class="badge bg-secondary">{{ __('app.anonymous') }}</span>
                    @else
                        <span class="badge bg-success">{{ __('app.shown') }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">{{ __('app.no_feedbacks_found') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection