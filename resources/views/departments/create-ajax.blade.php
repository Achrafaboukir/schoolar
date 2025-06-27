@include('departments._form', [
    'action' => route('departments.store'),
    'method' => 'POST',
    'submitLabel' => 'Save Department'
]) 