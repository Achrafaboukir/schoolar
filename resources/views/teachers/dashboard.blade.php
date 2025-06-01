@extends('layouts.dashboard')

@section('page-title', 'Teacher Dashboard')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Courses</h5>
                    <a href="{{ route('teachers.courses.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-2"></i>Add Course
                    </a>
                </div>
                <div class="card-body">
                    @if($courses->isEmpty())
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-book-open fa-3x text-muted"></i>
                            </div>
                            <h6 class="text-muted">No courses yet</h6>
                            <p class="text-muted small">Start by creating a new course for your groups</p>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($courses as $course)
                            <a href="{{ route('teachers.courses.show', $course) }}" 
                               class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $course->title }}</h6>
                                        <p class="text-muted small mb-0">
                                            {{ $course->group->name }} • 
                                            {{ $course->group->students_count ?? 0 }} students
                                        </p>
                                    </div>
                                    <span class="badge bg-{{ $course->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ $course->status }}
                                    </span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Activities</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Add your timeline items here -->
                        <div class="timeline-item">
                            <div class="timeline-icon bg-primary">
                                <i class="fas fa-file-alt text-white"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">New assignment submitted</h6>
                                <p class="text-muted small mb-0">
                                    John Doe submitted Assignment #3 in Course XYZ
                                </p>
                                <span class="timeline-date">2 hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">My Groups</h5>
                </div>
                <div class="card-body">
                    @if($groups->isEmpty())
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-muted"></i>
                            </div>
                            <h6 class="text-muted">No groups assigned</h6>
                            <p class="text-muted small">Contact admin to get assigned to groups</p>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($groups as $group)
                            <a href="{{ route('teachers.groups.show', $group) }}" 
                               class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $group->name }}</h6>
                                        <p class="text-muted small mb-0">
                                            {{ $group->students_count }} students
                                        </p>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('teachers.courses.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-plus-circle me-2"></i>Create new course
                        </a>
                        <a href="{{ route('teachers.profile') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-edit me-2"></i>Update profile
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-plus me-2"></i>Schedule a class
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.content-wrapper {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.card-header {
    background-color: transparent;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    padding: 1rem;
}

.timeline {
    position: relative;
    padding: 1rem 0;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 1.5rem;
}

.timeline-icon {
    position: absolute;
    left: 0;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline-content {
    position: relative;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.timeline-date {
    font-size: 0.75rem;
    color: #6c757d;
}

.list-group-item-action:hover {
    background-color: #f8f9fa;
}

.list-group-item i {
    width: 20px;
    text-align: center;
}
</style>
@endpush 