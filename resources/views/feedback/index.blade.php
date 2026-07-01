@extends('layouts.dashboard')

@section('page-title', __('roles.feedbacks'))

@section('content')
<div class="content-wrapper">
    <div class="table-section">
        <div class="table-header">
            <div class="d-flex gap-3 align-items-center">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ __('app.filter') }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?anonymity=all">{{ __('app.all') }}</a></li>
                        <li><a class="dropdown-item" href="?anonymity=anonymous">{{ __('app.anonymous') }}</a></li>
                        <li><a class="dropdown-item" href="?anonymity=shown">{{ __('app.shown') }}</a></li>
                    </ul>
                </div>
                <div class="search-box flex-grow-1">
                    <form method="GET" action="" class="w-100">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" placeholder="{{ __('app.search') }}" value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary">{{ __('roles.clear_all') }}</button>
            </div>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('roles.id') }}</th>
                    <th>{{ __('dashboard.course') }}</th>
                    <th>{{ __('dashboard.name') }}</th>
                    <th>{{ __('dashboard.content') }}</th>
                    <th>{{ __('app.status') }}</th>
                    <th>{{ __('app.anonymity') }}</th>
                    <th>{{ __('app.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($feedbacks as $feedback)
                <tr>
                    <td>{{ $feedback->id }}</td>
                    <td>{{ $feedback->course ? $feedback->course->title : __('app.not_specified') }}</td>
                    <td>
                        @if($feedback->is_anonymous)
                            @if(auth()->user()->hasPermission('delete_feedback'))
                                {{ $feedback->student ? $feedback->student->full_name : __('app.not_specified') }}
                            @else
                                {{ __('app.anonymous') }}
                            @endif
                        @elseif($feedback->student)
                            {{ $feedback->student->full_name }}
                        @else
                            {{ __('app.not_specified') }}
                        @endif
                    </td>
                    <td>{{ $feedback->content }}</td>
                    <td>
                        @php $status = $feedback->is_anonymous ? 'inactive' : 'active'; @endphp
                        <span class="status-badge {{ $status }}">{{ strtoupper(__('app.' . $status)) }}</span>
                    </td>
                    <td>
                        @if($feedback->is_anonymous)
                            <span class="badge bg-secondary">{{ __('app.anonymous') }}</span>
                        @else
                            <span class="badge bg-success">{{ __('app.shown') }}</span>
                        @endif
                    </td>
                    <td class="actions-cell">
                        @if(auth()->user()->hasPermission('delete_feedback'))
                        <button class="btn btn-sm btn-icon btn-outline-danger delete-feedback" data-id="{{ $feedback->id }}" title="{{ __('app.delete') }}" data-bs-toggle="modal" data-bs-target="#deleteFeedbackModal">
                            <i class="fas fa-trash"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">{{ __('app.no_feedbacks_found') ?? __('app.no_results') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="table-pagination">
            <div>
                @if(method_exists($feedbacks, 'firstItem'))
                    <span class="text-muted">{{ __('roles.showing') }} {{ $feedbacks->firstItem() ?? 0 }} {{ __('roles.to') }} {{ $feedbacks->lastItem() ?? 0 }} {{ __('roles.of') }} {{ $feedbacks->total() ?? 0 }} {{ __('roles.results') }}</span>
                @else
                    <span class="text-muted">{{ __('roles.showing') }} 1 {{ __('roles.to') }} {{ $feedbacks->count() }} {{ __('roles.of') }} {{ $feedbacks->count() }} {{ __('roles.results') }}</span>
                @endif
            </div>
            <div class="page-numbers">
                @if(method_exists($feedbacks, 'links'))
                    {{ $feedbacks->links() }}
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteFeedbackModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">{{ __('app.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('app.delete_feedback_confirm') }}</p>
                <form id="deleteFeedbackForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('app.cancel') }}</button>
                        <button type="submit" class="btn btn-danger px-4">{{ __('app.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-feedback').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const form = document.getElementById('deleteFeedbackForm');
            form.action = `/feedback/${id}`;
        });
    });
});
</script>
@endpush 