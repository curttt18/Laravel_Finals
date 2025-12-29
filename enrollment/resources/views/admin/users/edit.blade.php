@extends('layouts.admin')

@section('page-title', 'Edit User')
@section('breadcrumb', 'Admin / Users / Edit')

@section('page-actions')
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Back
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-edit-line" style="margin-right: 8px; color: var(--c-blue);"></i>Edit User</h3>
        </div>
        
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password <span style="color: #94a3b8; font-weight: 400;">(leave blank to keep current)</span></label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password...">
            </div>
            
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password...">
            </div>
            
            <div class="form-group">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-control" required>
                    @foreach(['admin', 'registrar', 'cashier', 'student'] as $role)
                        <option value="{{ $role }}" {{ $user->role === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="student_id" class="form-label">Link to Student <span style="color: #94a3b8; font-weight: 400;">(optional)</span></label>
                <select name="student_id" id="student_id" class="form-control">
                    <option value="">None</option>
                    @foreach($students as $student)
                        <option value="{{ $student->student_id }}" {{ $user->student_id == $student->student_id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Update User
                </button>
            </div>
        </form>
    </div>
@endsection
