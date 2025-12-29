<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacherController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Admin\FeeController as AdminFeeController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\GradeController as AdminGradeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ActivityLogController as AdminActivityLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Redirect to appropriate dashboard based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    return match($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'registrar' => redirect()->route('registrar.dashboard'),
        'cashier' => redirect()->route('cashier.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => redirect()->route('login'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Students CRUD
    Route::resource('students', AdminStudentController::class)->parameters(['students' => 'student:student_id']);
    
    // Teachers CRUD
    Route::resource('teachers', AdminTeacherController::class)->except(['show'])->parameters(['teachers' => 'teacher:teacher_id']);
    
    // Enrollments CRUD
    Route::resource('enrollments', AdminEnrollmentController::class)->except(['show'])->parameters(['enrollments' => 'enrollment:enrollment_id']);
    Route::post('/enrollments/{enrollment:enrollment_id}/approve', [AdminEnrollmentController::class, 'approve'])->name('enrollments.approve');
    
    // Fees CRUD
    Route::resource('fees', AdminFeeController::class)->except(['show'])->parameters(['fees' => 'fee:fee_id']);
    
    // Payments CRUD
    Route::resource('payments', AdminPaymentController::class)->except(['show'])->parameters(['payments' => 'payment:payment_id']);
    
    // Grades CRUD
    Route::resource('grades', AdminGradeController::class)->except(['show'])->parameters(['grades' => 'grade:grade_id']);
    
    // Users CRUD
    Route::resource('users', AdminUserController::class)->except(['show']);
    
    // Activity Logs
    Route::get('/logs', [AdminActivityLogController::class, 'index'])->name('logs.index');
});

// Registrar Routes (student registration and enrollment management)
Route::middleware(['auth', 'role:registrar'])->prefix('registrar')->name('registrar.')->group(function () {
    Route::get('/dashboard', function () {
        $totalStudents = \App\Models\Student::count();
        $totalTeachers = \App\Models\Teacher::count();
        $pendingEnrollments = \App\Models\Enrollment::where('status', 'pending')->count();
        $enrolledStudents = \App\Models\Enrollment::where('status', 'enrolled')->count();
        
        $recentEnrollments = \App\Models\Enrollment::with('student')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get details of pending enrollments for preview
        $pendingEnrollmentsList = \App\Models\Enrollment::with('student')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('registrar.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'pendingEnrollments',
            'enrolledStudents',
            'recentEnrollments',
            'pendingEnrollmentsList'
        ));
    })->name('dashboard');
    
    // Student management
    Route::resource('students', AdminStudentController::class)->parameters(['students' => 'student:student_id']);
    
    // Teacher management (for assignment to grades)
    Route::resource('teachers', AdminTeacherController::class)->except(['show'])->parameters(['teachers' => 'teacher:teacher_id']);
    
    // Enrollment management (core registrar duty)
    Route::resource('enrollments', AdminEnrollmentController::class)->except(['show'])->parameters(['enrollments' => 'enrollment:enrollment_id']);
    Route::post('/enrollments/{enrollment:enrollment_id}/approve', [AdminEnrollmentController::class, 'approve'])->name('enrollments.approve');
    
    // Grades management (view/create student grades)
    Route::resource('grades', AdminGradeController::class)->except(['show'])->parameters(['grades' => 'grade:grade_id']);
    
    // Fees (view only for registrar)
    Route::get('/fees', [AdminFeeController::class, 'index'])->name('fees.index');
    
    // Payments (view only for registrar)
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
});

// Cashier Routes (view students, manage payments - NO DELETE)
Route::middleware(['auth', 'role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/dashboard', function () {
        $totalPaymentsToday = \App\Models\Payment::whereDate('created_at', today())->sum('payment_amount');
        $totalPaymentsMonth = \App\Models\Payment::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('payment_amount');
        $recentPayments = \App\Models\Payment::with(['student', 'fee'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $pendingStudents = \App\Models\Student::whereHas('enrollments', function ($q) {
            $q->where('status', 'enrolled');
        })->count();
        
        return view('cashier.dashboard', compact(
            'totalPaymentsToday',
            'totalPaymentsMonth',
            'recentPayments',
            'pendingStudents'
        ));
    })->name('dashboard');
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{student:student_id}', [AdminStudentController::class, 'show'])->name('students.show');
    // Cashier can create and edit payments, but NOT delete (for audit trail)
    Route::resource('payments', AdminPaymentController::class)
        ->except(['show', 'destroy'])
        ->parameters(['payments' => 'payment:payment_id']);
});

// Student Portal Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $student = $user->student;
        
        if (!$student) {
            return view('student.no-profile');
        }
        
        $enrollments = $student->enrollments()->orderBy('created_at', 'desc')->get();
        $payments = $student->payments()->with('fee')->orderBy('created_at', 'desc')->get();
        $grades = $student->grades()->with('teacher')->orderBy('created_at', 'desc')->get();
        
        return view('student.dashboard', compact('student', 'enrollments', 'payments', 'grades'));
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
