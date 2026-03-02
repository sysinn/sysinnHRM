<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeDailyTaskController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserTasksController;
use App\Http\Controllers\UsersController;
use App\http\Controllers\UserDashboardController;
use App\Http\Controllers\EmployeeTaskCommentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RoleModuleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\EmployeeDocumentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ExperienceCertificateController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DailyWorkDoneController;
use App\Http\Controllers\PerformanceController;
Route::get('/', function () {
    return view('welcome');
});
Route::resource('departments', DepartmentController::class);

// Route::middleware(function ($request, $next) {
//     if (Auth::guard('employee')->check() || Auth::check()) {
//         return $next($request);
//     }
//     return redirect('/userslogin');
// })->group(function () {
//     Route::get('/UserTasks', [UserTasksController::class, 'index'])->name('user-tasks.index');
//     Route::get('/user-tasks/{id}', [UserTasksController::class, 'show'])->name('user.tasks.show');
// });

     Route::get('/login', function () {
        return redirect('/userslogin');
    })->name('login');

// Route to show tasks for user (role_id === 9)
// Route::get('/UserTasks', [UserTasksController::class, 'index'])
//      ->middleware('auth')
//      ->name('user-tasks.index');

Route::get('/UserTasks', [UserTasksController::class, 'index'])
    ->middleware('auth')
    ->name('user-tasks.index');

Route::get('/UserTasks/create', [UserTasksController::class, 'create'])
    ->middleware('auth')
    ->name('user-tasks.create');
// Route::get('/UserTasks/show', [UserTasksController::class, 'show'])
//     ->middleware('auth')
//     ->name('user-tasks.show');

Route::get('/UserTasks/{id}', [UserTasksController::class, 'show'])
    ->middleware('auth')
    ->name('user-tasks.show');
    
Route::post('/UserTasks', [UserTasksController::class, 'store'])
        ->name('user-tasks.store');


Route::get('/user-tasks/{id}', [UserTasksController::class, 'show'])
     ->middleware('auth')
     ->name('user.tasks.show');

Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
//Route::resource('employee-daily-tasks', EmployeeDailyTaskController::class);
Route::group([
    'middleware' => function ($request, $next) {
        if (Auth::guard('employee')->check() || Auth::check()) {
            return $next($request);
        }
        return redirect()->route('login')->with('error', 'Unauthorized access');
    }
], function () {
    Route::resource('employee-daily-tasks', EmployeeDailyTaskController::class);
});
// routes/web.php
use App\Http\Controllers\Auth\EmployeeAuthController;

Route::get('/employee/login', [EmployeeAuthController::class, 'showLoginForm'])->name('employee.login');
Route::post('/employee/login', [EmployeeAuthController::class, 'login'])->name('employee.login.submit');
Route::post('/employee/logout', [EmployeeAuthController::class, 'logout'])->name('employee.logout');
// Example protected route
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/employee/dashboard', function () {
        return view('employee.dashboard'); // create this blade file
    })->name('employee.dashboard');
});

// Admin auth routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminAuthController::class, 'showDashboard'])->name('admin.dashboard');
});

Route::get('/userslogin', [UsersController::class, 'showLoginForm'])->name('userslogin');
Route::post('/userslogin', [UsersController::class, 'login']);
Route::get('/usersregister', [UsersController::class, 'showRegisterForm'])->name('usersregister');
Route::post('/usersregister', [UsersController::class, 'register']);
Route::post('/logout', [UsersController::class, 'logout'])->name('logout');
Route::get('/auth/dashboard', function () {
    return view('auth.dashboard');
})->middleware('auth')->name('auth.dashboard');
Route::get('/auth/dashboard', [UserDashboardController::class, 'index'])->middleware('auth')->name('auth.dashboard');
Route::post('/task-comments', [EmployeeTaskCommentController::class, 'store'])->name('task-comments.store');

Route::middleware(['auth:employee'])->group(function () {
    Route::view('/employee/dashboard', 'employee.dashboard')->name('employee.dashboard');
});
Route::get('/dashboard', function () {
    if (auth()->check()) {
        if (auth()->user()->role_id == 9) {
            return redirect()->route('employee.dashboard');
        } else {
            return redirect()->route('auth.dashboard');
        }
    }
    return redirect()->route('userslogin');
})->middleware('auth')->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/role-modules/{role}/edit', [RoleModuleController::class, 'edit'])->name('role-modules.edit');
    Route::put('/role-modules/{role}', [RoleModuleController::class, 'update'])->name('role-modules.update');
});
Route::post('/tasks/{id}/share-documents', [EmployeeDailyTaskController::class, 'shareDocuments'])->name('employee-daily-tasks.share-documents');

Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');
});
    Route::post('/attendance/break', [AttendanceController::class, 'break'])->name('attendance.break');
use App\Http\Controllers\PayrollController;
Route::middleware(['auth'])->group(function () {
    Route::get('payroll/export', [PayrollController::class, 'export'])->name('payroll.export');
    Route::resource('payroll', PayrollController::class);
});
Route::middleware(['auth'])->group(function () {
    Route::resource('announcements', AnnouncementController::class);
});
//Route::resource('employee-documents', EmployeeDocumentController::class);
//Route::post('employees/{employee}/documents', [EmployeeDocumentController::class, 'store'])->name('employees.documents.store');
Route::middleware(['auth'])->group(function () {
    // Route for global document center (no employee ID required)
    Route::get('/employee-documents', [EmployeeDocumentController::class, 'listAll'])->name('employee-documents.index');
});
Route::middleware(['auth'])->group(function () {
    Route::get('employees/{employee}/documents', [EmployeeDocumentController::class, 'index'])->name('employees.documents.index');
    Route::post('employees/{employee}/documents', [EmployeeDocumentController::class, 'store'])->name('employees.documents.store');
    Route::get('employee-documents/{employeeDocument}/download', [EmployeeDocumentController::class, 'download'])->name('employee-documents.download');
    Route::get('employee-documents/{employeeDocument}/view', [EmployeeDocumentController::class, 'view'])->name('employee-documents.view');
    Route::delete('employee-documents/{employeeDocument}', [EmployeeDocumentController::class, 'destroy'])->name('employee-documents.destroy');
});
Route::resource('positions', App\Http\Controllers\PositionController::class);
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
Route::resource('menu-items', MenuItemController::class);
Route::get('/userslist', [UsersController::class, 'index'])->name('users.index');
Route::patch('/users/{user}/toggle-status', [UsersController::class, 'toggleStatus'])
    ->name('users.toggleStatus');

Route::middleware('auth')->group(function () {
    Route::get('/certificates', [ExperienceCertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/create', [ExperienceCertificateController::class, 'create'])->name('certificates.create');
    Route::post('/certificates', [ExperienceCertificateController::class, 'store'])->name('certificates.store');
    Route::get('/certificates/download/{id}', [ExperienceCertificateController::class, 'download'])->name('certificates.download');
});
Route::get('/employees/search', [EmployeeController::class, 'search'])->name('employees.search');
Route::get('/employee-daily-tasks/search', [EmployeeDailyTaskController::class, 'search'])->name('employee-daily-tasks.search');
Route::resource('projects', ProjectController::class);
//Route::resource('daily-work', \App\Http\Controllers\DailyWorkDoneController::class);
Route::resource('leaves', \App\Http\Controllers\LeaveController::class);

Route::middleware(['auth'])->group(function () {
    Route::resource('daily-work', DailyWorkDoneController::class);
<<<<<<< HEAD
    Route::get('daily-work/data', [DailyWorkDoneController::class, 'data'])->name('daily-work.data');
    Route::get('/admin/daily-work-status', [DailyWorkDoneController::class, 'adminStatus'])->name('daily-work.adminStatus');
=======
>>>>>>> 2ac17b5ed6aec8348ccae53244e4f31ced200780
});

Route::get('/check-role', function () {
    return auth()->user()?->toArray();
});
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/hr', function () {
    return '#'; 
})->name('#');
Route::get('/admin', function () {
    return '#'; 
})->name('#');
Route::get('/my-projects', [ProjectController::class, 'myProjects'])->name('projects.my');
Route::get('/users/create-quick', [UsersController::class, 'createQuick'])->name('users.createQuick');
Route::post('/users/store-quick', [UsersController::class, 'storeQuick'])->name('users.storeQuick');
Route::get('performances/summary', [PerformanceController::class, 'summary'])->name('performances.summary');
Route::resource('performances', PerformanceController::class);


use App\Http\Controllers\LeaveController;
Route::patch('/leaves/{leave}/status', [LeaveController::class, 'updateStatus'])->name('leaves.updateStatus');



Route::post('/notifications/read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return response()->json(['status' => 'success']);
})->name('notifications.read');



Route::post('/daily-work/{id}/status', 
    [DailyWorkDoneController::class, 'updateStatus']
)->name('daily-work.status');



// Employee Daily Tasks
Route::post('/employee-daily-tasks/{task}/status', [EmployeeDailyTaskController::class, 'updateStatus'])
<<<<<<< HEAD
    ->name('employee-daily-tasks.updateStatus');
=======
    ->name('employee-daily-tasks.updateStatus');
>>>>>>> 2ac17b5ed6aec8348ccae53244e4f31ced200780
