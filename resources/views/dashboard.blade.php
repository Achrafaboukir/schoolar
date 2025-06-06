@extends('layouts.dashboard')

@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon students">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_students'] }}</div>
            <div class="stat-label">Students</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon teachers">
            <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_teachers'] }}</div>
            <div class="stat-label">Teachers</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon courses">
            <i class="fas fa-book"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_courses'] }}</div>
            <div class="stat-label">Courses</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon groups">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <div class="stat-value">{{ $stats['total_groups'] }}</div>
            <div class="stat-label">Groups</div>
        </div>
    </div>
</div>

<div class="table-section">
    <div class="table-header">
        <h2 class="table-title">Teachers Overview</h2>
        <a href="{{ url('/teachers') }}" class="btn btn-link">See all</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Teacher</th>
                <th>Department</th>
                <th>Status</th>
                <th>Courses</th>
                <th>Contact</th>
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
                        {{ $teacher->status }}
                    </span>
                </td>
                <td>
                    <div class="d-flex flex-column">
                        <div class="fw-medium">{{ $teacher->teachingCourses->count() }} Courses</div>
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
        <h2 class="table-title">Recent Courses</h2>
        <a href="{{ url('/courses') }}" class="btn btn-link">See all</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Teacher</th>
                <th>Group</th>
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
        <h2 class="table-title">Recent Feedbacks</h2>
        <a href="{{ url('/feedbacks') }}" class="btn btn-link">See all</a>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Teacher</th>
                <th>Group</th>
                <th>Course</th>
                <th>Content</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Achraf aboukir (kiddan)</td>
                <td>Mohamed hamdoun</td>
                <td>3isi dev</td>
                <td>OOP java cours 1</td>
                <td>We need more exemples</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Ibrahim touhami (chowen)</td>
                <td>Yassir amrani</td>
                <td>3isi dev</td>
                <td>OOP java cours 1</td>
                <td>Teacher can you please ad...</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Asmaa toungh (kiddan)</td>
                <td>Tarik targam</td>
                <td>3isi dev</td>
                <td>OOP java cours 1</td>
                <td>Can you slow down</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Achraf aboukir (kiddan)</td>
                <td>Mohamed hamdoun</td>
                <td>3isi dev</td>
                <td>OOP java cours 1</td>
                <td>Teacher you missed the pa...</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Achraf aboukir (kiddan)</td>
                <td>Mohamed hamdoun</td>
                <td>3isi dev</td>
                <td>OOP java cours 1</td>
                <td>We need more exemples</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection