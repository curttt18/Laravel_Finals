<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        
        if (!$student) {
            return view('student.no-profile');
        }
        
        $enrollments = $student->enrollments()->orderBy('created_at', 'desc')->get();
        $payments = $student->payments()->with('fee')->orderBy('created_at', 'desc')->get();
        $grades = $student->grades()->with('teacher')->orderBy('created_at', 'desc')->get();
        
        // Calculate outstanding fees
        $fees = Fee::all();
        $outstandingFees = $fees->map(function($fee) use ($student) {
            $paid = Payment::where('student_id', $student->student_id)
                ->where('fee_id', $fee->fee_id)
                ->sum('payment_amount');
            
            $remaining = $fee->amount - $paid;
            
            return (object) [
                'fee_id' => $fee->fee_id,
                'fee_name' => $fee->fee_name,
                'amount' => $fee->amount,
                'paid' => $paid,
                'remaining' => max(0, $remaining)
            ];
        })->filter(function($fee) {
            return $fee->remaining > 0;
        });
        
        return view('student.dashboard', compact('student', 'enrollments', 'payments', 'grades', 'outstandingFees'));
    }
}
