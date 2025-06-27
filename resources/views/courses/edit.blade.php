@extends('layouts.dashboard')

@section('page-title', 'Edit Course')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Course</div>
                <div class="card-body">
                    @include('courses._form', [
                        'action' => route('courses.update', $course),
                        'method' => 'PUT',
                        'submitLabel' => 'Update Course',
                        'course' => $course,
                        'teachers' => $teachers ?? [],
                        'groups' => $groups ?? []
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 