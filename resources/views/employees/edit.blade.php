@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    Edit Employee
                </h2>

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employees.update', $employee->id) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First Name -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">First Name</label>
                            <input type="text" name="first_name"
                                   value="{{ old('first_name', $employee->first_name) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Last Name</label>
                            <input type="text" name="last_name"
                                   value="{{ old('last_name', $employee->last_name) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $employee->email) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Phone</label>
                            <input type="text" name="phone"
                                   value="{{ old('phone', $employee->phone) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Position -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Position</label>
                            <input type="text" name="position"
                                   value="{{ old('position', $employee->position) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Department -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Department</label>
                            <select name="department_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Select Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}"
                                        @selected(old('department_id', $employee->department_id) == $dept->id)>
                                        {{ $dept->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Salary -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Salary</label>
                            <input type="number" step="0.01" name="salary"
                                   value="{{ old('salary', $employee->salary) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Hire Date -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Hire Date</label>
                            <input type="date" name="hired_at"
                                   value="{{ old('hired_at', $employee->hired_at ? \Carbon\Carbon::parse($employee->hired_at)->format('Y-m-d') : '') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Profile Picture -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Profile Picture</label>
                        <input type="file" name="profile_picture" accept="image/*"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-4 pt-4">
                        <a href="{{ route('employees.index') }}"
                           class="px-6 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                            Cancel
                        </a>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection
