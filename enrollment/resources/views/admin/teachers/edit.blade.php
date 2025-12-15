@extends('layouts.admin')

@section('page-title', 'Edit Teacher')

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="teacher_name" class="block text-sm font-medium text-gray-700 mb-1">Teacher Name</label>
                    <input type="text" name="teacher_name" id="teacher_name" value="{{ old('teacher_name', $teacher->teacher_name) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                    @error('teacher_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="mb-6">
                    <label for="contact_information" class="block text-sm font-medium text-gray-700 mb-1">Contact Information</label>
                    <input type="text" name="contact_information" id="contact_information" value="{{ old('contact_information', $teacher->contact_information) }}" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                    @error('contact_information')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.teachers.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Teacher</button>
                </div>
            </form>
        </div>
    </div>
@endsection
