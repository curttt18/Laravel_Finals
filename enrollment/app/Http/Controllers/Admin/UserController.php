<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $students = Student::whereDoesntHave('user')->get();
        return view('admin.users.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,registrar,cashier,student',
            'student_id' => $request->role === 'student' 
                ? 'required|exists:students,student_id|unique:users,student_id' 
                : 'nullable',
        ], [
            'student_id.required' => 'A student profile must be selected for student role users.',
            'student_id.unique' => 'This student already has a user account.',
        ]);

        // Normalize email to lowercase
        $validated['email'] = strtolower($validated['email']);
        $validated['password'] = Hash::make($validated['password']);
        
        // Clear student_id for non-student roles
        if ($validated['role'] !== 'student') {
            $validated['student_id'] = null;
        }

        $user = User::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Created user: ' . $user->name . ' (' . $user->role . ')',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        $students = Student::whereDoesntHave('user')->orWhere('student_id', $user->student_id)->get();
        return view('admin.users.edit', compact('user', 'students'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,registrar,cashier,student',
            'student_id' => $request->role === 'student' 
                ? 'required|exists:students,student_id|unique:users,student_id,' . $user->id 
                : 'nullable',
        ], [
            'student_id.required' => 'A student profile must be selected for student role users.',
            'student_id.unique' => 'This student already has a user account.',
        ]);

        // Prevent demoting the last admin
        if ($user->role === 'admin' && $validated['role'] !== 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->withErrors(['role' => 'Cannot change role. This is the last admin account.'])->withInput();
            }
        }

        // Normalize email to lowercase
        $validated['email'] = strtolower($validated['email']);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }
        
        // Clear student_id for non-student roles
        if ($validated['role'] !== 'student') {
            $validated['student_id'] = null;
        }

        $user->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Updated user: ' . $user->name,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot delete your own account!');
        }

        // Prevent deleting the last admin
        if ($user->role === 'admin') {
            $adminCount = User::where('role', 'admin')->count();
            if ($adminCount <= 1) {
                return redirect()->route('admin.users.index')->with('error', 'Cannot delete the last admin account!');
            }
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted user: ' . $name,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
