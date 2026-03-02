<?php

return [
    [
        'label' => 'Dashboard',
        'route' => 'auth.dashboard',
        'roles' => [1, 2],
        'icon' => 'home',
    ],
    [
        'label' => 'Department',
        'route' => 'departments.index',
        'roles' => [1, 2],
    ],
    [
        'label' => 'Employees',
        'route' => 'employees.index',
        'roles' => [1, 2],
    ],
    [
        'label' => 'Tasks',
        'route' => 'employee-daily-tasks.index',
        'roles' => [1, 2],
    ],
    [
        'label' => 'My Tasks',
        'route' => 'user-tasks.index',
        'roles' => [9,6],
    ],
    [
        'label' => 'Attendance & Time Tracking',
        'route' => 'attendance.index',
        'roles' => [1, 2, 9],
    ],
    [
        'label' => 'Users',
        'route' => '#',
        'roles' => [1, 2],
    ],
    [
        'label' => 'Payroll',
        'route' => 'payroll.index',
        'roles' => [1, 2, 3],
    ],
    [
        'label' => 'Announcements',
        'route' => 'announcements.index',
        'roles' => [1, 2, 9],
    ],
    [
        'label' => 'Documents',
        'route' => 'employee-documents.index',
        'roles' => [1, 2],
    ],
    [
        'label' => 'certificates',
        'route' => 'certificates.index',
        'roles' => [1, 2],
    ],
    [
        'label' => 'Position',
        'route' => 'positions.index',
        'roles' => [1, 2],
    ],
    [
        'label' => 'Roles',
        'route' => 'roles.index',
        'roles' => [1, 2],
    ],

    // ✅ Added Menu Items management page
    [
        'label' => 'Menu Items',
        'route' => 'menu-items.index',
        'roles' => [1], // Only Super Admin
        'icon' => 'cog', // Optional: use any Heroicon name like 'cog', 'wrench', 'adjustments-horizontal'
    ],
    [
        'label' => 'Users',
        'route' => 'users.index',
        'roles' => [1,2,9], // Only Super Admin
        'icon' => 'cog', // Optional: use any Heroicon name like 'cog', 'wrench', 'adjustments-horizontal'
    ],
];
