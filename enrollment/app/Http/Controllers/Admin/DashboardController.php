<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $pendingEnrollments = Enrollment::where('status', 'pending')->count();
        $enrolledStudents = Enrollment::where('status', 'enrolled')->count();
        $totalPayments = Payment::sum('payment_amount');
        $totalUsers = User::count();

        $recentEnrollments = Enrollment::with('student')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentPayments = Payment::with(['student', 'fee'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'pendingEnrollments',
            'enrolledStudents',
            'totalPayments',
            'totalUsers',
            'recentEnrollments',
            'recentPayments'
        ));
    }
}
