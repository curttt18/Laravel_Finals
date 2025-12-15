@extends('layouts.admin')

@section('page-title', 'Activity Logs')

@section('content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $log->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $log->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                {{ $log->action === 'created' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $log->action === 'updated' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $log->action === 'deleted' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $log->action === 'approved' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ ucfirst($log->action) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $log->description }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No activity logs found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $logs->links() }}</div>
@endsection
