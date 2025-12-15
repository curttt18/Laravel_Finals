@extends('layouts.admin')

@section('page-title', 'Grades / Performance')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h3 class="text-lg font-medium">All Grade Records</h3>
        <a href="{{ route('admin.grades.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Grade</a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teacher</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cognitive</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Social</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Behavior</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($grades as $grade)
                    <tr>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $grade->student->student_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $grade->academic_period }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $grade->teacher->teacher_name }}</td>
                        <td class="px-6 py-4 text-sm capitalize">{{ str_replace('_', ' ', $grade->cognitive_skills) }}</td>
                        <td class="px-6 py-4 text-sm capitalize">{{ str_replace('_', ' ', $grade->motor_skills) }}</td>
                        <td class="px-6 py-4 text-sm capitalize">{{ str_replace('_', ' ', $grade->social_skills) }}</td>
                        <td class="px-6 py-4 text-sm capitalize">{{ str_replace('_', ' ', $grade->behavior) }}</td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="{{ route('admin.grades.edit', $grade) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">No grade records found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $grades->links() }}</div>
@endsection
