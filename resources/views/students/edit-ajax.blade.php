@include('students._form', [
    'action' => route('students.update', $student),
    'method' => 'PUT',
    'submitLabel' => 'Update Student',
    'student' => $student,
    'groups' => $groups ?? []
]) 