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

// Registrar Routes (same as admin but without users/logs)
Route::middleware(['auth', 'role:registrar'])->prefix('registrar')->name('registrar.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('students', AdminStudentController::class)->parameters(['students' => 'student:student_id']);
    Route::resource('teachers', AdminTeacherController::class)->except(['show'])->parameters(['teachers' => 'teacher:teacher_id']);
    Route::resource('enrollments', AdminEnrollmentController::class)->except(['show'])->parameters(['enrollments' => 'enrollment:enrollment_id']);
    Route::post('/enrollments/{enrollment:enrollment_id}/approve', [AdminEnrollmentController::class, 'approve'])->name('enrollments.approve');
    Route::resource('fees', AdminFeeController::class)->except(['show'])->parameters(['fees' => 'fee:fee_id']);
    Route::resource('payments', AdminPaymentController::class)->except(['show'])->parameters(['payments' => 'payment:payment_id']);
    Route::resource('grades', AdminGradeController::class)->except(['show'])->parameters(['grades' => 'grade:grade_id']);
});

// Cashier Routes (view students, manage payments)
Route::middleware(['auth', 'role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/dashboard', function () {
        return view('cashier.dashboard');
    })->name('dashboard');
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{student:student_id}', [AdminStudentController::class, 'show'])->name('students.show');
    Route::resource('payments', AdminPaymentController::class)->parameters(['payments' => 'payment:payment_id']);
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
