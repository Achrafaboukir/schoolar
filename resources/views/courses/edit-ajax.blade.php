@include('courses._form', [
    'action' => route('courses.update', $course),
    'method' => 'PUT',
    'submitLabel' => 'Update Course',
    'course' => $course,
    'teachers' => $teachers ?? [],
    'groups' => $groups ?? []
]) 