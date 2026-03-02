@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Daily Task</h2>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200">
                        <ul class="list-disc pl-5 space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employee-daily-tasks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Employee -->
                        <div>
                            <label for="employee_id" class="block text-gray-700 font-semibold mb-1">Employee</label>
                            <select name="employee_id" id="employee_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                    required>
                                <option value="">-- Select Employee --</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Task Date -->
                        <div>
                            <label for="task_date" class="block text-gray-700 font-semibold mb-1">Task Date</label>
                            <input type="date" name="task_date" id="task_date"
                                   value="{{ old('task_date') }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-gray-700 font-semibold mb-1">Priority</label>
                            <select name="priority" id="priority"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                    required>
                                <option value="normal">Normal</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-gray-700 font-semibold mb-1">Status</label>
                            <select name="status" id="status"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                    required>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    <!-- Task Subject -->
                    <div class="mt-6">
                        <label for="task_subject" class="block text-gray-700 font-semibold mb-1">Task Subject</label>
                        <input type="text" name="task_subject" id="task_subject"
                               value="{{ old('task_subject') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>

                    <!-- Task Description -->
                    <div class="mt-6">
                        <label for="task_description" class="block text-gray-700 font-semibold mb-1">Task Description</label>
                        <textarea name="task_description" id="task_description" rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                  required>{{ old('task_description') }}</textarea>
                    </div>

                    <!-- Related Documents -->
                    <div class="mt-6">
                        <label for="related_documents" class="block text-gray-700 font-semibold mb-1">Attach Documents (Optional)</label>
                        <input type="file" name="related_documents[]" id="related_documents" multiple
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-blue-500">
                        <p class="text-sm text-gray-500 mt-1">You can upload multiple files (PDF, JPG, PNG, DOCX, etc.) — max 2MB each.</p>
                    </div>

                    <!-- Buttons -->
                    <div class="mt-6 flex justify-between">
                        <a href="{{ route('employee-daily-tasks.index') }}"
                           class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition-all duration-200">
                            Cancel
                        </a>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition-all duration-200">
                            Save Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection
