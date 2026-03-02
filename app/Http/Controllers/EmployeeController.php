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

    $employees = $query->latest()->get(); // Use ->paginate() if you want pagination

    return view('employees.index', compact('employees'));

       // $employees = Employee::all();
       // return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $roles = Role::all();
        $positions = Position::all();
        return view('employees.create', compact('departments', 'roles' ,'positions'));
         return view('certificates.create', compact('employees'));
       // return view('employees.create');
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

    // ✅ Handle file upload
    if ($request->hasFile('profile_picture')) {
        $path = $request->file('profile_picture')->store('employees', 'public');
        $validated['profile_picture'] = $path;
    }

    // ✅ Hash password once
    $hashedPassword = Hash::make($validated['password']);

    // ✅ Create user
    $user = User::create([
        'name' => $validated['first_name'] . ' ' . $validated['last_name'],
        'email' => $validated['email'],
        'password' => $hashedPassword,
        'role_id' => 9, // employee role
    ]);

    if ($request->has('role_id')) {
    $user->roles()->sync($request->role_id);
}

    // ✅ Create employee with same credentials
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
        $departments = Department::all(); // ✅ Fetch departments
        return view('employees.edit', compact('employee', 'departments'));
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
        ]);
        $employee->update($validated);
        return redirect()->route('employees.index')->with('success', 'Employee updated!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted!');
    }


        public function dashboard()
        {
            return view('employees.dashboard'); // Ensure this view exists
        }


    
}

