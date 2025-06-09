@extends('layouts.dashboard')

@section('page-title', 'Edit Role')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Role</div>
                <div class="card-body">
                    @include('roles._form', [
                        'action' => route('roles.update', $role),
                        'method' => 'PUT',
                        'submitLabel' => 'Update Role',
                        'role' => $role
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
