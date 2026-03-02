<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->roles->contains('id', 9)) {
            // Logged-in user is an employee
            $employeeId = $user->employee?->id;

            if (!$employeeId) {
                return back()->withErrors(['error' => 'No employee profile linked to this user.']);
            }

            $leaves = Leave::with('employee')
                ->where('employee_id', $employeeId)
                ->latest()
                ->get();
        } else {
            // Admin/Superadmin: show all
            $leaves = Leave::with('employee')
                ->latest()
                ->get();
        }

        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->roles->contains('id', 9)) {
            // Employee: no need to select employee
            return view('leaves.create');
        }

        // Admin: can select employee
        $employees = Employee::all();
        return view('leaves.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:sick,casual,earned,unpaid',
            'reason' => 'nullable|string',
        ]);

        // Get employee_id based on role
        if ($user->roles->contains('id', 9)) {
            $employeeId = $user->employee?->id;

            if (!$employeeId) {
                return back()->withErrors(['error' => 'No employee profile linked to this user.']);
            }
        } else {
            // Admin: trust posted employee_id
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
            ]);
            $employeeId = $request->employee_id;
        }

        Leave::create([
            'employee_id' => $employeeId,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'type' => $validated['type'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted.');
    }


    public function updateStatus(Request $request, Leave $leave)
{
    $user = Auth::user();

    // Only admins (not employees) can update status
    if ($user->roles->contains('id', 9)) {
        return back()->withErrors(['error' => 'You are not authorized to change leave status.']);
    }

    $validated = $request->validate([
        'status' => 'required|in:pending,approved,rejected',
    ]);

    $leave->update([
        'status' => $validated['status'],
    ]);

    return back()->with('success', 'Leave status updated successfully.');
}

}
