<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Employee;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('assignedEmployee')->latest()->paginate(10);
       // $projects = Project::with('assignedUser')->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('projects.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|in:pending,ongoing,completed,on-hold',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        Project::create($request->all());
        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }


    public function show(Project $project)
{
    return view('projects.show', compact('project'));
}


    public function edit(Project $project)
    {
       $employees = Employee::all();
       return view('projects.edit', compact('project', 'employees'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string',
            'status' => 'required|in:pending,ongoing,completed,on-hold',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'assigned_to' => 'nullable|exists:employees,id',

        ]);
        $project->update($request->all());
        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
 public function myProjects()
{
    $employee = \App\Models\Employee::where('user_id', auth()->id())->first();
    if (!$employee) {
        return view('projects.my-projects', ['projects' => collect()]);
    }
    $projects = Project::with('assignedEmployee')
        ->where('assigned_to', $employee->id)
        ->latest()
        ->paginate(10);
    return view('projects.my-projects', compact('projects'));
}
}
