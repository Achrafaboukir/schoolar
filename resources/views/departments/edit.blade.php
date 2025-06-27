@extends('layouts.dashboard')

@section('page-title', 'Edit Department')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Department</div>
                <div class="card-body">
                    @include('departments._form', [
                        'action' => route('departments.update', $department),
                        'method' => 'PUT',
                        'submitLabel' => 'Update Department',
                        'department' => $department
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 