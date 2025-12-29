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

@section('page-title', 'Add New Student')
@section('breadcrumb', $roleLabel . ' / Students / Create')

@section('page-actions')
    <a href="{{ route($prefix . '.students.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Back
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 700px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-user-add-line" style="margin-right: 8px; color: var(--c-coral);"></i>Add New Student</h3>
        </div>
        
        <form action="{{ route($prefix . '.students.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="student_name" class="form-label">Student Name</label>
                <input type="text" name="student_name" id="student_name" value="{{ old('student_name') }}" class="form-control" placeholder="Enter student's full name" required>
                @error('student_name')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control" required>
                    @error('date_of_birth')
                        <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="gender" class="form-label">Gender</label>
                    <select name="gender" id="gender" class="form-control" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="guardian_name" class="form-label">Guardian Name</label>
                <input type="text" name="guardian_name" id="guardian_name" value="{{ old('guardian_name') }}" class="form-control" placeholder="Parent or guardian's name" required>
                @error('guardian_name')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="contact_information" class="form-label">Contact Information</label>
                <input type="text" name="contact_information" id="contact_information" value="{{ old('contact_information') }}" class="form-control" placeholder="Phone number or email" required>
                @error('contact_information')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" rows="3" class="form-control" placeholder="Complete home address" required>{{ old('address') }}</textarea>
                @error('address')
                    <p style="color: var(--danger); font-size: 0.85rem; margin-top: 6px;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route($prefix . '.students.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-add-line"></i> Create Student
                </button>
            </div>
        </form>
    </div>
@endsection
