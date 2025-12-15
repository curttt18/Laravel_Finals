@extends('layouts.admin')

@section('page-title', 'Add User')

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" id="role" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        <option value="admin">Admin</option>
                        <option value="registrar">Registrar</option>
                        <option value="cashier">Cashier</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Link to Student (Optional)</label>
                    <select name="student_id" id="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">None</option>
                        @foreach($students as $student)
                            <option value="{{ $student->student_id }}">{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Only for student accounts</p>
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Create User</button>
                </div>
            </form>
        </div>
    </div>
@endsection
