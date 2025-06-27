@include('groups._form', [
    'action' => route('groups.update', $group),
    'method' => 'PUT',
    'submitLabel' => 'Update Group',
    'group' => $group,
    'departments' => $departments ?? []
]) 