<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Grade::with(['student', 'teacher'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.grades.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::all();
        $teachers = Teacher::all();
        return view('admin.grades.create', compact('students', 'teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'teacher_id' => 'required|exists:teachers,teacher_id',
            'academic_period' => 'required|string|in:Q1,Q2,Q3,Q4',
            'cognitive_skills' => 'required|in:excellent,good,satisfactory,needs_improvement',
            'motor_skills' => 'required|in:excellent,good,satisfactory,needs_improvement',
            'social_skills' => 'required|in:excellent,good,satisfactory,needs_improvement',
            'emotional_dev' => 'required|in:excellent,good,satisfactory,needs_improvement',
            'behavior' => 'required|in:excellent,good,satisfactory,needs_improvement',
            'teacher_remarks' => 'nullable|string',
        ]);

        $grade = Grade::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Created grade for student ID: ' . $grade->student_id . ' (' . $grade->academic_period . ')',
        ]);

        return redirect()->route('admin.grades.index')->with('success', 'Grade created successfully!');
    }

    public function edit(Grade $grade)
    {
        $students = Student::all();
        $teachers = Teacher::all();
        return view('admin.grades.edit', compact('grade', 'students', 'teachers'));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'teacher_id' => 'required|exists:teachers,teacher_id',
            'academic_period' => 'required|string|in:Q1,Q2,Q3,Q4',
            'cognitive_skills' => 'required|in:excellent,good,satisfactory,needs_improvement',
            'motor_skills' => 'required|in:excellent,good,satisfactory,needs_improvement',
            'social_skills' => 'required|in:excellent,good,satisfactory,needs_improvement',
            'emotional_dev' => 'required|in:excellent,good,satisfactory,needs_improvement',
            'behavior' => 'required|in:excellent,good,satisfactory,needs_improvement',
            'teacher_remarks' => 'nullable|string',
        ]);

        $grade->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Updated grade ID: ' . $grade->grade_id,
        ]);

        return redirect()->route('admin.grades.index')->with('success', 'Grade updated successfully!');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted grade ID: ' . $grade->grade_id,
        ]);

        return redirect()->route('admin.grades.index')->with('success', 'Grade deleted successfully!');
    }
}
