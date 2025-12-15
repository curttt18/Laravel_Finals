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
            'amount' => 'required|numeric|min:0.01|max:999999.99',
            'description' => 'nullable|string|max:1000',
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
            'amount' => 'required|numeric|min:0.01|max:999999.99',
            'description' => 'nullable|string|max:1000',
        ]);

        // Prevent changing amount if payments exist for this fee
        if ($fee->payments()->exists() && $validated['amount'] != $fee->amount) {
            return back()->withErrors(['amount' => 'Cannot change amount. Payments already exist for this fee.'])->withInput();
        }

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
        // Prevent deletion if payments exist
        if ($fee->payments()->exists()) {
            return redirect()->route('admin.fees.index')
                ->with('error', 'Cannot delete fee. Payment records exist for this fee type.');
        }

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
