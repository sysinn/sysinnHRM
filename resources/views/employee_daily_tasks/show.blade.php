@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Employee Task Detail</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Employee -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Employee</label>
                        <input type="text" 
                               value="{{ $employee_daily_task->employee->first_name }} {{ $employee_daily_task->employee->last_name }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" 
                               readonly />
                    </div>

                    <!-- Assigned By -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Assigned By</label>
                        <input type="text" 
                               value="{{ $employee_daily_task->assignedBy->name ?? 'N/A' }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" 
                               readonly />
                    </div>

                    <!-- Task Date -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Task Date</label>
                        <input type="date" 
                               value="{{ \Carbon\Carbon::parse($employee_daily_task->task_date)->format('Y-m-d') }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" 
                               readonly />
                    </div>

                    <!-- Priority -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Priority</label>
                        <input type="text" 
                               value="{{ ucfirst($employee_daily_task->priority) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed text-{{ strtolower($employee_daily_task->priority) === 'urgent' ? 'red-600' : (strtolower($employee_daily_task->priority) === 'normal' ? 'yellow-600' : 'gray-800') }}" 
                               readonly />
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Status</label>
                        <input type="text" 
                               value="{{ ucwords(str_replace('_', ' ', $employee_daily_task->status)) }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed text-{{ $employee_daily_task->status === 'completed' ? 'green-600' : ($employee_daily_task->status === 'pending' ? 'yellow-600' : 'blue-600') }}" 
                               readonly />
                    </div>
                </div>

                <!-- Subject -->
                <div class="mt-6">
                    <label class="block text-gray-700 font-semibold mb-1">Task Subject</label>
                    <input type="text" 
                           value="{{ $employee_daily_task->task_subject }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" 
                           readonly />
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label class="block text-gray-700 font-semibold mb-1">Task Description</label>
                    <textarea class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" rows="4" readonly>{{ $employee_daily_task->task_description }}</textarea>
                </div>

                <!-- Related Documents -->
                @if($employee_daily_task->documents->count() || $employee_daily_task->comments->whereNotNull('document_path')->count())
                <div class="mt-6">
                    <label class="block text-gray-700 font-semibold mb-2">Related Documents</label>
                    <ul class="list-disc list-inside text-blue-600 space-y-1 text-sm">
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

                <!-- Comments -->
                <div class="mt-6">
                    <label class="block text-gray-700 font-semibold mb-2">Comments</label>
                    @forelse($employee_daily_task->comments as $comment)
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50 mb-3">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-semibold text-gray-700">
                                    {{ $comment->commentedBy->name ?? $comment->commentedBy->first_name ?? 'Unknown User' }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-800 text-sm whitespace-pre-line">{{ $comment->comment }}</p>
                            @if ($comment->document_path)
                                <p class="mt-2">
                                    <a href="{{ asset('storage/' . $comment->document_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                        📎 {{ basename($comment->document_path) }}
                                    </a>
                                </p>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No comments yet.</p>
                    @endforelse
                </div>

                <!-- Add Comment Form -->
                @if($employee_daily_task->status !== 'completed')
                <div class="mt-6 border-t border-gray-200 pt-4">
                    <form action="{{ route('task-comments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="employee_daily_task_id" value="{{ $employee_daily_task->id }}">

                        <label class="block text-gray-700 font-semibold mb-1">Add Comment</label>
                        <textarea name="comment" rows="3" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"></textarea>

                        <div class="mt-4">
                            <label class="block text-gray-700 font-semibold mb-1">Attach Document (optional)</label>
                            <input type="file" name="document"
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition-all duration-200">
                                Post Comment
                            </button>
                        </div>
                    </form>
                </div>
                @endif

                <!-- Back & Edit Buttons -->
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('employee-daily-tasks.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition-all duration-200">
                        Back
                    </a>

                    <a href="{{ route('employee-daily-tasks.edit', $employee_daily_task->id) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition-all duration-200">
                        Edit
                    </a>
                </div>

            </div>
        </div>
    </main>
</div>
@endsection
