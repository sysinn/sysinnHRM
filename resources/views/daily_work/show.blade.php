@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Daily Work Detail</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Date</label>
                        <input type="date" 
       value="{{ \Carbon\Carbon::parse($work->date)->format('Y-m-d') }}" 
       class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" 
       readonly />

                    </div>

                    <!-- Department -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Department</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" disabled>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ $work->department_id == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach 
                        </select>
                    </div>

                    <!-- Task Type -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Task Type</label>
                        <input type="text" 
                               value="{{ $work->task_type }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" 
                               readonly />
                    </div>

                    <!-- Project -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Project</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" disabled>
                            @foreach($projects as $proj)
                                <option value="{{ $proj->id }}" {{ $work->project_id == $proj->id ? 'selected' : '' }}>
                                    {{ $proj->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Quantity</label>
                        <input type="text" 
                               value="{{ $work->quantity }}" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" 
                               readonly />
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Status</label>
                        <select class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" disabled>
                            <option value="pending" {{ $work->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in-progress" {{ $work->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ $work->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                </div>

                <!-- URL -->
                <div class="mt-6">
                    <label class="block text-gray-700 font-semibold mb-1">URLs / Links</label>
                    <textarea class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" rows="2" readonly>{{ $work->url }}</textarea>
                </div>

                <!-- Detail -->
                <div class="mt-6">
                    <label class="block text-gray-700 font-semibold mb-1">Detail</label>
                    <textarea class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100 cursor-not-allowed" rows="4" readonly>{{ $work->detail }}</textarea>
                </div>

                <!-- Back Button -->
                <div class="mt-6 text-right">
                    <a href="{{ route('daily-work.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition-all duration-200">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
