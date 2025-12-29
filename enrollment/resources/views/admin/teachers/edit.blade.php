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

@section('page-title', 'Edit Teacher')
@section('breadcrumb', $roleLabel . ' / Teachers / Edit')

@section('page-actions')
    <a href="{{ route($prefix . '.teachers.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Back
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-edit-line" style="margin-right: 8px; color: var(--c-blue);"></i>Edit Teacher</h3>
        </div>
        
        <form action="{{ route($prefix . '.teachers.update', $teacher) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="teacher_name" class="form-label">Teacher Name</label>
                <input type="text" name="teacher_name" id="teacher_name" value="{{ old('teacher_name', $teacher->teacher_name) }}" class="form-control" required>
                @error('teacher_name')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="contact_information" class="form-label">Contact Information</label>
                <input type="text" name="contact_information" id="contact_information" value="{{ old('contact_information', $teacher->contact_information) }}" class="form-control" required>
                @error('contact_information')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route($prefix . '.teachers.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Update Teacher
                </button>
            </div>
        </form>
    </div>
@endsection
