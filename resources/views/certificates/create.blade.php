@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content -->
    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Generate Experience Certificate</h2>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                <form method="POST" action="{{ route('certificates.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 mb-1">Employee</label>
                        <select name="employee_id" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white" required>
                            @foreach($employees as $employee)
                               <option value="{{ $employee->id }}">
                                {{ $employee->first_name }} {{ $employee->last_name }}
                               </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 mb-1">Designation</label>
                        <input type="text" name="designation" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                        <input type="date" name="start_date" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                        <input type="date" name="end_date" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-300 mb-1">Remarks</label>
                        <textarea name="remarks" class="w-full border border-gray-300 dark:border-gray-600 p-2 rounded dark:bg-gray-700 dark:text-white" rows="3"></textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Generate
                    </button>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection
