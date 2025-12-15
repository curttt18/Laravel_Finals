@extends('layouts.admin')

@section('page-title', 'Payments')

@section('content')
    <div class="mb-4 flex justify-between items-center">
        <h3 class="text-lg font-medium">All Payments</h3>
        <a href="{{ route('admin.payments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Payment</a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($payments as $payment)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $payment->payment_id }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $payment->student->student_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $payment->fee->fee_name }}</td>
                        <td class="px-6 py-4 text-sm text-green-600 font-medium">₱{{ number_format($payment->payment_amount, 2) }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 text-xs font-medium rounded-full {{ $payment->payment_type === 'full' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">{{ ucfirst($payment->payment_type) }}</span></td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $payment->payment_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm font-medium">
                            <a href="{{ route('admin.payments.edit', $payment) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No payments found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $payments->links() }}</div>
@endsection
