@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 max-w-7xl mx-auto">

            <!-- Left: 4 Columns - Related Documents -->
            <div class="lg:col-span-4 space-y-6">
                @if($employee_daily_task->documents->count() || $employee_daily_task->comments->whereNotNull('document_path')->count())
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Related Documents</h3>
                        <ul class="list-disc list-inside text-blue-600 dark:text-blue-400 space-y-1 text-xs">
                            {{-- Task-level documents --}}
                            @foreach($employee_daily_task->documents as $document)
                                <li>
                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="underline hover:text-blue-800">
                                        {{ basename($document->file_path) }}
                                    </a>
                                </li>
                            @endforeach

                            {{-- Comment-level documents --}}
                            @foreach($employee_daily_task->comments as $comment)
                                @if($comment->document_path)
                                    <li>
                                        <a href="{{ asset('storage/' . $comment->document_path) }}" target="_blank" class="underline hover:text-blue-800">
                                            {{ basename($comment->document_path) }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Right: 8 Columns - Task Details -->
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 space-y-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Task Details</h3>

                    <a href="{{ route('employee-daily-tasks.edit', $employee_daily_task) }}" class="text-yellow-600 hover:underline dark:text-yellow-400">
                        Edit
                    </a>

                    <!-- Task Info -->
                    <div class="space-y-2 text-gray-900 dark:text-white">
                        <p><span class="font-semibold">Employee:</span> {{ $employee_daily_task->employee->first_name }} {{ $employee_daily_task->employee->last_name }}</p>
                        <p><span class="font-semibold">Assigned By:</span> {{ $employee_daily_task->assignedBy->name ?? 'N/A' }}</p>
                        <p><span class="font-semibold">Task Date:</span> {{ \Carbon\Carbon::parse($employee_daily_task->task_date)->format('F j, Y') }}</p>
                        <p>
                            <span class="font-semibold">Priority:</span>
                            <span class="font-semibold 
                                {{ strtolower($employee_daily_task->priority) === 'urgent' ? 'text-red-600' : '' }}
                                {{ strtolower($employee_daily_task->priority) === 'normal' ? 'text-yellow-500' : '' }}">
                                {{ ucfirst($employee_daily_task->priority) }}
                            </span>
                        </p>
                        <p>
                            <span class="font-semibold">Status:</span>
                            <span class="font-semibold 
                                {{ $employee_daily_task->status === 'completed' ? 'text-green-600' : '' }}
                                {{ $employee_daily_task->status === 'pending' ? 'text-yellow-500' : '' }}
                                {{ $employee_daily_task->status === 'in_progress' ? 'text-blue-600' : '' }}">
                                {{ ucwords(str_replace('_', ' ', $employee_daily_task->status)) }}
                            </span>
                        </p>
                    </div>

                    <!-- Subject & Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Task Subject</label>
                        <p class="text-gray-900 dark:text-white">{{ $employee_daily_task->task_subject }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Task Description</label>
                        <p class="text-gray-900 dark:text-white whitespace-pre-line">{{ $employee_daily_task->task_description }}</p>
                    </div>

                    <!-- Comments Section -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Comments</h3>
                        @forelse($employee_daily_task->comments as $comment)
                            <div class="mb-4 border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-900">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $comment->commentedBy->name ?? $comment->commentedBy->first_name ?? 'Unknown User' }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-gray-900 dark:text-white whitespace-pre-line">{{ $comment->comment }}</p>

                                @if ($comment->document_path)
                                    <p class="mt-2">
                                        <a href="{{ asset('storage/' . $comment->document_path) }}" target="_blank" class="text-blue-600 hover:underline dark:text-blue-400">
                                            📎 {{ basename($comment->document_path) }}
                                        </a>
                                    </p>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">No comments yet.</p>
                        @endforelse
                    </div>

                    <!-- Comment Form -->
                    @if($employee_daily_task->status !== 'completed')
                    <div>
                        <form action="{{ route('task-comments.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="employee_daily_task_id" value="{{ $employee_daily_task->id }}">

                            <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-2">Add Comment</label>
                            <textarea name="comment" rows="3" required
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-3 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

                            <div class="mt-4">
                                <label class="block text-sm font-semibold text-gray-600 dark:text-gray-300 mb-1">Attach Document (optional)</label>
                                <input type="file" name="document"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-white dark:bg-gray-800 dark:border-gray-600">
                            </div>

                            <div class="mt-4">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-all duration-200">
                                    Post Comment
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif

                    <!-- Back Button -->
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('employee-daily-tasks.index') }}"
                           class="text-blue-600 hover:underline dark:text-blue-400 inline-flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Back to Tasks</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>
@endsection
