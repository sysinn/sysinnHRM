@extends('layouts.app')

@section('content')
<style>
    .form-input:focus {
        border-color: #0057D8;
        box-shadow: 0 0 0 3px rgba(0, 87, 216, 0.1);
    }
    .form-select:focus {
        border-color: #0057D8;
        box-shadow: 0 0 0 3px rgba(0, 87, 216, 0.1);
    }
</style>

<div class="flex min-h-screen bg-gray-50">
    @include('layouts.sidebar')

    <main class="flex-1 p-4 md:p-6">
        <div class="max-w-3xl mx-auto">
            
            <!-- Header -->
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('payroll.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Add New Payroll</h1>
                    <p class="text-gray-500 text-sm mt-1">Create a new payroll record for an employee</p>
                </div>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center gap-2 text-red-800 font-medium mb-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Please correct the following errors:
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <form action="{{ route('payroll.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Employee Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Employee <span class="text-red-500">*</span></label>
                        <select name="employee_id" required class="form-select w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#0057D8] focus:border-transparent transition-all">
                            <option value="">Select Employee</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->first_name }} {{ $emp->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Salary Details Section -->
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#0057D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Salary Details (PKR)
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Basic Salary -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Basic Salary <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">Rs.</span>
                                    <input type="number" name="basic_salary" required step="0.01" placeholder="0.00" 
                                        class="form-input w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                                </div>
                            </div>

                            <!-- Allowances -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Allowances</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">Rs.</span>
                                    <input type="number" name="allowances" step="0.01" placeholder="0.00" value="0"
                                        class="form-input w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                                </div>
                            </div>

                            <!-- Overtime Pay -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Overtime Pay</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">Rs.</span>
                                    <input type="number" name="overtime_pay" step="0.01" placeholder="0.00" value="0"
                                        class="form-input w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                                </div>
                            </div>

                            <!-- Bonus -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bonus</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">Rs.</span>
                                    <input type="number" name="bonus" step="0.01" placeholder="0.00" value="0"
                                        class="form-input w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                                </div>
                            </div>

                            <!-- Increment -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Increment</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">Rs.</span>
                                    <input type="number" name="increment" step="0.01" placeholder="0.00" value="0"
                                        class="form-input w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                                </div>
                            </div>

                            <!-- Increment Reason -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Increment Reason</label>
                                <input type="text" name="increment_reason" placeholder="e.g., Annual increment, Promotion"
                                    class="form-input w-full px-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                            </div>

                            <!-- Deductions -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Deductions</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">Rs.</span>
                                    <input type="number" name="deductions" step="0.01" placeholder="0.00" value="0"
                                        class="form-input w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                                </div>
                            </div>

                            <!-- Tax -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tax</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">Rs.</span>
                                    <input type="number" name="tax" step="0.01" placeholder="0.00" value="0"
                                        class="form-input w-full pl-12 pr-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Details Section -->
                    <div class="border-t border-gray-100 pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#0057D8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Payment Details
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Pay Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pay Date <span class="text-red-500">*</span></label>
                                <input type="date" name="pay_date" required 
                                    class="form-input w-full px-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                                <select name="payment_method" class="form-select w-full px-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                                    <option value="">Select Method</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>

                            <!-- Bank Account Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bank Account Number</label>
                                <input type="text" name="bank_account_number" placeholder="Enter account number"
                                    class="form-input w-full px-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                            </div>

                            <!-- Payment Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                                <select name="payment_status" class="form-select w-full px-4 py-2.5 border border-gray-200 rounded-lg transition-all">
                                    <option value="Pending">Pending</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Failed">Failed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="border-t border-gray-100 pt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                        <textarea name="remarks" rows="3" placeholder="Add any additional notes..." 
                            class="form-input w-full px-4 py-2.5 border border-gray-200 rounded-lg transition-all"></textarea>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a href="{{ route('payroll.index') }}" class="px-6 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-[#0057D8] text-white font-medium rounded-lg hover:bg-[#0047B8] transition-colors shadow-md">
                            Create Payroll
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection
