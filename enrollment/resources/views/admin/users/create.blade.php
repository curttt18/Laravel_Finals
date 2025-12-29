@extends('layouts.admin')

@section('page-title', 'Add User')
@section('breadcrumb', 'Admin / Users / Create')

@section('page-actions')
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Back
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-user-add-line" style="margin-right: 8px; color: var(--c-coral);"></i>Add New User</h3>
        </div>
        
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Full name" required>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="user@example.com" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Create a password" required>
            </div>
            
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm password" required>
            </div>
            
            <div class="form-group">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="registrar">Registrar</option>
                    <option value="cashier">Cashier</option>
                    <option value="student">Student</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="student_id" class="form-label">Link to Student <span style="color: #94a3b8; font-weight: 400;">(for student accounts only)</span></label>
                <select name="student_id" id="student_id" class="form-control">
                    <option value="">None</option>
                    @foreach($students as $student)
                        <option value="{{ $student->student_id }}">{{ $student->student_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-add-line"></i> Create User
                </button>
            </div>
        </form>
    </div>
@endsection
