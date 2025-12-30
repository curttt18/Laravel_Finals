@extends('layouts.student')

@section('content')
    <div style="max-width: 600px; margin: 0 auto;">
        <div style="margin-bottom: 24px;">
            <a href="{{ route('student.dashboard') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #64748b; text-decoration: none; font-weight: 500;">
                <i class="ri-arrow-left-line"></i> Back to Dashboard
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="ri-secure-payment-line" style="color: var(--success);"></i>
                <h3>Pay {{ $fee->fee_name }}</h3>
            </div>
            
            <div style="background: var(--bg-cream); padding: 20px; border-radius: 12px; margin-bottom: 24px; border: 1px solid var(--border);">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b;">Total Fee Amount</span>
                    <span style="font-weight: 600;">₱{{ number_format($fee->amount, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span style="color: #64748b;">Amount Paid</span>
                    <span style="font-weight: 600; color: var(--success);">₱{{ number_format($fee->amount - $remaining, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--border); padding-top: 12px; margin-top: 8px;">
                    <span style="color: var(--c-dark); font-weight: 700;">Remaining Balance</span>
                    <span style="font-weight: 700; color: var(--danger); font-size: 1.1rem;">₱{{ number_format($remaining, 2) }}</span>
                </div>
            </div>

            <form action="{{ route('student.payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="fee_id" value="{{ $fee->fee_id }}">

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--c-dark);">Payment Option</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <label style="cursor: pointer;">
                            <input type="radio" name="payment_type" value="full" checked onchange="selectPaymentType('full')" style="display: none;">
                            <div class="option-card selected" id="opt-full">
                                <span style="display: block; font-weight: 700; margin-bottom: 4px;">Full Payment</span>
                                <span style="font-size: 0.85rem; color: #64748b;">Pay remaining balance</span>
                            </div>
                        </label>
                        <label style="cursor: pointer;">
                            <input type="radio" name="payment_type" value="installment" onchange="selectPaymentType('installment')" style="display: none;">
                            <div class="option-card" id="opt-installment">
                                <span style="display: block; font-weight: 700; margin-bottom: 4px;">Installment</span>
                                <span style="font-size: 0.85rem; color: #64748b;">Pick a payment plan</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Installment Plan Selection (hidden by default) -->
                <div id="installment-plan" style="display: none; margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--c-dark);">Select Installment Plan</label>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <button type="button" class="plan-btn" data-months="3" onclick="selectPlan(3)">3 Months</button>
                        <button type="button" class="plan-btn" data-months="5" onclick="selectPlan(5)">5 Months</button>
                        <button type="button" class="plan-btn" data-months="12" onclick="selectPlan(12)">12 Months</button>
                    </div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="payment_amount" style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--c-dark);">Amount to Pay (₱)</label>
                    <input type="number" step="0.01" name="payment_amount" id="payment_amount" class="form-control" value="{{ $remaining }}" readonly required style="font-size: 1.2rem; font-weight: 700; background: #f8fafc;">
                    @error('payment_amount')
                        <span style="color: var(--danger); font-size: 0.85rem; display: block; margin-top: 4px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 24px;">
                    <label for="remarks" style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--c-dark);">Notes / Reference No.</label>
                    <textarea name="remarks" id="remarks" rows="3" class="form-control" placeholder="Enter bank reference number or notes..."></textarea>
                </div>

                <button type="submit" id="submit-btn" class="btn btn-success" style="width: 100%; justify-content: center; padding: 14px; font-size: 1rem;">
                    <i class="ri-secure-payment-fill"></i> Confirm Payment
                </button>
            </form>
        </div>
    </div>

    <style>
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-family: inherit;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--c-blue);
        }
        .option-card {
            padding: 16px;
            border: 2px solid var(--border);
            border-radius: 10px;
            text-align: center;
            transition: all 0.2s;
        }
        .option-card.selected {
            border-color: var(--success);
            background: #f0fdf4;
        }
        input[type="radio"]:checked + .option-card {
            border-color: var(--success);
            background: #f0fdf4;
        }
        .plan-btn {
            padding: 10px 20px;
            border: 2px solid var(--border);
            border-radius: 8px;
            background: white;
            cursor: pointer;
            font-weight: 600;
            font-family: inherit;
            transition: all 0.2s;
        }
        .plan-btn:hover {
            border-color: var(--c-blue);
        }
        .plan-btn.active {
            border-color: var(--c-blue);
            background: var(--c-blue);
            color: white;
        }
    </style>

    <script>
        const remaining = {{ $remaining }};
        const amountInput = document.getElementById('payment_amount');
        const optFull = document.getElementById('opt-full');
        const optInst = document.getElementById('opt-installment');
        const installmentPlan = document.getElementById('installment-plan');
        let selectedPlan = 0;

        function selectPaymentType(type) {
            // Reset plan selection
            document.querySelectorAll('.plan-btn').forEach(btn => btn.classList.remove('active'));
            selectedPlan = 0;

            if (type === 'full') {
                amountInput.value = remaining.toFixed(2);
                installmentPlan.style.display = 'none';
                optFull.classList.add('selected');
                optInst.classList.remove('selected');
            } else {
                amountInput.value = '';
                installmentPlan.style.display = 'block';
                optFull.classList.remove('selected');
                optInst.classList.add('selected');
            }
        }

        function selectPlan(months) {
            selectedPlan = months;
            const amount = remaining / months;
            amountInput.value = amount.toFixed(2);

            // Highlight selected plan
            document.querySelectorAll('.plan-btn').forEach(btn => {
                if (parseInt(btn.dataset.months) === months) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }
    </script>
@endsection
