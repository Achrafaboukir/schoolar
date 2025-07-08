<form method="POST" action="{{ $action }}" id="courseForm" enctype="multipart/form-data">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <div class="card shadow-sm border-0 mb-0">
        <div class="card-body">
            <h5 class="mb-4"><i class="fas fa-book me-2 text-primary"></i> {{ __('courses.course_information') }}</h5>
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">{{ __('courses.course_title') }}</label>
                    <input type="text" name="title" class="form-control" value="{{ $course->title ?? old('title') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">{{ __('courses.course_description') }}</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $course->description ?? old('description') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('courses.teacher') }}</label>
                    <select name="teacher_id" class="form-select" required>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}" @if(isset($course) && $course->teacher_id == $teacher->id) selected @endif>{{ $teacher->firstname }} {{ $teacher->lastname }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('courses.group') }}</label>
                    <select name="group_id" class="form-select" required>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" @if(isset($course) && $course->group_id == $group->id) selected @endif>{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('courses.start_date') }}</label>
                    <input type="date" name="start_date" class="form-control" value="{{ isset($course) ? $course->start_date?->format('Y-m-d') : old('start_date') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('courses.end_date') }}</label>
                    <input type="date" name="end_date" class="form-control" value="{{ isset($course) ? $course->end_date?->format('Y-m-d') : old('end_date') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">{{ __('courses.status') }}</label>
                    <select name="status" class="form-select" required>
                        <option value="1" @if(isset($course) && $course->status == 1) selected @endif>{{ __('courses.status_active') }}</option>
                        <option value="0" @if(isset($course) && $course->status == 0) selected @endif>{{ __('courses.status_inactive') }}</option>
                    </select>
                </div>
                         </div>
        </div>
        <div class="card-footer bg-white border-0 d-flex justify-content-between gap-2 py-3">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal"><i class="fas fa-times me-2"></i>{{ __('courses.cancel') }}</button>
            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>{{ $submitLabel }}</button>
        </div>
    </div>
  </form> 