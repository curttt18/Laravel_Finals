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

@section('page-title', 'Add Grade')
@section('breadcrumb', $roleLabel . ' / Grades / Create')

@section('page-actions')
    <a href="{{ route($prefix . '.grades.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Back
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 700px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-award-line" style="margin-right: 8px; color: var(--c-coral);"></i>Add New Grade Record</h3>
        </div>
        
        <form action="{{ route($prefix . '.grades.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="student_id" class="form-label">Student</label>
                    <select name="student_id" id="student_id" class="form-control" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->student_id }}" {{ old('student_id') == $student->student_id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="teacher_id" class="form-label">Teacher</label>
                    <select name="teacher_id" id="teacher_id" class="form-control" required>
                        <option value="">Select Teacher</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->teacher_id }}" {{ old('teacher_id') == $teacher->teacher_id ? 'selected' : '' }}>{{ $teacher->teacher_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="academic_period" class="form-label">Academic Period</label>
                <select name="academic_period" id="academic_period" class="form-control" required>
                    <option value="">Select Period</option>
                    <option value="Q1" {{ old('academic_period') === 'Q1' ? 'selected' : '' }}>Quarter 1</option>
                    <option value="Q2" {{ old('academic_period') === 'Q2' ? 'selected' : '' }}>Quarter 2</option>
                    <option value="Q3" {{ old('academic_period') === 'Q3' ? 'selected' : '' }}>Quarter 3</option>
                    <option value="Q4" {{ old('academic_period') === 'Q4' ? 'selected' : '' }}>Quarter 4</option>
                </select>
            </div>
            
            <div style="background: var(--bg-cream); border-radius: 12px; padding: 20px; margin: 20px 0;">
                <h4 style="margin-bottom: 16px; font-size: 0.95rem; color: var(--c-dark);">Skill Assessment</h4>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    @foreach(['cognitive_skills' => 'Cognitive Skills', 'motor_skills' => 'Motor Skills', 'social_skills' => 'Social Skills', 'emotional_dev' => 'Emotional Development', 'behavior' => 'Behavior'] as $field => $label)
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="{{ $field }}" class="form-label" style="font-size: 0.8rem;">{{ $label }}</label>
                            <select name="{{ $field }}" id="{{ $field }}" class="form-control" required>
                                <option value="excellent" {{ old($field) === 'excellent' ? 'selected' : '' }}>Excellent</option>
                                <option value="good" {{ old($field) === 'good' ? 'selected' : '' }}>Good</option>
                                <option value="satisfactory" {{ old($field) === 'satisfactory' ? 'selected' : '' }}>Satisfactory</option>
                                <option value="needs_improvement" {{ old($field) === 'needs_improvement' ? 'selected' : '' }}>Needs Improvement</option>
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="form-group">
                <label for="teacher_remarks" class="form-label">Teacher Remarks <span style="color: #94a3b8; font-weight: 400;">(optional)</span></label>
                <textarea name="teacher_remarks" id="teacher_remarks" rows="3" class="form-control" placeholder="Additional comments...">{{ old('teacher_remarks') }}</textarea>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route($prefix . '.grades.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-add-line"></i> Create Grade Record
                </button>
            </div>
        </form>
    </div>
@endsection
