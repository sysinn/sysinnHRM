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

<style>
/* Force DataTable background to white */
table.dataTable tbody tr {
    background-color: #ffffff !important;
}

/* Half-white / light zebra effect */
table.dataTable tbody tr:nth-child(even) {
    background-color: #f9fafb !important; /* very light gray (half white) */
}

/* Remove DataTables hover gray */
table.dataTable tbody tr:hover {
    background-color: #f1f5f9 !important; /* subtle hover */
}

/* Header background */
table.dataTable thead th {
    background-color: #ffffff !important;
}

/* Remove DataTables default borders/shadows */
table.dataTable.no-footer {
    border-bottom: none;
}
</style>


<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 py-3 px-1 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans]">Employees</h1>
                <a href="{{ route('employees.create') }}"
                   class="bg-[#0057D8] text-white font-medium py-2 px-4 rounded-[6px] flex items-center gap-2">
                   <ion-icon name="add-circle-outline"></ion-icon>
                   <span class='text-[14px] font-[400] font-[DM-sans] text-white'>Add New</span>
                </a>
            </div>

            <div class="overflow-x-auto md:overflow-x-visible bg-white dark:bg-gray-800 rounded-lg">
                <table id="employeeTable" class="min-w-full table-auto overflow-x-visible">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Start Date</th>
                        </tr>
                        <tr>
                            <th><input type="text" placeholder="Search Name" class="w-full px-2 py-1 text-sm border" /></th>
                            <th><input type="text" placeholder="Search Email" class="w-full px-2 py-1 text-sm border" /></th>
                            <th><input type="text" placeholder="Search Position" class="w-full px-2 py-1 text-sm border" /></th>
                            <th><input type="text" placeholder="Search Dept" class="w-full px-2 py-1 text-sm border" /></th>
                            <th><input type="text" placeholder="Search Date" class="w-full px-2 py-1 text-sm border" /></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td class="py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
                                    <a href="{{ route('employees.show', $employee) }}">{{ $employee->first_name }} {{ $employee->last_name }}</a>
                                </td>
                                <td class="py-4 text-[15px] font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
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
                                <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    No employees found.
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

@section('scripts')
<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(function () {
        let table = $('#employeeTable').DataTable({
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    $('input', column.header()).on('keyup change clear', function () {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    });
                });
            }
        });
    });
</script>
@endsection
