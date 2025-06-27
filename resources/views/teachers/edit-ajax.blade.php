@include('teachers._form', [
    'action' => route('teachers.update', $teacher),
    'method' => 'PUT',
    'submitLabel' => 'Update Teacher',
    'teacher' => $teacher,
    'groups' => $groups ?? []
]) 