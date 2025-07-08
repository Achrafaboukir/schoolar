@extends('layouts.dashboard')

@section('page-title', __('courses.management'))

@section('content')
<div class="table-section">
    <div class="table-header">
        <div class="d-flex gap-3 align-items-center">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ __('courses.add_filter') }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">{{ __('courses.status') }}</a></li>
                    <li><a class="dropdown-item" href="#">{{ __('courses.teacher') }}</a></li>
                    <li><a class="dropdown-item" href="#">{{ __('courses.group') }}</a></li>
                </ul>
            </div>
            <div class="search-box flex-grow-1">
                <form method="GET" action="" class="w-100">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="{{ __('courses.search_placeholder') }}" value="{{ request('search') }}">
                    </div>
                </form>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary">{{ __('courses.clear_all') }}</button>
            <button class="btn btn-primary" id="add-course-btn" data-bs-toggle="modal" data-bs-target="#courseModal">
                <i class="fas fa-plus me-2"></i>{{ __('courses.add_new') }}
            </button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('courses.id') }}</th>
                <th>{{ __('courses.title') }}</th>
                <th>{{ __('courses.teacher') }}</th>
                <th>{{ __('courses.group') }}</th>
                <th>{{ __('courses.start_date') }}</th>
                <th>{{ __('courses.end_date') }}</th>
                <th>{{ __('courses.status') }}</th>
                <th>{{ __('courses.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $course)
            <tr>
                <td>{{ $course->id }}</td>
                <td>{{ $course->title }}</td>
                <td>{{ $course->teacher->firstname ?? '' }} {{ $course->teacher->lastname ?? '' }}</td>
                <td>{{ $course->group->name ?? '' }}</td>
                <td>{{ $course->start_date ? $course->start_date->format('Y-m-d') : '' }}</td>
                <td>{{ $course->end_date ? $course->end_date->format('Y-m-d') : '' }}</td>
                <td>
                    <span class="status-badge {{ $course->status ? 'active' : 'inactive' }}">{{ $course->status ? 'ACTIVE' : 'INACTIVE' }}</span>
                </td>
                <td class="actions-cell">
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-icon btn-outline-danger delete-course" data-id="{{ $course->id }}" title="{{ __('courses.delete') }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-outline-primary edit-course-btn" data-id="{{ $course->id }}" title="{{ __('courses.edit') }}" data-bs-toggle="modal" data-bs-target="#courseModal">
                            <i class="fas fa-edit"></i>
                        </button>
                        <a href="{{ route('courses.documents.index', $course->id) }}" class="btn btn-sm btn-icon btn-outline-info" title="{{ __('courses.manage_documents') }}">
                            <i class="fas fa-file-alt"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="table-pagination">
        <div>
            <span class="text-muted">{{ __('courses.showing') }} {{ $courses->firstItem() ?? 0 }} {{ __('courses.to') }} {{ $courses->lastItem() ?? 0 }} {{ __('courses.of') }} {{ $courses->total() ?? 0 }} {{ __('courses.results') }}</span>
        </div>
        <div class="page-numbers">
            {{ $courses->links() }}
        </div>
    </div>
</div>

<!-- Course CRUD Modal -->
<div class="modal fade" id="courseModal" tabindex="-1" role="dialog" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="course-modal-content">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCourseModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">{{ __('courses.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('courses.delete_confirm') }}</p>
                <form id="deleteCourseForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('courses.cancel') }}</button>
                        <button type="submit" class="btn btn-danger px-4">{{ __('courses.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Course page script loaded');

    // Get the course modal
    const courseModal = document.getElementById('courseModal');

    // Add event listeners for modal cleanup
    if (courseModal) {
        courseModal.addEventListener('hidden.bs.modal', function() {
            console.log('Course modal hidden, cleaning up...');
            if (window.cleanupModalBackdrop) {
                window.cleanupModalBackdrop();
            }
        });

        courseModal.addEventListener('shown.bs.modal', function() {
            console.log('Course modal shown');
        });
    }

    // Add Course
    document.getElementById('add-course-btn').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        document.getElementById('course-modal-content').innerHTML = '';
        const modal = document.getElementById('courseModal');
        if (modal) {
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
        }
        fetch("{{ route('courses.create-form') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('course-modal-content').innerHTML = html;
                console.log('Modal content loaded');
                setupFormSubmission();
            })
            .catch(error => console.error('Error loading form:', error));
    });

    // Edit Course
    document.querySelectorAll('.edit-course-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            document.getElementById('course-modal-content').innerHTML = '';
            const id = this.getAttribute('data-id');
            const modal = document.getElementById('courseModal');
            if (modal) {
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            }
            fetch(`/courses/${id}/edit-form`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('course-modal-content').innerHTML = html;
                    console.log('Edit form loaded');
                    setupFormSubmission();
                })
                .catch(error => console.error('Error loading edit form:', error));
        });
    });

    // Delete Course
    document.querySelectorAll('.delete-course').forEach(button => {
        button.addEventListener('click', function() {
            const courseId = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('deleteCourseModal'));
            const form = document.getElementById('deleteCourseForm');
            form.action = `/courses/${courseId}`;
            modal.show();
        });
    });

    // Global Cleanup for Modal Backdrops
    window.cleanupModalBackdrop = function() {
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
        document.body.classList.remove('modal-open');
        document.body.style.paddingRight = '';
    };
});
</script>
@endpush