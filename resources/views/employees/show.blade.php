@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    Employee Detail
                </h2>

                <!-- Profile Picture -->
                <div class="flex flex-col items-center mb-6">
                    @if($employee->profile_picture)
                        <img src="{{ asset('storage/' . $employee->profile_picture) }}"
                             alt="Profile Picture"
                             class="w-32 h-32 object-cover rounded-full border-4 border-blue-500 shadow mb-3">
                    @else
                        <div class="w-32 h-32 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 mb-3">
                            No Image
                        </div>
                    @endif

                    <h3 class="text-lg font-semibold text-gray-800 capitalize">
                        {{ $employee->first_name }} {{ $employee->last_name }}
                    </h3>
                    <p class="text-gray-500 capitalize">
                        {{ $employee->position ?? 'N/A' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Email</label>
                        <input type="text"
                               value="{{ $employee->email }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                               readonly>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Phone</label>
                        <input type="text"
                               value="{{ $employee->phone ?? 'N/A' }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                               readonly>
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Department</label>
                        <input type="text"
                               value="{{ $employee->department->name ?? 'N/A' }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                               readonly>
                    </div>

                    <!-- Position -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Position</label>
                        <input type="text"
                               value="{{ $employee->position ?? 'N/A' }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                               readonly>
                    </div>

                    <!-- Salary -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Salary</label>
                        <input type="text"
                               value="{{ $employee->salary ? 'RS ' . number_format($employee->salary, 2) : 'N/A' }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                               readonly>
                    </div>

                    <!-- Hire Date -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Hire Date</label>
                        <input type="text"
                               value="{{ $employee->hired_at ? \Carbon\Carbon::parse($employee->hired_at)->format('d M Y') : 'N/A' }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                               readonly>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 text-right flex justify-end gap-4">
                    <a href="{{ route('employees.edit', $employee) }}"
                       class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition">
                        Edit
                    </a>

                    <a href="{{ route('employees.index') }}"
                       class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
