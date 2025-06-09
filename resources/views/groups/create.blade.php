<div class="col-md-6">
    <label class="form-label">Department</label>
    <select class="form-select" name="department_id" required>
        @foreach($departments as $department)
            <option value="{{ $department->id }}">{{ $department->name }}</option>
        @endforeach
    </select>
</div>