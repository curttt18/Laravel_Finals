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

@section('page-title', 'Add Payment')
@section('breadcrumb', $roleLabel . ' / Payments / Create')

@section('page-actions')
    <a href="{{ route($prefix . '.payments.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Back
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 650px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-bank-card-line" style="margin-right: 8px; color: var(--success);"></i>Record New Payment</h3>
        </div>
        
        <form action="{{ route($prefix . '.payments.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="student_id" class="form-label">Student</label>
                <select name="student_id" id="student_id" class="form-control" required>
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                        <option value="{{ $student->student_id }}" {{ old('student_id') == $student->student_id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="fee_id" class="form-label">Fee Type</label>
                <select name="fee_id" id="fee_id" class="form-control" required>
                    <option value="">Select Fee</option>
                    @foreach($fees as $fee)
                        <option value="{{ $fee->fee_id }}" {{ old('fee_id') == $fee->fee_id ? 'selected' : '' }}>{{ $fee->fee_name }} (₱{{ number_format($fee->amount, 2) }})</option>
                    @endforeach
                </select>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="payment_amount" class="form-label">Amount (₱)</label>
                    <input type="number" step="0.01" name="payment_amount" id="payment_amount" value="{{ old('payment_amount') }}" class="form-control" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" class="form-control" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="payment_type" class="form-label">Payment Type</label>
                <select name="payment_type" id="payment_type" class="form-control" required>
                    <option value="full" {{ old('payment_type') === 'full' ? 'selected' : '' }}>Full Payment</option>
                    <option value="installment" {{ old('payment_type') === 'installment' ? 'selected' : '' }}>Installment</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="remarks" class="form-label">Remarks <span style="color: #94a3b8; font-weight: 400;">(optional)</span></label>
                <input type="text" name="remarks" id="remarks" value="{{ old('remarks') }}" class="form-control" placeholder="Optional notes...">
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route($prefix . '.payments.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">
                    <i class="ri-add-line"></i> Record Payment
                </button>
            </div>
        </form>
    </div>
@endsection
