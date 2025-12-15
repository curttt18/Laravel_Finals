@extends('layouts.admin')

@section('page-title', 'Add Grade Record')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.grades.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                        <select name="student_id" id="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->student_id }}">{{ $student->student_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->teacher_id }}">{{ $teacher->teacher_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="academic_period" class="block text-sm font-medium text-gray-700 mb-1">Academic Period</label>
                    <select name="academic_period" id="academic_period" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                        <option value="Q1">Q1 - First Quarter</option>
                        <option value="Q2">Q2 - Second Quarter</option>
                        <option value="Q3">Q3 - Third Quarter</option>
                        <option value="Q4">Q4 - Fourth Quarter</option>
                    </select>
                </div>
                
                <h4 class="text-md font-semibold mb-3 mt-6">Performance Assessment</h4>
                @php $skills = ['cognitive_skills', 'motor_skills', 'social_skills', 'emotional_dev', 'behavior']; @endphp
                @foreach($skills as $skill)
                    <div class="mb-3">
                        <label for="{{ $skill }}" class="block text-sm font-medium text-gray-700 mb-1">{{ ucwords(str_replace('_', ' ', $skill)) }}</label>
                        <select name="{{ $skill }}" id="{{ $skill }}" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                            <option value="excellent">Excellent</option>
                            <option value="good" selected>Good</option>
                            <option value="satisfactory">Satisfactory</option>
                            <option value="needs_improvement">Needs Improvement</option>
                        </select>
                    </div>
                @endforeach
                
                <div class="mb-6 mt-4">
                    <label for="teacher_remarks" class="block text-sm font-medium text-gray-700 mb-1">Teacher Remarks</label>
                    <textarea name="teacher_remarks" id="teacher_remarks" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.grades.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Create Grade Record</button>
                </div>
            </form>
        </div>
    </div>
@endsection
