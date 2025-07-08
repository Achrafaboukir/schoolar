@include('courses.documents._form', [
    'action' => route('courses.documents.store', $course->id),
    'method' => 'POST',
    'submitLabel' => __('documents.save'),
    'course' => $course
]) 