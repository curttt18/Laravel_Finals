<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
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
     * Get the view path.
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
        $teachers = Teacher::orderBy('created_at', 'desc')->paginate(10);
        return view($this->viewPath('teachers.index'), compact('teachers'));
    }

    public function create()
    {
        return view($this->viewPath('teachers.create'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_name' => 'required|string|max:255',
            'contact_information' => 'required|string|max:255',
        ]);

        $teacher = Teacher::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Created teacher: ' . $teacher->teacher_name,
        ]);

        return redirect()->route($this->routeName('teachers.index'))->with('success', 'Teacher created successfully!');
    }

    public function edit(Teacher $teacher)
    {
        return view($this->viewPath('teachers.edit'), compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'teacher_name' => 'required|string|max:255',
            'contact_information' => 'required|string|max:255',
        ]);

        $teacher->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Updated teacher: ' . $teacher->teacher_name,
        ]);

        return redirect()->route($this->routeName('teachers.index'))->with('success', 'Teacher updated successfully!');
    }

    public function destroy(Teacher $teacher)
    {
        // Prevent deletion if teacher has grade records
        if ($teacher->grades()->exists()) {
            return redirect()->route($this->routeName('teachers.index'))
                ->with('error', 'Cannot delete teacher. Grade records exist for this teacher.');
        }

        $name = $teacher->teacher_name;
        $teacher->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted teacher: ' . $name,
        ]);

        return redirect()->route($this->routeName('teachers.index'))->with('success', 'Teacher deleted successfully!');
    }
}
