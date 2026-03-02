<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\Role;

class ModuleSeeder extends Seeder
{
    public function run()
    {
        // Create modules
        $modules = [
            ['label' => 'Tasks', 'route' => 'employee-daily-tasks.index'],
            ['label' => 'Employees', 'route' => 'employees.index'],
            ['label' => 'Departments', 'route' => 'departments.index'],
            ['label' => 'Payroll', 'route' => 'payroll.index'],
            ['label' => 'Attendance', 'route' => 'attendance.index'],
            ['label' => 'Announcements', 'route' => 'announcements.index'],
            ['label' => 'Employee Documents', 'route' => 'employee-documents.index'],
            ['label' => 'Experience Certificates', 'route' => 'certificates.index'],
            ['label' => 'Positions', 'route' => 'positions.index'],
            ['label' => 'Projects', 'route' => 'projects.index'],
            ['label' => 'Daily Work', 'route' => 'daily-work.index'],
            ['label' => 'Leaves', 'route' => 'leaves.index'],
            ['label' => 'Performance', 'route' => 'performances.index'],
            ['label' => 'Users', 'route' => 'users.index'],
            ['label' => 'Roles', 'route' => 'roles.index'],
            ['label' => 'Menu Items', 'route' => 'menu-items.index'],
        ];

        $moduleIds = [];
        foreach ($modules as $module) {
            $created = Module::firstOrCreate($module);
            $moduleIds[] = $created->id;
        }

        // Attach all modules to Admin role (role_id = 1)
        $adminRole = Role::find(1);
        $adminRole?->modules()->sync($moduleIds);

        // Attach only Tasks to Employee role (role_id = 9)
        $employeeRole = Role::find(9);
        $tasksModule = Module::where('label', 'Tasks')->first();
        $employeeRole?->modules()->sync([$tasksModule->id]);
    }
}
