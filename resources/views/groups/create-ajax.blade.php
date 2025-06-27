@include('groups._form', [
    'action' => route('groups.store'),
    'method' => 'POST',
    'submitLabel' => 'Save Group',
    'departments' => $departments ?? []
]) 