@extends('layouts.dashboard')

@section('page-title', __('departments.management'))

@section('content')
<div class="table-section">
    <div class="table-header">
        <div class="d-flex gap-3 align-items-center">
            <div class="search-box flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="{{ __('departments.search_placeholder') }}">
                </div>
            </div>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" id="add-department-btn">
                <i class="fas fa-plus me-2"></i>{{ __('departments.add_new') }}
            </button>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>{{ __('departments.id') }}</th>
                <th>{{ __('departments.name') }}</th>
                <th>{{ __('departments.description') }}</th>
                <th>{{ __('departments.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments ?? [] as $department)
            <tr>
                <td>{{ $department->id }}</td>
                <td>{{ $department->name }}</td>
                <td>{{ $department->description }}</td>
                <td>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-icon btn-outline-danger delete-department" data-id="{{ $department->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn btn-sm btn-icon btn-outline-primary edit-department-btn" data-id="{{ $department->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="table-pagination">
        <div>
            <span class="text-muted">{{ __('departments.showing') }} {{ $departments->firstItem() ?? 0 }} {{ __('departments.to') }} {{ $departments->lastItem() ?? 0 }} {{ __('departments.of') }} {{ $departments->total() ?? 0 }} {{ __('departments.results') }}</span>
        </div>
        <div class="page-numbers">
            {{ $departments->links() }}
        </div>
    </div>
</div>

<!-- Department CRUD Modal (AJAX content loaded here) -->
<div class="modal fade" id="departmentModal" tabindex="-1" role="dialog" aria-labelledby="departmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="department-modal-content">
      <!-- Modal content will be loaded here -->
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteDepartmentModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">{{ __('departments.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>{{ __('departments.delete_confirm') }}</p>
                <form id="deleteDepartmentForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">{{ __('departments.cancel') }}</button>
                        <button type="submit" class="btn btn-danger px-4">{{ __('departments.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Department
    document.getElementById('add-department-btn').addEventListener('click', function() {
        fetch("{{ route('departments.create-form') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('department-modal-content').innerHTML = html;
                new bootstrap.Modal(document.getElementById('departmentModal')).show();
                
                // Add form submission handler
                setupFormSubmission();
            });
    });

    // Edit Department
    document.querySelectorAll('.edit-department-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            fetch(`/departments/${id}/edit-form`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('department-modal-content').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('departmentModal')).show();
                    
                    // Add form submission handler
                    setupFormSubmission();
                });
        });
    });

    // Delete Department
    const deleteButtons = document.querySelectorAll('.delete-department');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const departmentId = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('deleteDepartmentModal'));
            const form = document.getElementById('deleteDepartmentForm');
            form.action = `/departments/${departmentId}`;
            modal.show();
        });
    });

    // Setup AJAX form submission
    function setupFormSubmission() {
        const form = document.getElementById('departmentForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                // Disable submit button and show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                
                fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        // If there's a redirect, reload the page
                        window.location.reload();
                    } else {
                        return response.json();
                    }
                })
                .then(data => {
                    if (data && data.success) {
                        // Close modal and reload page
                        bootstrap.Modal.getInstance(document.getElementById('departmentModal')).hide();
                        window.location.reload();
                    } else if (data && data.errors) {
                        // Show validation errors
                        showValidationErrors(data.errors);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // On error, reload page to show any flash messages
                    window.location.reload();
                })
                .finally(() => {
                    // Re-enable submit button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
            });
        }
    }

    // Show validation errors
    function showValidationErrors(errors) {
        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });

        // Show new errors
        Object.keys(errors).forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = errors[field][0];
                input.parentNode.appendChild(errorDiv);
            }
        });
    }
});
</script>
@endpush
