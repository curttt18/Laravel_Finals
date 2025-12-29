@php
    $prefix = request()->segment(1);
    $layout = match($prefix) {
        'registrar' => 'layouts.registrar',
        'cashier' => 'layouts.cashier',
        default => 'layouts.admin'
    };
    $roleLabel = ucfirst($prefix);
@endphp

@extends($layout)

@section('page-title', 'Payments')
@section('breadcrumb', $roleLabel . ' / Payments')

@section('page-actions')
    @if(Route::has($prefix . '.payments.create'))
    <a href="{{ route($prefix . '.payments.create') }}" class="btn btn-primary">
        <i class="ri-add-line"></i> Add Payment
    </a>
    @endif
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Payments</h3>
            <span style="color: #64748b; font-size: 0.85rem;">{{ $payments->total() }} total</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th class="sortable" data-sort-type="number">ID</th>
                    <th class="sortable">Student</th>
                    <th class="sortable">Fee</th>
                    <th class="sortable" data-sort-type="number">Amount</th>
                    <th class="sortable">Type</th>
                    <th class="sortable" data-sort-type="date">Date</th>
                    @if($prefix !== 'registrar')
                    <th style="text-align: center;">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td style="color: #64748b; font-weight: 600;">#{{ $payment->payment_id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; background: var(--c-teal); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem;">
                                    {{ substr($payment->student->student_name, 0, 1) }}
                                </div>
                                <span style="font-weight: 600;">{{ $payment->student->student_name }}</span>
                            </div>
                        </td>
                        <td style="color: #64748b;">{{ $payment->fee->fee_name }}</td>
                        <td style="color: var(--success); font-weight: 700; font-size: 1rem;">₱{{ number_format($payment->payment_amount, 2) }}</td>
                        <td>
                            @if($payment->payment_type === 'full')
                                <span class="badge badge-success">Full</span>
                            @else
                                <span class="badge badge-info">{{ ucfirst($payment->payment_type) }}</span>
                            @endif
                        </td>
                        <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                        @if($prefix !== 'registrar')
                        <td>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                @if(Route::has($prefix . '.payments.edit'))
                                <a href="{{ route($prefix . '.payments.edit', $payment) }}" class="btn btn-sm" style="background: var(--c-blue); color: white;" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                @endif
                                @if($prefix === 'admin')
                                <form action="{{ route($prefix . '.payments.destroy', $payment) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $prefix === 'registrar' ? 6 : 7 }}" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <i class="ri-bank-card-line" style="font-size: 3rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                            No payments found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payments->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $payments->links() }}
        </div>
    @endif
@endsection
