@extends('layouts.app')

@section('content')
<style>
    .payslip-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>

<div class="flex min-h-screen bg-gray-50">
    @include('layouts.sidebar')

    <main class="flex-1 p-4 md:p-6">
        <div class="max-w-4xl mx-auto">
            
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('payroll.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Payroll Details</h1>
                        <p class="text-gray-500 text-sm mt-1">View payslip information</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('payroll.edit', $payroll->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <button onclick="window.print()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print
                    </button>
                </div>
            </div>

            <!-- Employee Info Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                    <div class="h-16 w-16 rounded-full bg-[#0057D8] flex items-center justify-center text-white text-xl font-bold">
                        {{ substr($payroll->employee->first_name ?? 'E', 0, 1) }}{{ substr($payroll->employee->last_name ?? '', 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-800">
                            {{ $payroll->employee->first_name ?? '' }} {{ $payroll->employee->last_name ?? '' }}
                        </h2>
                        <p class="text-gray-500">Employee ID: {{ $payroll->employee->id ?? '-' }}</p>
                        <p class="text-gray-500">{{ $payroll->employee->email ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        @if($payroll->payment_status === 'Paid')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Paid
                            </span>
                        @elseif($payroll->payment_status === 'Pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></span>
                                Pending
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                Failed
                            </span>
                        @endif
                    </div>
                </div>

            </div>
            <!-- Salary Breakdown -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Earnings -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-green-50 px-6 py-4 border-b border-green-100">
                        <h3 class="text-lg font-semibold text-green-800 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Earnings
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Basic Salary</span>
                            <span class="font-semibold text-gray-800">Rs. {{ number_format($payroll->basic_salary, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Allowances</span>
                            <span class="font-semibold text-green-600">+Rs. {{ number_format($payroll->allowances, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Overtime Pay</span>
                            <span class="font-semibold text-green-600">+Rs. {{ number_format($payroll->overtime_pay, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Bonus</span>
                            <span class="font-semibold text-green-600">+Rs. {{ number_format($payroll->bonus, 0) }}</span>
                        </div>
                        @if($payroll->increment > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Increment {{ $payroll->increment_reason ? '(' . $payroll->increment_reason . ')' : '' }}</span>
                            <span class="font-semibold text-green-600">+Rs. {{ number_format($payroll->increment, 0) }}</span>
                        </div>
                        @endif
                        <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                            <span class="font-semibold text-gray-800">Total Earnings</span>
                            <span class="font-bold text-green-600 text-lg">
                                Rs. {{ number_format(($payroll->basic_salary + $payroll->allowances + $payroll->overtime_pay + $payroll->bonus + $payroll->increment), 0) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Deductions -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-red-50 px-6 py-4 border-b border-red-100">
                        <h3 class="text-lg font-semibold text-red-800 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            Deductions
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Deductions</span>
                            <span class="font-semibold text-red-600">-Rs. {{ number_format($payroll->deductions, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-semibold text-red-600">-Rs. {{ number_format($payroll->tax, 0) }}</span>
                        </div>
                        <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                            <span class="font-semibold text-gray-800">Total Deductions</span>
                            <span class="font-bold text-red-600 text-lg">
                                -Rs. {{ number_format(($payroll->deductions + $payroll->tax), 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Net Salary Card -->
            <div class="mt-6 bg-gradient-to-r from-[#0057D8] to-[#764ba2] rounded-2xl shadow-lg p-6 text-white">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-blue-100 text-sm">Net Salary</p>
                        <p class="text-3xl font-bold mt-1">Rs. {{ number_format($payroll->net_salary, 0) }}</p>
                    </div>
                    <div class="text-right text-blue-100">
                        <p>Pay Date: {{ \Carbon\Carbon::parse($payroll->pay_date)->format('d M Y') }}</p>
                        <p class="mt-1">Payment Method: {{ $payroll->payment_method ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Bank Account Number</p>
                        <p class="font-medium text-gray-800">{{ $payroll->bank_account_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Payment Status</p>
                        <p class="font-medium text-gray-800">{{ $payroll->payment_status }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Remarks</p>
                        <p class="font-medium text-gray-800">{{ $payroll->remarks ?? 'No remarks' }}</p>
                    </div>
                </div>
            </div>

            <!-- Delete Button -->
            <div class="mt-6 flex justify-end">
                <form action="{{ route('payroll.destroy', $payroll->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payroll record?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Record
                    </button>
                </form>
            </div>

        </div>
    </main>
</div>
@endsection
