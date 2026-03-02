@extends('layouts.app')

@section('content')
<style>
    a.bg-blue-600.hover\:bg-blue-700.text-white.font-medium.py-2.px-4.rounded {
        background-color: blue;
    }
    button.bg-blue-600.hover\:bg-blue-700.text-white.font-medium.py-2.px-4.rounded {
        background-color: blue !important;
    }
</style>

<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white"> @if(Auth::guard('employee')->check())
                 {{ Auth::guard('employee')->user()->first_name }}
                @endif Tasks </h1>
    
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Employee</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Subject</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Created At</th>
                    <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Actions</th> -->
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($users_tasks as $task)
                    <tr>
                        <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-nowrap">{{ $task->id }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-nowrap">{{ $task->employee->first_name }} {{ $task->employee->last_name }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-nowrap">{{ $task->task_date }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-nowrap">
                            <a href="{{ route('employee-daily-tasks.show', $task->id) }}">{{ $task->task_subject }}</a></td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-nowrap">{{ ucfirst($task->status) }}</td>
                        <td class="px-6 py-4 text-gray-900 dark:text-white whitespace-nowrap">{{ $task->created_at->format('d M Y, h:i A') }}</td>
                        <!-- <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('employee-daily-tasks.edit', $task) }}"
                               class="text-yellow-600 hover:underline dark:text-yellow-400">
                                Edit
                            </a>
                            <a href="{{ route('employee-daily-tasks.show', $task->id) }}"
                               class="text-yellow-600 hover:underline dark:text-yellow-400">
                                View
                            </a>
                        </td> -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No tasks found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</main>
</div>
@endsection
