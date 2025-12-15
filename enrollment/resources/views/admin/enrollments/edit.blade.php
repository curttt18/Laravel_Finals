@extends('layouts.admin')

@section('page-title', 'Edit Enrollment')

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.enrollments.update', $enrollment) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                    <select name="student_id" id="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                        @foreach($students as $student)
                            <option value="{{ $student->student_id }}" {{ old('student_id', $enrollment->student_id) == $student->student_id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="school_year" class="block text-sm font-medium text-gray-700 mb-1">School Year</label>
                    <input type="text" name="school_year" id="school_year" value="{{ old('school_year', $enrollment->school_year) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="enrollment_date" class="block text-sm font-medium text-gray-700 mb-1">Enrollment Date</label>
                    <input type="date" name="enrollment_date" id="enrollment_date" value="{{ old('enrollment_date', $enrollment->enrollment_date->format('Y-m-d')) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-6">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                        <option value="pending" {{ old('status', $enrollment->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="enrolled" {{ old('status', $enrollment->status) === 'enrolled' ? 'selected' : '' }}>Enrolled</option>
                        <option value="withdrawn" {{ old('status', $enrollment->status) === 'withdrawn' ? 'selected' : '' }}>Withdrawn</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.enrollments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Enrollment</button>
                </div>
            </form>
        </div>
    </div>
@endsection
