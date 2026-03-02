@extends('layouts.app')

@section('content')
@php
    $user = Auth::user();
    $userRoleIds = $user->roles->pluck('id')->toArray();
    $isGeneral = in_array(9, $userRoleIds) || in_array('general', array_map('strtolower', $user->roles->pluck('name')->toArray()));
    $isAdmin = !$isGeneral;
@endphp

<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content -->
    <main class="flex-1 bg-gradient-to-br from-gray-100 via-gray-50 to-gray-100 p-4 md:p-8">
        <div class="max-w-7xl mx-auto">

            <!-- Header -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 tracking-tight">
                        Welcome back, {{ $user->name }}
                    </h1>
                    <p class="text-gray-500 mt-1">
                        Here's what's happening in your system today
                    </p>
                </div>
            </div>

            <!-- Stats Grid - 3 columns for better alignment with 6 cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">

                <!-- Total Users (Admin/Super Admin only) -->
                @unless($isGeneral)
                <div class="group relative overflow-hidden rounded-2xl bg-white/70 backdrop-blur border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 to-indigo-600/30 opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Users</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2">
                                {{ $totalUsers }}
                            </p>
                        </div>
                        <div class="h-14 w-14 flex items-center justify-center rounded-xl bg-indigo-500 text-white text-2xl shadow-lg">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                @endunless

                <!-- Active Sessions -->
                <div class="group relative overflow-hidden rounded-2xl bg-white/70 backdrop-blur border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-400/20 to-green-600/30 opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Active Sessions</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2">45</p>
                        </div>
                        <div class="h-14 w-14 flex items-center justify-center rounded-xl bg-green-500 text-white text-2xl shadow-lg">
                            <i class="fas fa-signal"></i>
                        </div>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="group relative overflow-hidden rounded-2xl bg-white/70 backdrop-blur border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-400/20 to-yellow-600/30 opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pending Requests</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2">8</p>
                        </div>
                        <div class="h-14 w-14 flex items-center justify-center rounded-xl bg-yellow-500 text-white text-2xl shadow-lg">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>

                <!-- Employees (Admin/Super Admin only) -->
                @unless($isGeneral)
                <a href="{{ route('employees.index') }}"
                   class="group relative overflow-hidden rounded-2xl bg-white/70 backdrop-blur border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400/20 to-blue-600/30 opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Employees</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2">
                                {{ $employeeCount }}
                            </p>
                        </div>
                        <div class="h-14 w-14 flex items-center justify-center rounded-xl bg-blue-500 text-white text-2xl shadow-lg">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </div>
                </a>
                @endunless

                <!-- Projects -->
                <a href="{{ $isGeneral ? route('projects.my') : route('projects.index') }}"
                   class="group relative overflow-hidden rounded-2xl bg-white/70 backdrop-blur border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400/20 to-purple-600/30 opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">
                                {{ $isGeneral ? 'My Projects' : 'All Projects' }}
                            </p>
                            <p class="text-4xl font-bold text-gray-800 mt-2">
                                {{ $projectCount ?? $myProjectCount ?? 0 }}
                            </p>
                        </div>
                        <div class="h-14 w-14 flex items-center justify-center rounded-xl bg-purple-500 text-white text-2xl shadow-lg">
                            <i class="fas fa-briefcase"></i>
                        </div>
                    </div>
                </a>

                <!-- Notices -->
                <a href="#"
                   class="group relative overflow-hidden rounded-2xl bg-white/70 backdrop-blur border border-gray-200 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-400/20 to-pink-600/30 opacity-0 group-hover:opacity-100 transition"></div>
                    <div class="relative p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Notices</p>
                            <p class="text-4xl font-bold text-gray-800 mt-2">
                                {{ $noticeCount ?? 0 }}
                            </p>
                        </div>
                        <div class="h-14 w-14 flex items-center justify-center rounded-xl bg-pink-500 text-white text-2xl shadow-lg">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                    </div>
                </a>

            </div>

            <!-- Charts Section (Admin/Super Admin only) -->
            @if($isAdmin)
            <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="rounded-2xl bg-white/70 backdrop-blur border border-gray-200 shadow-sm p-4 md:p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">
                        Projects Overview
                    </h2>
                    <div class="relative h-64">
                        <canvas id="projectsChart"></canvas>
                    </div>
                </div>

                <div class="rounded-2xl bg-white/70 backdrop-blur border border-gray-200 shadow-sm p-4 md:p-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">
                        System Activity
                    </h2>
                    <div class="relative h-64">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </main>
</div>

<!-- FontAwesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if($isAdmin)
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ---------------- Projects Chart ---------------- */
    const projectsCtx = document.getElementById('projectsChart');
    if (projectsCtx) {
        new Chart(projectsCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    data: [
                        {{ $projectStats['jan'] ?? 4 }},
                        {{ $projectStats['feb'] ?? 6 }},
                        {{ $projectStats['mar'] ?? 3 }},
                        {{ $projectStats['apr'] ?? 8 }},
                        {{ $projectStats['may'] ?? 5 }},
                        {{ $projectStats['jun'] ?? 9 }}
                    ],
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { 
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    /* ---------------- System Activity ---------------- */
    const activityCtx = document.getElementById('activityChart');
    if (activityCtx) {
        new Chart(activityCtx, {
            type: 'bar',
            data: {
                labels: ['Users', 'Employees', 'Projects', 'Notices'],
                datasets: [{
                    data: [
                        {{ $totalUsers ?? 0 }},
                        {{ $employeeCount ?? 0 }},
                        {{ $projectCount ?? $myProjectCount ?? 0 }},
                        {{ $noticeCount ?? 0 }}
                    ],
                    borderWidth: 0,
                    borderRadius: 6,
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(147, 51, 234, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    y: { 
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

});
</script>
@endif

@endsection
