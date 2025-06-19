@extends('layouts.dashboard')

@section('page-title', 'Add User')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add New User</div>
                <div class="card-body">
                    @include('users._form', [
                        'action' => route('users.store'),
                        'method' => 'POST',
                        'submitLabel' => 'Save Role',
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
