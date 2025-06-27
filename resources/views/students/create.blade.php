@extends('layouts.dashboard')

@section('page-title', 'Add Student')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add New Student</div>
                <div class="card-body">
                    @include('students._form', [
                        'action' => route('students.store'),
                        'method' => 'POST',
                        'submitLabel' => 'Save Student',
                        'groups' => $groups ?? []
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 