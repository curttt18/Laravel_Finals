@php
    $prefix = request()->segment(1);
    $layout = match($prefix) {
        'registrar' => 'layouts.registrar',
        'cashier' => 'layouts.cashier',
        default => 'layouts.admin'
    };
    $roleLabel = ucfirst($prefix);
@endphp

@extends($layout)

@section('page-title', 'Edit Enrollment')
@section('breadcrumb', $roleLabel . ' / Enrollments / Edit')

@section('page-actions')
    <a href="{{ route($prefix . '.enrollments.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Back
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-edit-line" style="margin-right: 8px; color: var(--c-blue);"></i>Edit Enrollment</h3>
        </div>
        
        <form action="{{ route($prefix . '.enrollments.update', $enrollment) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="student_id" class="form-label">Student</label>
                <select name="student_id" id="student_id" class="form-control" required>
                    @foreach($students as $student)
                        <option value="{{ $student->student_id }}" {{ old('student_id', $enrollment->student_id) == $student->student_id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="school_year" class="form-label">School Year</label>
                <input type="text" name="school_year" id="school_year" value="{{ old('school_year', $enrollment->school_year) }}" class="form-control" placeholder="e.g., 2024-2025" required>
            </div>
            
            <div class="form-group">
                <label for="enrollment_date" class="form-label">Enrollment Date</label>
                <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date', $enrollment->enrollment_date->format('Y-m-d')) }}" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="pending" {{ old('status', $enrollment->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="enrolled" {{ old('status', $enrollment->status) === 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                    <option value="withdrawn" {{ old('status', $enrollment->status) === 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                </select>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route($prefix . '.enrollments.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Update Enrollment
                </button>
            </div>
        </form>
    </div>
@endsection
