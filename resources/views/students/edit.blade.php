@extends('layouts.dashboard')

@section('page-title', 'Edit Student')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Student</div>
                <div class="card-body">
                    @include('students._form', [
                        'action' => route('students.update', $student),
                        'method' => 'PUT',
                        'submitLabel' => 'Update Student',
                        'student' => $student,
                        'groups' => $groups ?? []
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 