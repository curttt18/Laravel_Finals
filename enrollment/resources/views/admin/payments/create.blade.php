@extends('layouts.admin')

@section('page-title', 'Add Payment')

@section('content')
    <div class="max-w-xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.payments.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                    <select name="student_id" id="student_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->student_id }}" {{ old('student_id') == $student->student_id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="fee_id" class="block text-sm font-medium text-gray-700 mb-1">Fee Type</label>
                    <select name="fee_id" id="fee_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Fee</option>
                        @foreach($fees as $fee)
                            <option value="{{ $fee->fee_id }}" {{ old('fee_id') == $fee->fee_id ? 'selected' : '' }}>{{ $fee->fee_name }} (₱{{ number_format($fee->amount, 2) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-1">Amount (₱)</label>
                        <input type="number" step="0.01" name="payment_amount" id="payment_amount" value="{{ old('payment_amount') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="payment_date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="payment_type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="payment_type" id="payment_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500" required>
                        <option value="full" {{ old('payment_type') === 'full' ? 'selected' : '' }}>Full Payment</option>
                        <option value="installment" {{ old('payment_type') === 'installment' ? 'selected' : '' }}>Installment</option>
                    </select>
                </div>
                <div class="mb-6">
                    <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                    <input type="text" name="remarks" id="remarks" value="{{ old('remarks') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Record Payment</button>
                </div>
            </form>
        </div>
    </div>
@endsection
