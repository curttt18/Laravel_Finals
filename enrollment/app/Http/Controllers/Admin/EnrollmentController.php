<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with('student')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::all();
        return view('admin.enrollments.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'school_year' => 'required|string|max:20',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:pending,enrolled,withdrawn',
        ]);

        $enrollment = Enrollment::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Created enrollment for student ID: ' . $enrollment->student_id,
        ]);

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment created successfully!');
    }

    public function edit(Enrollment $enrollment)
    {
        $students = Student::all();
        return view('admin.enrollments.edit', compact('enrollment', 'students'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'school_year' => 'required|string|max:20',
            'enrollment_date' => 'required|date',
            'status' => 'required|in:pending,enrolled,withdrawn',
        ]);

        $oldStatus = $enrollment->status;
        $enrollment->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Updated enrollment ID: ' . $enrollment->enrollment_id . ($oldStatus !== $validated['status'] ? ' (Status: ' . $oldStatus . ' → ' . $validated['status'] . ')' : ''),
        ]);

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment updated successfully!');
    }

    public function approve(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'enrolled']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'approved',
            'description' => 'Approved enrollment for: ' . $enrollment->student->student_name,
        ]);

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment approved successfully!');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted enrollment ID: ' . $enrollment->enrollment_id,
        ]);

        return redirect()->route('admin.enrollments.index')->with('success', 'Enrollment deleted successfully!');
    }
}
