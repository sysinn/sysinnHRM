@extends('layouts.app')

@section('content')







<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content -->
    <main class="flex-1 p-6 bg-white">
      


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">
                Welcome, {{ Auth::user()->name }}!
            </h1>
        </div> -->

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Total Users</h3>
                <p class="text-gray-900 dark:text-white text-xl">123</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Active Sessions</h3>
                <p class="text-gray-900 dark:text-white text-xl">45</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Pending Requests</h3>
                <p class="text-gray-900 dark:text-white text-xl">8</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                    <a href="{{ route('employees.index') }}" class="hover:underline text-blue-600 dark:text-blue-400">
                        Employees
                    </a>
                </h3>
                <p class="text-gray-900 dark:text-white text-xl">Total Employees: {{ $employeeCount }}</p>
            </div>
        </div>
    </div>
    </main>
</div>










@endsection
