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
    @include('layouts.sidebar')

    <main class="flex-1 p-6 bg-white">
        <div class="max-w-7xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans]">Payroll Management</h1>
                <a href="{{ route('payroll.create') }}"
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

            <div class="mt-5 overflow-x-auto bg-white">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">#</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Employee</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Basic Salary</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Allowances</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Deductions</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Net Salary</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Pay Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payrolls as $payroll)
                            <tr>
                                <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $payroll->employee->first_name ?? '' }} {{ $payroll->employee->last_name ?? '' }}
                                </td>
                                <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ number_format($payroll->basic_salary, 2) }}</td>
                                <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ number_format($payroll->allowances, 2) }}</td>
                                <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ number_format($payroll->deductions, 2) }}</td>
                                <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ number_format($payroll->net_salary, 2) }}</td>
                                <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">
                                    {{ \Carbon\Carbon::parse($payroll->pay_date)->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">
                                    No payroll records found.
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
