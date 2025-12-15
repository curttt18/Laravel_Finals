@extends('layouts.admin')

@section('page-title', 'Add Enrollment')

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.enrollments.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                    <select name="student_id" id="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->student_id }}" {{ old('student_id') == $student->student_id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                    @error('student_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label for="school_year" class="block text-sm font-medium text-gray-700 mb-1">School Year</label>
                    <input type="text" name="school_year" id="school_year" value="{{ old('school_year', date('Y').'-'.(date('Y')+1)) }}" placeholder="e.g., 2024-2025"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                    @error('school_year')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="mb-4">
                    <label for="enrollment_date" class="block text-sm font-medium text-gray-700 mb-1">Enrollment Date</label>
                    <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date', date('Y-m-d')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                    @error('enrollment_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="enrolled" {{ old('status') === 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                        <option value="withdrawn" {{ old('status') === 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                    </select>
                    @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.enrollments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Create Enrollment</button>
                </div>
            </form>
        </div>
    </div>
@endsection
