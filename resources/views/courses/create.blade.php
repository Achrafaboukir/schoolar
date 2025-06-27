@extends('layouts.dashboard')

@section('page-title', 'Add Course')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add New Course</div>
                <div class="card-body">
                    @include('courses._form', [
                        'action' => route('courses.store'),
                        'method' => 'POST',
                        'submitLabel' => 'Save Course',
                        'teachers' => $teachers ?? [],
                        'groups' => $groups ?? []
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 