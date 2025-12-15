<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Fee;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['student', 'fee'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $students = Student::all();
        $fees = Fee::all();
        return view('admin.payments.create', compact('students', 'fees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'fee_id' => 'required|exists:fees,fee_id',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:full,installment',
            'remarks' => 'nullable|string',
        ]);

        $payment = Payment::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Created payment of ₱' . number_format($payment->payment_amount, 2) . ' for student ID: ' . $payment->student_id,
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment recorded successfully!');
    }

    public function edit(Payment $payment)
    {
        $students = Student::all();
        $fees = Fee::all();
        return view('admin.payments.edit', compact('payment', 'students', 'fees'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'fee_id' => 'required|exists:fees,fee_id',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric|min:0',
            'payment_type' => 'required|in:full,installment',
            'remarks' => 'nullable|string',
        ]);

        $payment->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Updated payment ID: ' . $payment->payment_id,
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted payment ID: ' . $payment->payment_id,
        ]);

        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully!');
    }
}
