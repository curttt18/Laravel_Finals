@extends('layouts.cashier')

@section('page-title', 'Dashboard')

@section('content')
    @php
        $stats = [
            'total_students' => \App\Models\Student::count(),
            'total_payments' => \App\Models\Payment::sum('payment_amount'),
            'payments_today' => \App\Models\Payment::whereDate('payment_date', today())->sum('payment_amount'),
        ];
        $recentPayments = \App\Models\Payment::with(['student', 'fee'])->orderBy('created_at', 'desc')->limit(10)->get();
    @endphp
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full"><svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Total Students</p><p class="text-2xl font-bold text-gray-800">{{ $stats['total_students'] }}</p></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full"><svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1"></path></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Total Payments</p><p class="text-2xl font-bold text-gray-800">₱{{ number_format($stats['total_payments'], 2) }}</p></div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full"><svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                <div class="ml-4"><p class="text-sm text-gray-500">Today's Payments</p><p class="text-2xl font-bold text-gray-800">₱{{ number_format($stats['payments_today'], 2) }}</p></div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Recent Payments</h3>
            <a href="{{ route('cashier.payments.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">+ New Payment</a>
        </div>
        <div class="p-6">
            @forelse($recentPayments as $payment)
                <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                    <div><p class="font-medium text-gray-800">{{ $payment->student->student_name }}</p><p class="text-sm text-gray-500">{{ $payment->fee->fee_name }} - {{ $payment->payment_date->format('M d, Y') }}</p></div>
                    <span class="font-medium text-green-600">₱{{ number_format($payment->payment_amount, 2) }}</span>
                </div>
            @empty
                <p class="text-gray-500">No payments yet</p>
            @endforelse
        </div>
    </div>
@endsection
