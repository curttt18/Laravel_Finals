@extends('layouts.admin')

@section('page-title', 'Enrollments')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h3 class="text-lg font-medium">All Enrollments</h3>
        <a href="{{ route('admin.enrollments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Enrollment</a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">School Year</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->enrollment_id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $enrollment->student->student_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->school_year }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $enrollment->enrollment_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $enrollment->status === 'enrolled' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $enrollment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $enrollment->status === 'withdrawn' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium">
                            @if($enrollment->status === 'pending')
                                <form action="{{ route('admin.enrollments.approve', $enrollment) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Approve</button>
                                </form>
                            @endif
                            <a href="{{ route('admin.enrollments.edit', $enrollment) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                            <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No enrollments found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $enrollments->links() }}</div>
@endsection
