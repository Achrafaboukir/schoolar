@include('teachers._form', [
    'action' => route('teachers.store'),
    'method' => 'POST',
    'submitLabel' => 'Save Teacher',
    'groups' => $groups ?? []
]) 