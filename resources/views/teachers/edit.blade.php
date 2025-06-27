@extends('layouts.dashboard')

@section('page-title', 'Edit Teacher')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Teacher</div>
                <div class="card-body">
                    @include('teachers._form', [
                        'action' => route('teachers.update', $teacher),
                        'method' => 'PUT',
                        'submitLabel' => 'Update Teacher',
                        'teacher' => $teacher,
                        'groups' => $groups ?? []
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 