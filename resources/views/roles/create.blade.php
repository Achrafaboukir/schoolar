@extends('layouts.dashboard')

@section('page-title', 'Add Role')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Role</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="accordion" id="permissionsAccordion">
                                @php
                                    $models = [
                                        'students' => ['add_student', 'access_student', 'edit_student', 'delete_student'],
                                        'users' => ['add_user', 'access_users', 'edit_user', 'delete_user'],
                                        'courses' => ['add_course', 'access_courses', 'edit_course', 'delete_course'],
                                    ];
                                @endphp
                                @foreach($models as $model => $perms)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $model }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $model }}" aria-expanded="false" aria-controls="collapse-{{ $model }}">
                                            {{ ucfirst($model) }}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $model }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $model }}" data-bs-parent="#permissionsAccordion">
                                        <div class="accordion-body">
                                            <div class="row">
                                                @foreach($perms as $perm)
                                                <div class="col-6 col-md-4">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $perm }}" id="perm_{{ $perm }}">
                                                        <label class="form-check-label" for="perm_{{ $perm }}">
                                                            {{ ucwords(str_replace('_',' ', $perm)) }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Role</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
