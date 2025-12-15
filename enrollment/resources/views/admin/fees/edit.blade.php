@extends('layouts.admin')

@section('page-title', 'Edit Fee')

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.fees.update', $fee) }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <label for="fee_name" class="block text-sm font-medium text-gray-700 mb-1">Fee Name</label>
                    <input type="text" name="fee_name" id="fee_name" value="{{ old('fee_name', $fee->fee_name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount (₱)</label>
                    <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', $fee->amount) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">{{ old('description', $fee->description) }}</textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.fees.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Fee</button>
                </div>
            </form>
        </div>
    </div>
@endsection
