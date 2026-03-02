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


<!-- ================= INLINE CALENDAR FILTER ================= -->
<div class="mb-8 grid grid-cols-1 md:grid-cols-4 gap-6">

    <!-- Calendar -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
        <h3 class="text-sm font-semibold mb-3 text-gray-700 dark:text-gray-200">
            📅 Filter by Date
        </h3>

        <input type="text" id="taskCalendar" class="hidden">

        <button
            id="clearDateFilter"
            class="mt-4 w-full text-sm text-blue-600 hover:underline"
        >
            Clear Filter
        </button>
    </div>

    <!-- Tables Area -->
    <div class="md:col-span-3">
        <!-- your existing tables stay here -->
    </div>

</div>

<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans]">
                    My Tasks
                </h1>

                <a href="{{ route('user-tasks.create') }}"
                   class="bg-[#0057D8] text-white font-medium py-2 px-4 rounded-[6px] flex items-center gap-2">
                    <ion-icon name="add-circle-outline"></ion-icon>
                    <span class="text-[14px] font-[400]">Add New</span>
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ================= RADIO FILTER ================= -->
            <div class="mb-6 flex gap-6 items-center">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="task_view" value="my_tasks" checked>
                    <span class="text-sm font-medium">Tasks Assigned To Me</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="task_view" value="assigned_tasks">
                    <span class="text-sm font-medium">Tasks I Assigned</span>
                </label>
            </div>

            <!-- ================= MY TASKS ================= -->
            <div id="myTasksSection">
                <h2 class="text-lg font-semibold mb-4">Tasks Assigned To Me</h2>

                <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Employee</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Date</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Subject</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Created At</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($users_tasks as $task)
                                <tr>
                                    <td class="px-6 py-4">{{ $task->id }}</td>
                                    <td class="px-6 py-4">
                                        {{ $task->employee->first_name }} {{ $task->employee->last_name }}
                                    </td>
                                    <td class="px-6 py-4">{{ $task->task_date }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('user-tasks.show', $task->id) }}"
                                           class="text-blue-600 hover:underline">
                                            {{ $task->task_subject }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">{{ ucfirst($task->status) }}</td>
                                    <td class="px-6 py-4">
                                        {{ $task->created_at->format('d M Y, h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No tasks assigned to you.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ================= ASSIGNED TASKS ================= -->
            <div id="assignedTasksSection" class="hidden">
                <h2 class="text-lg font-semibold mb-4">Tasks I Assigned</h2>

                <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium">#</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Employee</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Date</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Subject</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-medium">Created At</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($assigned_tasks as $task)
                                <tr>
                                    <td class="px-6 py-4">{{ $task->id }}</td>
                                    <td class="px-6 py-4">
                                        {{ $task->employee->first_name }} {{ $task->employee->last_name }}
                                    </td>
                                    <td class="px-6 py-4">{{ $task->task_date }}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('user-tasks.show', $task->id) }}"
                                           class="text-blue-600 hover:underline">
                                            {{ $task->task_subject }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">{{ ucfirst($task->status) }}</td>
                                    <td class="px-6 py-4">
                                        {{ $task->created_at->format('d M Y, h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No tasks assigned by you.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<!-- ================= JS TOGGLE ================= -->
<script>
    const radios = document.querySelectorAll('input[name="task_view"]');
    const myTasks = document.getElementById('myTasksSection');
    const assignedTasks = document.getElementById('assignedTasksSection');

    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'my_tasks') {
                myTasks.classList.remove('hidden');
                assignedTasks.classList.add('hidden');
            } else {
                myTasks.classList.add('hidden');
                assignedTasks.classList.remove('hidden');
            }
        });
    });
</script>




<script>
    const myTasks = document.getElementById('myTasksSection');
    const assignedTasks = document.getElementById('assignedTasksSection');
    const radios = document.querySelectorAll('input[name="task_view"]');

    let selectedDate = null;

    // ================= FLATPICKR INLINE =================
    flatpickr("#taskCalendar", {
        inline: true,
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr) {
            selectedDate = dateStr;
            filterByDate();
        }
    });

    document.getElementById('clearDateFilter').addEventListener('click', () => {
        selectedDate = null;
        filterByDate();
    });

    // ================= TOGGLE VIEW =================
    radios.forEach(radio => {
        radio.addEventListener('change', filterByDate);
    });

    // ================= FILTER FUNCTION =================
    function filterByDate() {
        document.querySelectorAll('tbody tr[data-date]').forEach(row => {
            const rowDate = row.getAttribute('data-date');

            if (!selectedDate || rowDate === selectedDate) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        });
    }
</script>

@endsection
