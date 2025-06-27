@extends('layouts.dashboard')

@section('page-title', 'Add Teacher')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add New Teacher</div>
                <div class="card-body">
                    @include('teachers._form', [
                        'action' => route('teachers.store'),
                        'method' => 'POST',
                        'submitLabel' => 'Save Teacher',
                        'groups' => $groups ?? []
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 