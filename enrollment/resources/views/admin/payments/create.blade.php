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
            
            
            <div id="balance-info" style="display: none; background: var(--bg-cream); padding: 16px; border-radius: 10px; margin-bottom: 20px; border: 1px solid var(--border);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 0.9rem;">Fee Amount:</span>
                    <span id="fee-total" style="font-weight: 600;">₱0.00</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b; font-size: 0.9rem;">Total Paid:</span>
                    <span id="fee-paid" style="font-weight: 600; color: var(--success);">₱0.00</span>
                </div>
                <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--border); padding-top: 8px;">
                    <span style="color: var(--c-dark); font-weight: 700;">Remaining Balance:</span>
                    <span id="fee-remaining" style="font-weight: 700; color: var(--danger);">₱0.00</span>
                </div>
            </div>

            <div id="fully-paid-warning" style="display: none; background: #d1fae5; padding: 16px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #a7f3d0; text-align: center;">
                <i class="ri-checkbox-circle-fill" style="color: #065f46; font-size: 1.5rem;"></i>
                <p style="color: #065f46; font-weight: 600; margin-top: 8px;">This fee is already fully paid!</p>
            </div>

            <div id="payment-fields">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="payment_amount" class="form-label">Amount (₱)</label>
                        <input type="number" step="0.01" name="payment_amount" id="payment_amount" value="{{ old('payment_amount') }}" class="form-control" placeholder="0.00" required readonly>
                        <div id="installment-options" style="display: none; margin-top: 12px;">
                            <p style="margin-bottom: 8px; font-weight: 600; font-size: 0.85rem; color: var(--c-dark);">Select Installment Plan:</p>
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                <button type="button" class="installment-btn" data-months="3" onclick="setInstallment(3)" style="padding: 8px 16px; border: 2px solid var(--border); border-radius: 8px; background: white; cursor: pointer; font-weight: 600; transition: all 0.2s;">3 Months</button>
                                <button type="button" class="installment-btn" data-months="5" onclick="setInstallment(5)" style="padding: 8px 16px; border: 2px solid var(--border); border-radius: 8px; background: white; cursor: pointer; font-weight: 600; transition: all 0.2s;">5 Months</button>
                                <button type="button" class="installment-btn" data-months="12" onclick="setInstallment(12)" style="padding: 8px 16px; border: 2px solid var(--border); border-radius: 8px; background: white; cursor: pointer; font-weight: 600; transition: all 0.2s;">12 Months</button>
                            </div>
                        </div>
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
                    <button type="submit" id="submit-btn" class="btn btn-success">
                        <i class="ri-add-line"></i> Record Payment
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const studentSelect = document.getElementById('student_id');
        const feeSelect = document.getElementById('fee_id');
        const paymentTypeSelect = document.getElementById('payment_type');
        const amountInput = document.getElementById('payment_amount');
        const balanceInfo = document.getElementById('balance-info');
        const installmentOptions = document.getElementById('installment-options');
        const fullyPaidWarning = document.getElementById('fully-paid-warning');
        const paymentFields = document.getElementById('payment-fields');
        const submitBtn = document.getElementById('submit-btn');
        
        let currentBalance = 0;
        let selectedMonths = 0;

        function updateBalance() {
            const studentId = studentSelect.value;
            const feeId = feeSelect.value;

            if (studentId && feeId) {
                fetch(`{{ url($prefix . '/payments/check-balance') }}/${studentId}/${feeId}`)
                    .then(response => response.json())
                    .then(data => {
                        currentBalance = parseFloat(data.remaining_balance);
                        
                        document.getElementById('fee-total').textContent = '₱' + parseFloat(data.fee_amount).toLocaleString('en-US', {minimumFractionDigits: 2});
                        document.getElementById('fee-paid').textContent = '₱' + parseFloat(data.total_paid).toLocaleString('en-US', {minimumFractionDigits: 2});
                        document.getElementById('fee-remaining').textContent = '₱' + currentBalance.toLocaleString('en-US', {minimumFractionDigits: 2});
                        
                        // Check if already fully paid
                        if (currentBalance <= 0) {
                            balanceInfo.style.display = 'block';
                            fullyPaidWarning.style.display = 'block';
                            paymentFields.style.opacity = '0.5';
                            paymentFields.style.pointerEvents = 'none';
                            submitBtn.disabled = true;
                        } else {
                            balanceInfo.style.display = 'block';
                            fullyPaidWarning.style.display = 'none';
                            paymentFields.style.opacity = '1';
                            paymentFields.style.pointerEvents = 'auto';
                            submitBtn.disabled = false;
                            updateAmount();
                        }
                    });
            } else {
                balanceInfo.style.display = 'none';
                fullyPaidWarning.style.display = 'none';
            }
        }

        function updateAmount() {
            // Reset installment button styles
            document.querySelectorAll('.installment-btn').forEach(btn => {
                btn.style.borderColor = 'var(--border)';
                btn.style.background = 'white';
                btn.style.color = 'var(--c-dark)';
            });
            selectedMonths = 0;

            if (paymentTypeSelect.value === 'full') {
                amountInput.value = currentBalance.toFixed(2);
                amountInput.readOnly = true;
                installmentOptions.style.display = 'none';
            } else {
                amountInput.value = '';
                amountInput.readOnly = true; // Always readonly - must select installment plan
                installmentOptions.style.display = 'block';
            }
        }

        function setInstallment(months) {
            if (currentBalance > 0) {
                selectedMonths = months;
                const amount = currentBalance / months;
                amountInput.value = amount.toFixed(2);
                
                // Highlight selected button
                document.querySelectorAll('.installment-btn').forEach(btn => {
                    if (parseInt(btn.dataset.months) === months) {
                        btn.style.borderColor = 'var(--primary)';
                        btn.style.background = 'var(--primary)';
                        btn.style.color = 'white';
                    } else {
                        btn.style.borderColor = 'var(--border)';
                        btn.style.background = 'white';
                        btn.style.color = 'var(--c-dark)';
                    }
                });
            }
        }

        studentSelect.addEventListener('change', updateBalance);
        feeSelect.addEventListener('change', updateBalance);
        paymentTypeSelect.addEventListener('change', updateAmount);
    </script>
@endsection
