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
Route::get('/UserTasks', [UserTasksController::class, 'index'])
     ->middleware('auth')
     ->name('user-tasks.index');

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
});

Route::resource('positions', App\Http\Controllers\PositionController::class);


Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');

Route::middleware(['auth'])->group(function () {
    Route::resource('menu-items', MenuItemController::class)->only(['index', 'create', 'store']);
});

Route::get('/userslist', [UsersController::class, 'index'])->name('users.index');
Route::middleware('auth')->group(function () {
    Route::get('/certificates', [ExperienceCertificateController::class, 'index'])->name('certificates.index');
    Route::get('/certificates/create', [ExperienceCertificateController::class, 'create'])->name('certificates.create');
    Route::post('/certificates', [ExperienceCertificateController::class, 'store'])->name('certificates.store');
    Route::get('/certificates/download/{id}', [ExperienceCertificateController::class, 'download'])->name('certificates.download');
});



Route::get('/employees/search', [EmployeeController::class, 'search'])->name('employees.search');
Route::get('/employee-daily-tasks/search', [EmployeeDailyTaskController::class, 'search'])->name('employee-daily-tasks.search');
