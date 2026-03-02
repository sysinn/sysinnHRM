<?php

namespace App\Http\Controllers;

use App\Models\EmployeeDailyTask;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\EmployeeTaskDocument;
use App\Notifications\NewTaskAssigned;

class EmployeeDailyTaskController extends Controller
{
    // Display all employee daily tasks
    public function index(Request $request)
    {
       $query = EmployeeDailyTask::with('employee');

    if ($request->has('search') && $request->search !== null) {
        $search = $request->search;

        $query->whereHas('employee', function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%");
        })->orWhere('status', 'like', "%{$search}%");
    }

    $tasks = $query->latest()->get();

    return view('employee_daily_tasks.index', compact('tasks'));
    }

    // Show the form to create a new task
    public function create()
    {
        $employees = Employee::all();
        return view('employee_daily_tasks.create', compact('employees'));
    }

    // Store a newly created task in the database
    public function store(Request $request)
    {
       $validated =  $request->validate([
        'employee_id' => 'required|exists:employees,id',
        'task_subject' => 'required|string|max:255',
        'task_date' => 'required|date',
        'task_description' => 'required|string',
        'priority' => 'required|in:urgent,normal',
        'status' => 'required|in:pending,in_progress,completed',
        'related_documents.*' => 'file|mimes:pdf,jpg,jpeg,png,docx|max:2048'
        ]);
         $validated['assigned_by'] = auth()->id();
         //dd($validated);
        $employee = Employee::with('user')->findOrFail($validated['employee_id']);
        //dd($employee->user);
        $validated['user_id'] = $employee->user->id ?? null;

        $task = EmployeeDailyTask::create($validated);
       if ($request->hasFile('related_documents')) {
        foreach ($request->file('related_documents') as $file) {
            $path = $file->store('task_documents', 'public');
            EmployeeTaskDocument::create([
                'employee_daily_task_id' => $task->id,
                'file_path' => $path,
            ]);
        }

        $task = EmployeeDailyTask::create($validated);
        // Send notification to employee
        if ($employee->user) {
            $employee->user->notify(new NewTaskAssigned($task));
        }
    }

    return redirect()->route('employee-daily-tasks.index')->with('success', 'Task created successfully.');
  }

    // Show the form to edit an existing task
    public function edit(EmployeeDailyTask $employee_daily_task)
    {
        $employees = Employee::all();
        return view('employee_daily_tasks.edit', [
            'task' => $employee_daily_task,
            'employees' => $employees,
        ]);
    }
    
    public function update(Request $request, EmployeeDailyTask $employee_daily_task)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'task_date' => 'required|date',
            'task_description' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed',
        ]);
    
        $employee_daily_task->update($validated);
    
        return redirect()->route('employee-daily-tasks.index')->with('success', 'Task updated successfully!');
    }


    public function show(EmployeeDailyTask $employee_daily_task)
{
    $employee_daily_task->load('employee'); 
    return view('employee_daily_tasks.show', compact('employee_daily_task'));
}

    
public function updateStatus(Request $request, EmployeeDailyTask $task)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,in_progress,completed',
    ]);

    $task->status = $validated['status'];
    $task->save();

    return response()->json(['message' => 'Status updated successfully']);
}




}


