@extends('layouts.dashboard')

@section('page-title', 'Add Role')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Role</div>
                <div class="card-body">
                    @include('roles._form', [
                        'action' => route('roles.store'),
                        'method' => 'POST',
                        'submitLabel' => 'Save Role',
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
