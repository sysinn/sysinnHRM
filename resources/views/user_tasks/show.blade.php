@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-2xl p-8">

                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    Task Details
                </h2>

                <!-- Grid Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                <!-- Assigned By -->
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Assigned By</label>
                    <input type="text"
                        value="{{ $task->assignedBy->name ?? 'N/A' }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                        readonly>
                </div>


                    <!-- Employee -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Employee</label>
                        <input type="text"
                               value="{{ $task->employee->first_name }} {{ $task->employee->last_name }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                               readonly>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Status</label>
                        <input type="text"
                               value="{{ ucwords(str_replace('_',' ', $task->status)) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed
                               text-{{ $task->status === 'completed' ? 'green-600' : ($task->status === 'pending' ? 'yellow-600' : 'blue-600') }}"
                               readonly>
                    </div>

                    <!-- Task Date -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Task Date</label>
                        <input type="date"
                               value="{{ \Carbon\Carbon::parse($task->task_date)->format('Y-m-d') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                               readonly>
                    </div>

                    <!-- Created At -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Created At</label>
                        <input type="text"
                               value="{{ $task->created_at->format('d M Y, h:i A') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                               readonly>
                    </div>

                </div>

                <!-- Subject -->
                <div class="mt-6">
                    <label class="block text-gray-700 font-semibold mb-1">Task Subject</label>
                    <input type="text"
                           value="{{ $task->task_subject }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                           readonly>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label class="block text-gray-700 font-semibold mb-1">Task Description</label>
                    <textarea rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed"
                              readonly>{{ $task->task_description }}</textarea>
                </div>

                <!-- Back Button -->
                <div class="mt-8">
                    <a href="{{ route('user-tasks.index') }}"
                       class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition-all duration-200">
                        ← Back to Tasks
                    </a>
                </div>

            </div>
        </div>
    </main>
</div>
@endsection
