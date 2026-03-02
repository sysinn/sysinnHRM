@extends('layouts.app')

@section('content')
<style>
    a.bg-blue-600.hover\:bg-blue-700.text-white.font-medium.py-2.px-4.rounded {
        background-color: blue;
    }
    button.bg-blue-600.hover\:bg-blue-700.text-white.font-medium.py-2.px-4.rounded {
        background-color: blue !important;
    }
</style>
<div class="flex min-h-screen">
    @include('layouts.sidebar')
    <!-- Main content -->
    <main class="flex-1 bg-white">
<div class="max-w-3xl px-4 py-4">
    <h2 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans] mb-[2rem] ml-5">Create New Daily Task</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employee-daily-tasks.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="employee_id" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Employee</label>
            <select name="employee_id" id="employee_id" class="w-full rounded-[2px] border border-[#B4B4B4] px-3 py-2 bg-white" required>
                <option value="">-- Select Employee --</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="task_date" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Task Date</label>
            <input type="date" name="task_date" id="task_date"
                   class="w-full rounded-[2px] border border-[#B4B4B4] px-3 py-2 bg-white"
                   required>
        </div>

        <div class="mb-4">
        <label for="task_subject" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Task Subject</label>
        <input type="text" name="task_subject" id="task_subject"
               class="w-full rounded-[2px] border border-[#B4B4B4] px-3 py-2 bg-white"
               required>
    </div>

        <div class="mb-4">
            <label for="task_description" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Task Description</label>
            <textarea name="task_description" id="task_description" rows="4"
                      class="w-full rounded-[2px] border border-[#B4B4B4] px-3 py-2 bg-white"
                      required></textarea>
        </div>


        <div class="mb-4">
        <label for="priority" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Priority</label>
        <select name="priority" id="priority"
                class="w-full rounded-[2px] border border-[#B4B4B4] px-3 py-2 bg-white"
                required>
            <option value="normal">Normal</option>
            <option value="urgent">Urgent</option>
        </select>
    </div>

        <div class="mb-6">
            <label for="status" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Status</label>
            <select name="status" id="status"
                    class="w-full rounded-[2px] border border-[#B4B4B4] px-3 py-2 bg-white"
                    required>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="mb-6">
    <label for="related_documents" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Related Documents</label>
    <input type="file" name="related_documents[]" id="related_documents" multiple
           class="w-full rounded px-3 py-2 bg-white">
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can upload multiple documents (PDF, JPG, PNG, DOCX, etc.). Max size: 2MB each.</p>
</div>


        <div class="flex items-center space-x-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                Save Task
            </button>
            <a href="{{ route('employee-daily-tasks.index') }}"
               class="bg-gray-400 hover:bg-gray-500 text-white font-medium py-2 px-4 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>
</main>
@endsection
