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
    /**
     * Get the route prefix based on the current request path.
     */
    protected function getRoutePrefix(): string
    {
        $path = request()->path();
        $segments = explode('/', $path);
        return $segments[0] ?? 'admin';
    }

    /**
     * Get the view path with the correct prefix.
     */
    protected function viewPath(string $view): string
    {
        return "admin.{$view}";
    }

    /**
     * Get the route name with the correct prefix.
     */
    protected function routeName(string $route): string
    {
        return $this->getRoutePrefix() . '.' . $route;
    }

    public function index()
    {
        $payments = Payment::with(['student', 'fee'])->orderBy('created_at', 'desc')->paginate(10);
        return view($this->viewPath('payments.index'), compact('payments'));
    }

    public function create()
    {
        $students = Student::all();
        $fees = Fee::all();
        return view($this->viewPath('payments.create'), compact('students', 'fees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'fee_id' => 'required|exists:fees,fee_id',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric|min:0.01|max:999999.99',
            'payment_type' => 'required|in:full,installment',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Check for overpayment
        $fee = Fee::find($validated['fee_id']);
        $existingPayments = Payment::where('student_id', $validated['student_id'])
            ->where('fee_id', $validated['fee_id'])
            ->sum('payment_amount');
        $remainingBalance = $fee->amount - $existingPayments;

        if ($validated['payment_amount'] > $remainingBalance) {
            return back()->withErrors([
                'payment_amount' => 'Payment amount (₱' . number_format($validated['payment_amount'], 2) . ') exceeds remaining balance (₱' . number_format($remainingBalance, 2) . ').',
            ])->withInput();
        }

        $payment = Payment::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Created payment of ₱' . number_format($payment->payment_amount, 2) . ' for student ID: ' . $payment->student_id,
        ]);

        return redirect()->route($this->routeName('payments.index'))->with('success', 'Payment recorded successfully!');
    }

    public function edit(Payment $payment)
    {
        $students = Student::all();
        $fees = Fee::all();
        return view($this->viewPath('payments.edit'), compact('payment', 'students', 'fees'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'fee_id' => 'required|exists:fees,fee_id',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric|min:0.01|max:999999.99',
            'payment_type' => 'required|in:full,installment',
            'remarks' => 'nullable|string|max:500',
        ]);

        // Check for overpayment (exclude current payment from calculation)
        $fee = Fee::find($validated['fee_id']);
        $existingPayments = Payment::where('student_id', $validated['student_id'])
            ->where('fee_id', $validated['fee_id'])
            ->where('payment_id', '!=', $payment->payment_id)
            ->sum('payment_amount');
        $remainingBalance = $fee->amount - $existingPayments;

        if ($validated['payment_amount'] > $remainingBalance) {
            return back()->withErrors([
                'payment_amount' => 'Payment amount (₱' . number_format($validated['payment_amount'], 2) . ') exceeds remaining balance (₱' . number_format($remainingBalance, 2) . ').',
            ])->withInput();
        }

        // For full payment, amount must equal remaining balance
        if ($validated['payment_type'] === 'full' && $validated['payment_amount'] < $remainingBalance) {
            return back()->withErrors([
                'payment_amount' => 'Full payment requires the complete remaining balance of ₱' . number_format($remainingBalance, 2) . '. Select "Installment" for partial payments.',
            ])->withInput();
        }

        $payment->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Updated payment ID: ' . $payment->payment_id,
        ]);

        return redirect()->route($this->routeName('payments.index'))->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted payment ID: ' . $payment->payment_id,
        ]);

        return redirect()->route($this->routeName('payments.index'))->with('success', 'Payment deleted successfully!');
    }
    public function checkBalance(Student $student, Fee $fee)
    {
        $existingPayments = Payment::where('student_id', $student->student_id)
            ->where('fee_id', $fee->fee_id)
            ->sum('payment_amount');
            
        $remainingBalance = $fee->amount - $existingPayments;
        
        return response()->json([
            'fee_amount' => $fee->amount,
            'total_paid' => $existingPayments,
            'remaining_balance' => max(0, $remainingBalance)
        ]);
    }
}
