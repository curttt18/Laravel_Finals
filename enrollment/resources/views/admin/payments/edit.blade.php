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

@section('page-title', 'Edit Payment')
@section('breadcrumb', $roleLabel . ' / Payments / Edit')

@section('page-actions')
    <a href="{{ route($prefix . '.payments.index') }}" class="btn btn-secondary">
        <i class="ri-arrow-left-line"></i> Back
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 650px;">
        <div class="card-header">
            <h3 class="card-title"><i class="ri-edit-line" style="margin-right: 8px; color: var(--c-blue);"></i>Edit Payment</h3>
        </div>
        
        <form action="{{ route($prefix . '.payments.update', $payment) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="student_id" class="form-label">Student</label>
                <select name="student_id" id="student_id" class="form-control" required>
                    @foreach($students as $student)
                        <option value="{{ $student->student_id }}" {{ old('student_id', $payment->student_id) == $student->student_id ? 'selected' : '' }}>{{ $student->student_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="fee_id" class="form-label">Fee Type</label>
                <select name="fee_id" id="fee_id" class="form-control" required>
                    @foreach($fees as $fee)
                        <option value="{{ $fee->fee_id }}" {{ old('fee_id', $payment->fee_id) == $fee->fee_id ? 'selected' : '' }}>{{ $fee->fee_name }} (₱{{ number_format($fee->amount, 2) }})</option>
                    @endforeach
                </select>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="payment_amount" class="form-label">Amount (₱)</label>
                    <input type="number" step="0.01" name="payment_amount" id="payment_amount" value="{{ old('payment_amount', $payment->payment_amount) }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" class="form-control" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="payment_type" class="form-label">Payment Type</label>
                <select name="payment_type" id="payment_type" class="form-control" required>
                    <option value="full" {{ old('payment_type', $payment->payment_type) === 'full' ? 'selected' : '' }}>Full Payment</option>
                    <option value="installment" {{ old('payment_type', $payment->payment_type) === 'installment' ? 'selected' : '' }}>Installment</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="remarks" class="form-label">Remarks <span style="color: #94a3b8; font-weight: 400;">(optional)</span></label>
                <input type="text" name="remarks" id="remarks" value="{{ old('remarks', $payment->remarks) }}" class="form-control">
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--border);">
                <a href="{{ route($prefix . '.payments.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i> Update Payment
                </button>
            </div>
        </form>
    </div>
@endsection
