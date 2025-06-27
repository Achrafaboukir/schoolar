@extends('layouts.dashboard')

@section('page-title', 'Add Group')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add New Group</div>
                <div class="card-body">
                    @include('groups._form', [
                        'action' => route('groups.store'),
                        'method' => 'POST',
                        'submitLabel' => 'Save Group',
                        'departments' => $departments ?? []
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection