<?php

namespace App\Http\Controllers;

use App\Models\DailyWorkDone;
use App\Models\Department;
use App\Models\Project;
use App\Models\TaskType;
use App\Models\User;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class DailyWorkDoneController extends Controller
{
    public function data(Request $request)
    {
        $query = DailyWorkDone::with(['project', 'employee.user', 'employee.department']);

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('user_id')) {
            $query->whereHas('employee.user', function ($q) use ($request) {
                $q->where('id', $request->user_id);
            });
        }

        return DataTables::of($query)
            ->addColumn('date', function ($work) {
                return \Carbon\Carbon::parse($work->date)->format('d M Y');
            })
            ->addColumn('employee', function ($work) {
                return $work->employee->user->name ?? '-';
            })
            ->addColumn('team', function ($work) {
                return $work->employee->department->name ?? '-';
            })
            ->addColumn('project', function ($work) {
                return $work->project->name ?? '-';
            })
            ->addColumn('task', function ($work) {
                return $work->task_type;
            })
            ->addColumn('status', function ($work) {
                return ucfirst($work->status);
            })
            ->rawColumns(['employee', 'project'])
            ->make(true);
    }
   public function adminStatus(Request $request)
   {
    $user = auth()->user();

    // Check if user has admin role (role_id 1-6)
    $adminRoleIds = [1, 2, 3, 4, 5, 6];
    $hasAdminAccess = $user->roles->pluck('id')->filter(fn($id) => in_array($id, $adminRoleIds))->isNotEmpty();

    if (!$hasAdminAccess) {
        return redirect()->route('dashboard')->with('error', 'Unauthorized Access. You do not have permission to view this page.');
    }

    // Get selected date from request, default to today
    $selectedDate = $request->input('date', now()->toDateString());

    // Get all users with their employee data and selected date's work status
    $usersWithStatus = User::whereHas('employee')
        ->with('employee')
        ->orderBy('name')
        ->get()
        ->map(function($user) use ($selectedDate) {
            $workOnDate = $user->employee->dailyWorks()
                ->where('date', $selectedDate)
                ->first();
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'has_work_today' => !is_null($workOnDate),
                'last_entry' => $workOnDate ? $workOnDate->created_at : null,
                'work_detail' => $workOnDate
            ];
        });

    return view('daily_work.admin-status', compact('usersWithStatus', 'selectedDate'));
   }

   public function index(Request $request)
   {
    $user = auth()->user();

    // Check if user has admin role (role_id 1-5)
    $adminRoleIds = [1, 2, 3, 4, 5, 6];
    $hasAdminAccess = $user->roles->pluck('id')->filter(fn($id) => in_array($id, $adminRoleIds))->isNotEmpty();

    // Get selected user_id from request (for viewing specific user's work)
    $selectedUserId = $request->input('user_id');
    
    // Get selected date from request
    $selectedDate = $request->input('date', now()->toDateString());
    
    // Initialize selectedUser as null by default
    $selectedUser = null;

    // Get today's date
    $today = now()->toDateString();

    if ($hasAdminAccess) {
        // Admin users (role_id 1-5) see all users with their today's work status
        $usersWithStatus = User::whereHas('employee')
            ->with('employee')
            ->get()
            ->map(function($user) use ($today) {
                $hasWorkToday = $user->employee->dailyWorks()
                    ->where('date', $today)
                    ->exists();
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'has_work_today' => $hasWorkToday
                ];
            });

        // Get all works - filtered by user_id if provided
        $workQuery = DailyWorkDone::with(['department', 'project', 'employee.user']);
        
        // Filter by user_id if provided (admin viewing specific user's work)
        if ($selectedUserId) {
            $selectedUser = User::with('employee')->find($selectedUserId);
            if ($selectedUser && $selectedUser->employee) {
                $workQuery->where('employee_id', $selectedUser->employee->id);
            }
        }
        
        $allWorks = $workQuery->latest()->get();

        // TRELLO BOARD DATA (SAFE)
        $boardWorks = [
            'pending'      => $allWorks->where('status', 'pending'),
            'in-progress'  => $allWorks->where('status', 'in-progress'),
            'completed'    => $allWorks->where('status', 'completed'),
        ];

        // FullCalendar Events
        $calendarEvents = $allWorks->map(function ($work) {
            return [
                'id' => $work->id,
                'title' => $work->task_type . ' - ' . ($work->project->name ?? 'No Project'),
                'start' => $work->date,
                'url' => route('daily-work.show', $work->id),
                'backgroundColor' => $work->status === 'completed' ? '#22c55e' : ($work->status === 'in-progress' ? '#eab308' : '#3b82f6'),
                'borderColor' => $work->status === 'completed' ? '#22c55e' : ($work->status === 'in-progress' ? '#eab308' : '#3b82f6'),
                'extendedProps' => [
                    'status' => $work->status,
                    'detail' => $work->detail,
                    'employee' => $work->employee?->user?->name ?? 'Unknown',
                ]
            ];
        })->toArray();

        return view('daily_work.index', compact('allWorks', 'boardWorks', 'calendarEvents', 'usersWithStatus', 'selectedUserId', 'selectedUser', 'selectedDate'));
    }

    // Non-admin users - check if they have employee profile with department_id
    $employee = $user->employee;
    
    if ($employee) {
        $departmentId = $employee->department_id;
        
        // Department 1-8: Employees can see their tasks from all dates (no date filter)
        if ($departmentId >= 1 && $departmentId <= 8) {
            $employeeId = $employee->id;

            // Filter by user_id if provided (should match logged in employee)
            $workQuery = DailyWorkDone::with(['department', 'project', 'employee.user'])
                ->where('employee_id', $employeeId);
            
            // Don't filter by date - show all tasks including previous dates
            
            $allWorks = $workQuery->latest()->get();
            
            // Set selectedUser to current user for employees
            $selectedUser = $user;
            $selectedUserId = $user->id;
        } else {
            // Department 9 or other: Only show today's tasks
            $employeeId = $employee->id;

            // Filter by user_id if provided (should match logged in employee)
            $workQuery = DailyWorkDone::with(['department', 'project', 'employee.user'])
                ->where('employee_id', $employeeId);
            
            // Filter by date if provided (defaults to today)
            if ($selectedDate) {
                $workQuery->where('date', $selectedDate);
            }
            
            $allWorks = $workQuery->latest()->get();
            
            // Set selectedUser to current user for employees
            $selectedUser = $user;
            $selectedUserId = $user->id;
        }
    } else {
        // Other roles - Unauthorized
        return redirect()->route('dashboard')->with('error', 'Unauthorized Access. You do not have permission to view this page.');
    }

    // TRELLO BOARD DATA (SAFE)
    $boardWorks = [
        'pending'      => $allWorks->where('status', 'pending'),
        'in-progress'  => $allWorks->where('status', 'in-progress'),
        'completed'    => $allWorks->where('status', 'completed'),
    ];

    // FullCalendar Events
    $calendarEvents = $allWorks->map(function ($work) {
        return [
            'id' => $work->id,
            'title' => $work->task_type . ' - ' . ($work->project->name ?? 'No Project'),
            'start' => $work->date,
            'url' => route('daily-work.show', $work->id),
            'backgroundColor' => $work->status === 'completed' ? '#22c55e' : ($work->status === 'in-progress' ? '#eab308' : '#3b82f6'),
            'borderColor' => $work->status === 'completed' ? '#22c55e' : ($work->status === 'in-progress' ? '#eab308' : '#3b82f6'),
            'extendedProps' => [
                'status' => $work->status,
                'detail' => $work->detail,
                'employee' => $work->employee?->user?->name ?? 'Unknown',
            ]
        ];
    })->toArray();

    return view('daily_work.index', compact('allWorks', 'boardWorks', 'calendarEvents', 'selectedUserId', 'selectedUser', 'selectedDate'));
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        $taskTypes = TaskType::all();
        return view('daily_work.create', compact('projects', 'taskTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'task_type' => 'required|string|max:255',
            'detail' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $user = auth()->user();
        $employee = $user->employee;

        if (!$employee) {
            return back()->withErrors(['error' => 'No employee profile linked.']);
        }

        DailyWorkDone::create(array_merge($validated, [
            'employee_id' => $employee->id,
            'department_id' => $employee->department_id,
            'status' => 'pending'
        ]));

        return redirect()->route('daily-work.index')
            ->with('success', 'Daily work added.');
    }

    /**
     * Update the status of a work item.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in-progress,completed'
        ]);

        DailyWorkDone::where('id', $id)->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $work = DailyWorkDone::findOrFail($id);
        $departments = Department::all();
        $projects = Project::all();
        $taskTypes = TaskType::all();
        $work = DailyWorkDone::with(['employee.user', 'department', 'project'])->findOrFail($id);
        return view('daily_work.show', compact('work', 'departments', 'projects', 'taskTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $work = DailyWorkDone::findOrFail($id);
        $departments = Department::all();
        $projects = Project::all();
        $taskTypes = TaskType::all();
        return view('daily_work.edit', compact('work', 'departments', 'projects', 'taskTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'task_type' => 'required|string|max:255',
            'detail' => 'required|string',
            'project_id' => 'nullable|exists:projects,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:pending,in-progress,completed',
        ]);

        $work = DailyWorkDone::findOrFail($id);
        $work->update($validated);

        return redirect()->route('daily-work.index')
            ->with('success', 'Daily work updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $work = DailyWorkDone::findOrFail($id);
        $work->delete();

        return redirect()->route('daily-work.index')
            ->with('success', 'Daily work deleted.');
    }
}