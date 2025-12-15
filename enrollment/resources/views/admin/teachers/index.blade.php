@extends('layouts.admin')

@section('page-title', 'Teachers')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h3 class="text-lg font-medium">All Teachers</h3>
        <a href="{{ route('admin.teachers.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            + Add Teacher
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($teachers as $teacher)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $teacher->teacher_id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $teacher->teacher_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $teacher->contact_information }}</td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No teachers found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $teachers->links() }}</div>
@endsection
