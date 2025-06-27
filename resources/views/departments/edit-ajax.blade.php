@include('departments._form', [
    'action' => route('departments.update', $department),
    'method' => 'PUT',
    'submitLabel' => 'Update Department',
    'department' => $department
]) 