<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function create(Fee $fee)
    {
        $student = Auth::user()->student;
        
        $paid = Payment::where('student_id', $student->student_id)
            ->where('fee_id', $fee->fee_id)
            ->sum('payment_amount');
            
        $remaining = max(0, $fee->amount - $paid);
        
        if ($remaining <= 0) {
            return redirect()->route('student.dashboard')->with('error', 'This fee is already fully paid.');
        }

        return view('student.payments.create', compact('student', 'fee', 'remaining'));
    }

    public function store(Request $request)
    {
        $student = Auth::user()->student;

        $validated = $request->validate([
            'fee_id' => 'required|exists:fees,fee_id',
            'payment_amount' => 'required|numeric|min:1',
            'payment_type' => 'required|in:full,installment',
            'remarks' => 'nullable|string|max:500',
        ]);

        $fee = Fee::findOrFail($validated['fee_id']);
        
        $existingPayments = Payment::where('student_id', $student->student_id)
            ->where('fee_id', $fee->fee_id)
            ->sum('payment_amount');
            
        $remainingBalance = $fee->amount - $existingPayments;

        if ($validated['payment_amount'] > $remainingBalance) {
            return back()->withErrors([
                'payment_amount' => 'Amount exceeds remaining balance of ₱' . number_format($remainingBalance, 2),
            ])->withInput();
        }

        if ($validated['payment_type'] === 'full' && $validated['payment_amount'] < $remainingBalance) {
             return back()->withErrors([
                'payment_amount' => 'Full payment requires the complete remaining balance of ₱' . number_format($remainingBalance, 2),
            ])->withInput();
        }

        Payment::create([
            'student_id' => $student->student_id,
            'fee_id' => $fee->fee_id,
            // Assuming payment date is today for student payments
            'payment_date' => now(), 
            'payment_amount' => $validated['payment_amount'],
            'payment_type' => $validated['payment_type'],
            'remarks' => $validated['remarks'] . ' (Paid via Student Portal)',
        ]);

        return redirect()->route('student.dashboard')->with('success', 'Payment recorded successfully!');
    }
}
