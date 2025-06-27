@include('courses._form', [
    'action' => route('courses.store'),
    'method' => 'POST',
    'submitLabel' => 'Save Course',
    'teachers' => $teachers ?? [],
    'groups' => $groups ?? []
]) 