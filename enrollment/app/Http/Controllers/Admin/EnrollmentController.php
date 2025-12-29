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
    /**
     * Get the route prefix based on the current request path.
     * Returns 'admin', 'registrar', 'cashier', etc.
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
        $prefix = $this->getRoutePrefix();
        // All views are in admin folder, but we use the prefix for routing
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
        $enrollments = Enrollment::with('student')->orderBy('created_at', 'desc')->paginate(10);
        return view($this->viewPath('enrollments.index'), compact('enrollments'));
    }

    public function create()
    {
        $students = Student::all();
        return view($this->viewPath('enrollments.create'), compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,student_id',
                // Prevent duplicate enrollment for same student in same school year
                \Illuminate\Validation\Rule::unique('enrollments')->where(function ($query) use ($request) {
                    return $query->where('school_year', $request->school_year);
                }),
            ],
            'school_year' => ['required', 'string', 'max:9', 'regex:/^\d{4}-\d{4}$/'],
            'enrollment_date' => 'required|date|after_or_equal:2000-01-01|before_or_equal:today',
            'status' => 'required|in:pending,enrolled,withdrawn',
        ], [
            'student_id.unique' => 'This student is already enrolled for the selected school year.',
            'school_year.regex' => 'School year must be in format YYYY-YYYY (e.g., 2024-2025).',
            'enrollment_date.after_or_equal' => 'Enrollment date must be after year 2000.',
            'enrollment_date.before_or_equal' => 'Enrollment date cannot be in the future.',
        ]);

        $enrollment = Enrollment::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Created enrollment for student ID: ' . $enrollment->student_id,
        ]);

        return redirect()->route($this->routeName('enrollments.index'))->with('success', 'Enrollment created successfully!');
    }

    public function edit(Enrollment $enrollment)
    {
        $students = Student::all();
        return view($this->viewPath('enrollments.edit'), compact('enrollment', 'students'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                'exists:students,student_id',
                // Prevent duplicate enrollment for same student in same school year (ignore current)
                \Illuminate\Validation\Rule::unique('enrollments')->where(function ($query) use ($request) {
                    return $query->where('school_year', $request->school_year);
                })->ignore($enrollment->enrollment_id, 'enrollment_id'),
            ],
            'school_year' => ['required', 'string', 'max:9', 'regex:/^\d{4}-\d{4}$/'],
            'enrollment_date' => 'required|date|after_or_equal:2000-01-01|before_or_equal:today',
            'status' => 'required|in:pending,enrolled,withdrawn',
        ], [
            'student_id.unique' => 'This student is already enrolled for the selected school year.',
            'school_year.regex' => 'School year must be in format YYYY-YYYY (e.g., 2024-2025).',
            'enrollment_date.after_or_equal' => 'Enrollment date must be after year 2000.',
            'enrollment_date.before_or_equal' => 'Enrollment date cannot be in the future.',
        ]);

        $oldStatus = $enrollment->status;
        $enrollment->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Updated enrollment ID: ' . $enrollment->enrollment_id . ($oldStatus !== $validated['status'] ? ' (Status: ' . $oldStatus . ' → ' . $validated['status'] . ')' : ''),
        ]);

        return redirect()->route($this->routeName('enrollments.index'))->with('success', 'Enrollment updated successfully!');
    }

    public function approve(Enrollment $enrollment)
    {
        $enrollment->update(['status' => 'enrolled']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'approved',
            'description' => 'Approved enrollment for: ' . $enrollment->student->student_name,
        ]);

        return redirect()->route($this->routeName('enrollments.index'))->with('success', 'Enrollment approved successfully!');
    }

    public function destroy(Enrollment $enrollment)
    {
        // Prevent deletion of active enrollments
        if ($enrollment->status === 'enrolled') {
            return redirect()->route($this->routeName('enrollments.index'))
                ->with('error', 'Cannot delete an active enrollment. Withdraw the student first.');
        }

        $enrollment->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted enrollment ID: ' . $enrollment->enrollment_id,
        ]);

        return redirect()->route($this->routeName('enrollments.index'))->with('success', 'Enrollment deleted successfully!');
    }
}
