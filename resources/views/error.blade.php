@extends('layouts.app')

@section('title', 'Error')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <h1 class="display-1 text-danger mb-4">{{ $code }}</h1>
                    <h2 class="h4 mb-4">Oops! Something went wrong</h2>
                    <p class="text-muted mb-4">{{ $message }}</p>
                    <a href="{{ $_SERVER['HTTP_REFERER'] ?? '/' }}" class="btn btn-primary">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 