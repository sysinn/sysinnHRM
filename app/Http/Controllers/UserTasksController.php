<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDailyTask;
use App\Models\Employee;
use App\Models\EmployeeTaskDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTasksController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // web guard

        $users_tasks = EmployeeDailyTask::with('employee')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
        $assigned_tasks = EmployeeDailyTask::where('assigned_by', auth()->id())->get();

        return view('user_tasks.index', compact('users_tasks', 'assigned_tasks'));
    }

    public function create()
    {
        // list of employees to assign task
        $employees = Employee::all();

        return view('user_tasks.create', compact('employees'));
    }

    public function store(Request $request)
{
        $validated = $request->validate([
            'employee_id'        => 'required|exists:employees,id',
            'task_subject'       => 'required|string|max:255',
            'task_date'          => 'required|date',
            'task_description'   => 'required|string',
            'priority'           => 'required|in:urgent,normal',
            'status'             => 'required|in:pending,in_progress,completed',
            'related_documents.*'=> 'file|mimes:pdf,jpg,jpeg,png,docx|max:2048'
        ]);

        // who assigned the task
        $validated['assigned_by'] = auth()->id();

        // find employee → user mapping
        $employee = Employee::with('user')->findOrFail($validated['employee_id']);
        $validated['user_id'] = $employee->user->id ?? null;

        // create task
        $task = EmployeeDailyTask::create($validated);

        // upload documents
        if ($request->hasFile('related_documents')) {
            foreach ($request->file('related_documents') as $file) {
                $path = $file->store('task_documents', 'public');

                EmployeeTaskDocument::create([
                    'employee_daily_task_id' => $task->id,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()
            ->route('user.tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function show($id)
    {
      $user = Auth::user();

    $task = EmployeeDailyTask::with('employee')
        ->where('id', $id)
        ->where(function ($query) use ($user) {
            $query->where('user_id', $user->id)       // tasks assigned TO me
                  ->orWhere('assigned_by', $user->id); // tasks assigned BY me
        })
        ->firstOrFail();

    return view('user_tasks.show', compact('task'));
    }
}
