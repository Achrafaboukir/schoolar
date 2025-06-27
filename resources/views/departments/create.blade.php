@extends('layouts.dashboard')

@section('page-title', 'Add Department')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add New Department</div>
                <div class="card-body">
                    @include('departments._form', [
                        'action' => route('departments.store'),
                        'method' => 'POST',
                        'submitLabel' => 'Save Department'
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 