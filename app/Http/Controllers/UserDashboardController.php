<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employeeId = $user->employee ? $user->employee->id : null;
        $totalUsers = User::count();
        $employeeCount = Employee::count();
        $projectCount = Project::count();
        $ProjectCount = Project::count(); // Assuming you want to show total projects, not just the user's projects
       $myProjectCount = $employeeId
            ? Project::where('assigned_to', $employeeId)->count()
            : 0;
        return view('auth.dashboard', compact('totalUsers','employeeCount', 'projectCount','myProjectCount'));
    }
}
