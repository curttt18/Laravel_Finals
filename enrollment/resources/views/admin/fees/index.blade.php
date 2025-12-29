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

@section('page-title', 'Fees')
@section('breadcrumb', $roleLabel . ' / Fees')

@section('page-actions')
    @if($prefix === 'admin')
    <a href="{{ route($prefix . '.fees.create') }}" class="btn btn-primary">
        <i class="ri-add-line"></i> Add Fee
    </a>
    @endif
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Fees</h3>
            <span style="color: #64748b; font-size: 0.85rem;">{{ $fees->total() }} total</span>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th class="sortable" data-sort-type="number">ID</th>
                    <th class="sortable">Fee Name</th>
                    <th class="sortable" data-sort-type="number">Amount</th>
                    <th class="sortable">Description</th>
                    @if($prefix === 'admin')
                    <th style="text-align: center;">Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($fees as $fee)
                    <tr>
                        <td style="color: #64748b; font-weight: 600;">#{{ $fee->fee_id }}</td>
                        <td style="font-weight: 600;">{{ $fee->fee_name }}</td>
                        <td style="color: var(--success); font-weight: 700; font-size: 1rem;">₱{{ number_format($fee->amount, 2) }}</td>
                        <td style="color: #64748b; font-size: 0.85rem;">{{ $fee->description ?? '-' }}</td>
                        @if($prefix === 'admin')
                        <td>
                            <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                <a href="{{ route($prefix . '.fees.edit', $fee) }}" class="btn btn-sm" style="background: var(--c-blue); color: white;" title="Edit">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <form action="{{ route($prefix . '.fees.destroy', $fee) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $prefix === 'admin' ? 5 : 4 }}" style="text-align: center; padding: 48px; color: #94a3b8;">
                            <i class="ri-price-tag-3-line" style="font-size: 3rem; display: block; margin-bottom: 12px; opacity: 0.5;"></i>
                            No fees found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($fees->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $fees->links() }}
        </div>
    @endif
@endsection
