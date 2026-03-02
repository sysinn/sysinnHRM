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





<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content -->
    <main class="flex-1 bg-white py-5">

    

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">



    <div class="flex justify-between items-center mb-6">


        <form id="search-form" class="flex space-x-2">
            <input type="text" id="search-input" name="search"
                placeholder="Search by name or status"
                class="px-4 py-2 rounded-[2px] border border-[#B4B4B4]">
        </form>




        
        <a href="{{ route('employee-daily-tasks.create') }}"
           class="bg-[#0057D8] text-white font-medium py-2 px-4 rounded-[6px] flex items-center gap-2">
            <ion-icon name="add-circle-outline"></ion-icon>
            <span class='text-[14px] font-[400] font-[DM-sans] text-white'>Add New</span>
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white dark:bg-gray-800">
        <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans] mb-[2rem]">Management Tasks List</h1>
        <table class="min-w-full">
            <thead class="bg-white">
                <tr>
                    <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">#</th>
                    <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Employee</th>
                    <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Date</th>
                    <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Subject</th>
                    <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Status</th>
                    <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Created At</th>
                    <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Actions</th> -->
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                    <tr>
                        <td class="py-4 c">{{ $task->id }}</td>
                        <td class="py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ $task->employee->first_name }} {{ $task->employee->last_name }}</td>
                        <td class="py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ $task->task_date }}</td>
                        <td class="py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">
                            <a href="{{ route('employee-daily-tasks.show', $task) }}">{{ $task->task_subject }}</a></td>
                        <td class="py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ ucfirst($task->status) }}</td>
                        <td class="py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ $task->created_at->format('d M Y, h:i A') }}</td>
                       <!-- <td class="px-6 py-4 space-x-2">
    <a href="{{ route('employee-daily-tasks.show', $task) }}"
       class="text-blue-600 hover:underline dark:text-blue-400">
        Show
    </a>

    <a href="{{ route('employee-daily-tasks.edit', $task) }}"
       class="text-yellow-600 hover:underline dark:text-yellow-400">
        Edit
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
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let debounceTimer;

    $('#search-input').on('keyup', function () {
        clearTimeout(debounceTimer);
        let query = $(this).val();

        debounceTimer = setTimeout(function () {
            $.ajax({
                url: "{{ route('employee-daily-tasks.search') }}",
                type: "GET",
                data: { search: query },
                success: function (data) {
                    $('#task-table').html(data);
                }
            });
        }, 300);
    });
</script>
