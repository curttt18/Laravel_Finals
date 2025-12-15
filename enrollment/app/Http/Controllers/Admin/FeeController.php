<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fee;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.fees.index', compact('fees'));
    }

    public function create()
    {
        return view('admin.fees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fee_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $fee = Fee::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'description' => 'Created fee: ' . $fee->fee_name,
        ]);

        return redirect()->route('admin.fees.index')->with('success', 'Fee created successfully!');
    }

    public function edit(Fee $fee)
    {
        return view('admin.fees.edit', compact('fee'));
    }

    public function update(Request $request, Fee $fee)
    {
        $validated = $request->validate([
            'fee_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        $fee->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'description' => 'Updated fee: ' . $fee->fee_name,
        ]);

        return redirect()->route('admin.fees.index')->with('success', 'Fee updated successfully!');
    }

    public function destroy(Fee $fee)
    {
        $name = $fee->fee_name;
        $fee->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'description' => 'Deleted fee: ' . $name,
        ]);

        return redirect()->route('admin.fees.index')->with('success', 'Fee deleted successfully!');
    }
}
