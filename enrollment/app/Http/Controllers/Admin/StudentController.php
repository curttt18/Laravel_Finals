<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today|after:1900-01-01',
            'gender' => 'required|in:male,female',
            'contact_information' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'guardian_name' => 'required|string|max:255',
        ], [
            'date_of_birth.before' => 'Date of birth must be before today.',
            'date_of_birth.after' => 'Please enter a valid date of birth.',
        ]);

        $student = Student::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Created student: ' . $student->student_name,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully!');
    }

    public function show(Student $student)
    {
        $student->load(['enrollments', 'payments.fee', 'grades.teacher']);
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today|after:1900-01-01',
            'gender' => 'required|in:male,female',
            'contact_information' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'guardian_name' => 'required|string|max:255',
        ], [
            'date_of_birth.before' => 'Date of birth must be before today.',
            'date_of_birth.after' => 'Please enter a valid date of birth.',
        ]);

        $student->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Updated student: ' . $student->student_name,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully!');
    }

    public function destroy(Student $student)
    {
        // Prevent deletion if student has payment records (financial audit trail)
        if ($student->payments()->exists()) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Cannot delete student. Payment records exist for this student.');
        }

        // Prevent deletion if student has grade records
        if ($student->grades()->exists()) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Cannot delete student. Grade records exist for this student.');
        }

        // Prevent deletion if student has active enrollments
        if ($student->enrollments()->where('status', 'enrolled')->exists()) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Cannot delete student. Student has active enrollments.');
        }

        // Prevent deletion if student has a user account
        if ($student->user()->exists()) {
            return redirect()->route('admin.students.index')
                ->with('error', 'Cannot delete student. A user account is linked to this student. Delete the user account first.');
        }

        $name = $student->student_name;
        
        // Delete pending/withdrawn enrollments first (safe to remove)
        $student->enrollments()->delete();
        
        $student->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted student: ' . $name,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully!');
    }
}
