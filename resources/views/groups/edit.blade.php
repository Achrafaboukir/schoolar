@extends('layouts.dashboard')

@section('page-title', 'Edit Group')

@section('content')
<div class="content-wrapper">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Group</div>
                <div class="card-body">
                    @include('groups._form', [
                        'action' => route('groups.update', $group),
                        'method' => 'PUT',
                        'submitLabel' => 'Update Group',
                        'group' => $group,
                        'departments' => $departments ?? []
                    ])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection