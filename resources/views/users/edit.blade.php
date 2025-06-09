@extends('layouts.dashboard')

@section('page-title', 'Edit User')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Role</div>
                <div class="card-body">
                    @include('users._form', [
                        'action' => route('users.update', $role),
                        'method' => 'PUT',
                        'submitLabel' => 'Update Users',
                        'role' => $role
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
