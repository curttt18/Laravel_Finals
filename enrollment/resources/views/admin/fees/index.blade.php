@extends('layouts.admin')

@section('page-title', 'Fees')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h3 class="text-lg font-medium">All Fees</h3>
        <a href="{{ route('admin.fees.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Fee</a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($fees as $fee)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $fee->fee_id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $fee->fee_name }}</td>
                        <td class="px-6 py-4 text-sm text-green-600 font-medium">₱{{ number_format($fee->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $fee->description ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="{{ route('admin.fees.edit', $fee) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('admin.fees.destroy', $fee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No fees found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $fees->links() }}</div>
@endsection
