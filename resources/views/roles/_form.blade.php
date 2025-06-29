<form method="POST" action="{{ $action }}" id="roleForm">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif
    <div class="mb-3">
        <label class="form-label">{{ __('roles.role_name') }}</label>
        <input type="text" name="name" class="form-control" value="{{ $role->name ?? '' }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">{{ __('roles.permissions') }}</label>
        <div class="accordion" id="permissionsAccordion">
            <div class="row g-3">
                @php
                    $models = [
                        'students' => ['add_student', 'access_student', 'edit_student', 'delete_student'],
                        'users' => ['add_user', 'access_users', 'edit_user', 'delete_user'],
                        'courses' => ['add_course', 'access_courses', 'edit_course', 'delete_course'],
                    ];
                    $modelKeys = array_keys($models);
                    $selected = isset($role) ? (array) json_decode($role->permissions ?? '[]', true) : (old('permissions') ?? []);
                @endphp
                @for($i = 0; $i < count($modelKeys); $i += 2)
                    <div class="col-12 d-flex gap-3">
                        <div class="flex-fill">
                            @php $model = $modelKeys[$i]; $perms = $models[$model]; @endphp
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $model }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $model }}" aria-expanded="false" aria-controls="collapse-{{ $model }}">
                                        {{ __('roles.' . $model) }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $model }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $model }}" data-bs-parent="#permissionsAccordion">
                                    <div class="accordion-body">
                                        <div class="row row-cols-2">
                                            @foreach($perms as $perm)
                                            <div class="col mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm }}" id="perm_{{ $perm }}" {{ in_array($perm, $selected) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perm_{{ $perm }}">
                                                        {{ __('roles.' . $perm) }}
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(isset($modelKeys[$i+1]))
                        <div class="flex-fill">
                            @php $model = $modelKeys[$i+1]; $perms = $models[$model]; @endphp
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-{{ $model }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $model }}" aria-expanded="false" aria-controls="collapse-{{ $model }}">
                                        {{ __('roles.' . $model) }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $model }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $model }}" data-bs-parent="#permissionsAccordion">
                                    <div class="accordion-body">
                                        <div class="row row-cols-2">
                                            @foreach($perms as $perm)
                                            <div class="col mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm }}" id="perm_{{ $perm }}" {{ in_array($perm, $selected) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perm_{{ $perm }}">
                                                        {{ __('roles.' . $perm) }}
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('roles.cancel') }}</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to check if any permission in a section is checked
    function hasCheckedPermissions(sectionId) {
        const checkboxes = document.querySelectorAll(`#${sectionId} input[type="checkbox"]`);
        return Array.from(checkboxes).some(checkbox => checkbox.checked);
    }

    // Function to open accordion sections with checked permissions
    function openSectionsWithCheckedPermissions() {
        const accordionItems = document.querySelectorAll('.accordion-item');
        accordionItems.forEach(item => {
            const collapseId = item.querySelector('.accordion-collapse').id;
            if (hasCheckedPermissions(collapseId)) {
                const collapse = new bootstrap.Collapse(document.getElementById(collapseId), {
                    toggle: false
                });
                collapse.show();
            }
        });
    }

    // Open sections with checked permissions on page load
    openSectionsWithCheckedPermissions();

    // Listen for checkbox changes to open sections when permissions are checked
    document.addEventListener('change', function(e) {
        if (e.target.type === 'checkbox' && e.target.name === 'permissions[]') {
            const accordionItem = e.target.closest('.accordion-item');
            const collapseId = accordionItem.querySelector('.accordion-collapse').id;
            
            if (e.target.checked) {
                const collapse = new bootstrap.Collapse(document.getElementById(collapseId), {
                    toggle: false
                });
                collapse.show();
            }
        }
    });
});
</script>
