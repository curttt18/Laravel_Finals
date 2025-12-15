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
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'contact_information' => 'required|string|max:255',
            'address' => 'required|string',
            'guardian_name' => 'required|string|max:255',
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
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'contact_information' => 'required|string|max:255',
            'address' => 'required|string',
            'guardian_name' => 'required|string|max:255',
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
        $name = $student->student_name;
        $student->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted student: ' . $name,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully!');
    }
}
