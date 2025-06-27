@include('students._form', [
    'action' => route('students.store'),
    'method' => 'POST',
    'submitLabel' => 'Save Student',
    'groups' => $groups ?? []
]) 