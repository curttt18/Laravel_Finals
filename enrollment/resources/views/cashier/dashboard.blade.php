@extends('layouts.cashier')

@section('page-title', 'Dashboard')
@section('breadcrumb', 'Cashier / Dashboard')

@section('content')
    <div class="stats-grid">
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('cashier.payments.index') }}'">
            <div class="label">Today's Payments</div>
            <div class="value" style="color: var(--success);">₱{{ number_format($totalPaymentsToday, 2) }}</div>
            <p class="change positive">View all payments</p>
        </div>
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('cashier.payments.index') }}'">
            <div class="label">This Month</div>
            <div class="value" style="color: var(--primary);">₱{{ number_format($totalPaymentsMonth, 2) }}</div>
            <p class="change positive">View all payments</p>
        </div>
        <div class="stat-card stat-card-clickable" onclick="window.location.href='{{ route('cashier.students.index') }}'">
            <div class="label">Enrolled Students</div>
            <div class="value">{{ $pendingStudents }}</div>
            <p class="change positive">View all students</p>
        </div>
        <div class="stat-card stat-card-clickable" style="display: flex; align-items: center; justify-content: center;" onclick="window.location.href='{{ route('cashier.payments.create') }}'">
            <div style="text-align: center;">
                <i class="ri-add-line" style="font-size: 1.5rem; color: var(--success);"></i>
                <div class="label" style="margin-top: 8px;">Record New Payment</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-bank-card-line" style="margin-right: 8px; color: var(--primary);"></i>Recent Payments</h3>
            <a href="{{ route('cashier.payments.index') }}" class="btn btn-sm btn-secondary">View All</a>
        </div>
        
        @forelse($recentPayments as $payment)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 14px 0; {{ !$loop->last ? 'border-bottom: 1px solid var(--border);' : '' }}">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: var(--c-teal); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.8rem;">
                        {{ substr($payment->student->student_name, 0, 1) }}
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--c-dark);">{{ $payment->student->student_name }}</div>
                        <div style="font-size: 0.85rem; color: #64748b;">{{ $payment->fee->fee_name }} - {{ $payment->payment_date->format('M d, Y') }}</div>
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-weight: 700; color: var(--success); font-size: 1rem;">₱{{ number_format($payment->payment_amount, 2) }}</div>
                    <span class="badge badge-{{ $payment->payment_type === 'full' ? 'success' : 'info' }}">{{ ucfirst($payment->payment_type) }}</span>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 32px; color: #94a3b8;">
                <i class="ri-bank-card-line" style="font-size: 2.5rem; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
                No payments recorded yet
            </div>
        @endforelse
    </div>
@endsection
