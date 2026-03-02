@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Daily Task</h2>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-200">
                        <ul class="list-disc pl-5 space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employee-daily-tasks.update', ['employee_daily_task' => $task->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Employee -->
                        <div>
                            <label for="employee_id" class="block text-gray-700 font-semibold mb-1">Employee</label>
                            <select name="employee_id" id="employee_id"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                    required>
                                <option value="">-- Select Employee --</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $task->employee_id == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Task Date -->
                        <div>
                            <label for="task_date" class="block text-gray-700 font-semibold mb-1">Task Date</label>
                            <input type="date" name="task_date" id="task_date"
                                   value="{{ old('task_date', $task->task_date) }}"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                   required>
                        </div>

                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-gray-700 font-semibold mb-1">Priority</label>
                            <select name="priority" id="priority"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                    required>
                                <option value="normal" {{ $task->priority == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="urgent" {{ $task->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-gray-700 font-semibold mb-1">Status</label>
                            <select name="status" id="status"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                    required>
                                <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>

                    <!-- Task Subject -->
                    <div class="mt-6">
                        <label for="task_subject" class="block text-gray-700 font-semibold mb-1">Task Subject</label>
                        <input type="text" name="task_subject" id="task_subject"
                               value="{{ old('task_subject', $task->task_subject) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                               required>
                    </div>

                    <!-- Task Description -->
                    <div class="mt-6">
                        <label for="task_description" class="block text-gray-700 font-semibold mb-1">Task Description</label>
                        <textarea name="task_description" id="task_description" rows="4"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                  required>{{ old('task_description', $task->task_description) }}</textarea>
                    </div>

                    <!-- Existing Documents -->
                    @if($task->documents->count())
                        <div class="mt-6">
                            <label class="block text-gray-700 font-semibold mb-2">Attached Documents</label>
                            <ul class="list-disc list-inside text-blue-600 text-sm space-y-1">
                                @foreach($task->documents as $document)
                                    <li>
                                        <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="underline hover:text-blue-800">
                                            {{ basename($document->file_path) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Upload New Documents -->
                    <div class="mt-6">
                        <label for="related_documents" class="block text-gray-700 font-semibold mb-1">Add More Documents (Optional)</label>
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
                            Update Task
                        </button>
                    </div>
                </form>

                <!-- Comment Section -->
                <div class="mt-10 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Add Comment</h3>

                    <form action="{{ route('task-comments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <input type="hidden" name="employee_daily_task_id" value="{{ $task->id }}">

                        <textarea name="comment" rows="3" required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500"
                                  placeholder="Write your comment..."></textarea>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Attach Document (optional)</label>
                            <input type="file" name="document"
                                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition-all duration-200">
                            Post Comment
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </main>
</div>
@endsection
