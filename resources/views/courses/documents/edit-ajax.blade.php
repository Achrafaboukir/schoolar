@include('courses.documents._form', [
    'action' => route('courses.documents.update', [$course->id, $document->id]),
    'method' => 'PUT',
    'submitLabel' => __('documents.update'),
    'course' => $course,
    'document' => $document
]) 