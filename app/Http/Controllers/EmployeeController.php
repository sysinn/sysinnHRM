<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use App\Models\Position;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        $employees = $query->latest()->get(); 
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $roles = Role::all();
        $positions = Position::all();
        return view('employees.create', compact('departments', 'roles', 'positions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|unique:employees,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string',
            'position' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id',
            'salary' => 'nullable|numeric',
            'hired_at' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName(); 
            $path = $file->storeAs('employees', $filename, 'public'); 

            if (!Storage::disk('public')->exists($path)) {
                dd('File not saved!', $path);
            }

            $validated['profile_picture'] = $path;
        }

       
        $hashedPassword = Hash::make($validated['password']);

     
        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => $hashedPassword,
            'role_id' => 9, 
        ]);

        if ($request->has('role_id')) {
            $user->roles()->sync($request->role_id);
        }

       
        Employee::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => $hashedPassword,
            'phone' => $validated['phone'] ?? null,
            'position' => $validated['position'] ?? null,
            'department_id' => $validated['department_id'] ?? null,
            'salary' => $validated['salary'] ?? null,
            'hired_at' => $validated['hired_at'] ?? null,
            'profile_picture' => $validated['profile_picture'] ?? null,
            'user_id' => $user->id,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all(); 
        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(Request $request, Employee $employee)
{
    $validated = $request->validate([
        'first_name'       => 'required|string|max:255',
        'last_name'        => 'required|string|max:255',
        'email'            => 'required|email|unique:employees,email,' . $employee->id,
        'phone'            => 'nullable|string|max:20',
        'position'         => 'nullable|string|max:255',
        'department_id'    => 'nullable|exists:departments,id',
        'salary'           => 'nullable|numeric',
        'hired_at'         => 'nullable|date',
        'profile_picture'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);


    if ($request->hasFile('profile_picture')) {

      
        if ($employee->profile_picture && Storage::disk('public')->exists($employee->profile_picture)) {
            Storage::disk('public')->delete($employee->profile_picture);
        }

        $file = $request->file('profile_picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('employees', $filename, 'public');

        $validated['profile_picture'] = $path;
    }

   
    $employee->update($validated);

   
    if ($employee->user) {
        $employee->user->update([
            'name'  => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
        ]);
    }

    return redirect()
        ->route('employees.index')
        ->with('success', 'Employee updated successfully!');
}


    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted!');
    }

    public function dashboard()
    {
        return view('employees.dashboard'); 
    }
}
