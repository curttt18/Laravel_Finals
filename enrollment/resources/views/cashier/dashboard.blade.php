@extends('layouts.cashier')

@section('page-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full"><svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"></path></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Today's Payments</p><p class="text-2xl font-bold text-green-600">₱{{ number_format($totalPaymentsToday, 2) }}</p></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full"><svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">This Month</p><p class="text-2xl font-bold text-blue-600">₱{{ number_format($totalPaymentsMonth, 2) }}</p></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full"><svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Enrolled Students</p><p class="text-2xl font-bold text-purple-600">{{ $pendingStudents }}</p></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-center">
                <a href="{{ route('cashier.payments.create') }}" class="w-full px-4 py-3 bg-green-600 text-white text-center rounded-lg hover:bg-green-700 font-semibold">
                    + Record New Payment
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Recent Payments</h3>
            <a href="{{ route('cashier.payments.index') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">View All →</a>
        </div>
        <div class="p-6">
            @forelse($recentPayments as $payment)
                <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <div>
                        <p class="font-medium text-gray-800">{{ $payment->student->student_name }}</p>
                        <p class="text-sm text-gray-500">{{ $payment->fee->fee_name }} - {{ $payment->payment_date->format('M d, Y') }}</p>
                    </div>
                    <div class="text-right">
                        <span class="font-medium text-green-600">₱{{ number_format($payment->payment_amount, 2) }}</span>
                        <span class="block text-xs text-gray-400">{{ $payment->payment_type }}</span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">No payments recorded yet</p>
            @endforelse
        </div>
    </div>
@endsection
