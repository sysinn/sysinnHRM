@extends('layouts.app')

@section('content')
<style>
    a.bg-blue-600.hover\:bg-blue-700.text-white.font-medium.py-2.px-4.rounded {
    background-color: blue;
}
button.bg-blue-600.hover\:bg-blue-700.text-white.font-medium.py-2.px-4.rounded {
    background-color: blue!important;
}
</style>



<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('layouts.sidebar')
    <!-- Main content -->
    <main class="flex-1 py-3 px-1 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    
        <div class="flex justify-between items-center mb-6">
            

         
            <form id="search-form" class="mb-4">
                <div class="flex items-center space-x-2">
                    <input type="text" id="search-input" name="search"
                        placeholder="Search by name or email"
                        class="w-full sm:w-64 px-4 py-[.4rem] border border-[#B4B4B4] rounded-[2px] bg-white dark:bg-gray-700">
                </div>
            </form>


            <a href="{{ route('employees.create') }}"
               class="bg-[#0057D8] text-white font-medium py-2 px-4 rounded-[6px] flex items-center gap-2">
               <ion-icon name="add-circle-outline"></ion-icon>
                 <span class='text-[14px] font-[400] font-[DM-sans] text-white'>Add New</span>
            </a>
        </div>

        <div class="overflow-x-auto md:overflow-x-visible bg-white dark:bg-gray-800 rounded-lg">
            <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans] mb-[2rem]">Employees</h1>
            <table class="min-w-full table-auto overflow-x-visible">
                <thead>
                    <tr>
                        <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Name</th>
                        <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Email</th>
                        <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Position</th>
                        <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Department</th>
                        <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Start Date</th>
                        <!-- <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Actions</th> -->
                    </tr>
                </thead>
                <tbody class="mt-5">
                    @forelse($employees as $employee)
                        <tr>
                            <td class="py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
                                <a href="{{ route('employees.show', $employee) }}">{{ $employee->first_name }} {{ $employee->last_name }}</a>
                            </td>
                            
                            <td class="py-4 text-[15px]  font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
                                <a href="{{ route('employees.show', $employee) }}">{{ $employee->email }}</a>
                            </td>
                             <td class="py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
                                {{ $employee->position }}
                            </td>
                             <td class="py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
                                {{ $employee->department->name }}
                            </td>
                            <td class="py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
                                {{ $employee->hired_at }}
                            </td>
                           
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                No employees found.
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

        const query = $(this).val();

        debounceTimer = setTimeout(function () {
            $.ajax({
                url: "{{ route('employees.search') }}",
                type: "GET",
                data: { search: query },
                success: function (data) {
                    $('#employee-table').html(data);
                }
            });
        }, 300); // Delay to avoid too many requests
    });
</script>
