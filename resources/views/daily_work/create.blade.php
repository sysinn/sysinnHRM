@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar')

    <main class="flex-1 p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-md rounded-2xl p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Add Daily Work</h2>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('daily-work.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Date</label>
                            <input type="date" name="date"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('date', date('Y-m-d')) }}" />
                        </div>

                        <!-- Department -->
                       <!-- Department (Readonly) -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Department</label>
                            @if(auth()->user()->roles->contains('id', 9) || auth()->user()->roles->contains('id', 6))
                            <input type="text" value="{{ auth()->user()->employee->department->name ?? '' }}" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-gray-100" readonly>
                            <input type="hidden" name="department_id" value="{{ auth()->user()->employee->department->id ?? '' }}">
                            @endif       
                      </div>

                     


                        <!-- Task Type (dynamic) -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Type of Task</label>
                            <select name="task_type" id="task_type"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">-- Select Department First --</option>
                            </select>
                        </div>

                        <!-- Project -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Project</label>
                            <select name="project_id"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach($projects as $proj)
                                    <option value="{{ $proj->id }}" @selected(old('project_id') == $proj->id)>
                                        {{ $proj->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Quantity</label>
                            <select name="quantity"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" @selected(old('quantity') == $i)>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-gray-700 font-semibold mb-1">Status</label>
                            <select name="status"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="pending" @selected(old('status')=='pending')>Pending</option>
                                <option value="in-progress" @selected(old('status')=='in-progress')>In Progress</option>
                                <option value="completed" @selected(old('status')=='completed')>Completed</option>
                            </select>
                        </div>
                    </div>

                    <!-- URL -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">URLs / Links</label>
                        <textarea name="url"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="2">{{ old('url') }}</textarea>
                    </div>

                    <!-- Detail -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Detail</label>
                        <textarea name="detail"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            rows="4">{{ old('detail') }}</textarea>
                    </div>

                    <div class="text-right">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg shadow-sm transition-all duration-200">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

{{-- ✅ Script kept INSIDE this section so it actually renders --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const taskTypes = @json($taskTypes);
    const taskTypeSelect = document.getElementById('task_type');

    function resetTaskType() {
        taskTypeSelect.innerHTML = '<option value="">-- Select Task Type --</option>';
    }

    function populateTaskTypes(deptId, preselectValue = null) {
        resetTaskType();
        if (!deptId) return;

        const filtered = taskTypes.filter(t => String(t.department_id) === String(deptId));

        if (filtered.length === 0) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = 'No task types for selected department';
            opt.disabled = true;
            taskTypeSelect.appendChild(opt);
            return;
        }

        filtered.forEach(t => {
            const opt = document.createElement('option');
            opt.value = t.name;
            opt.textContent = t.name;
            taskTypeSelect.appendChild(opt);
        });

        if (preselectValue) {
            taskTypeSelect.value = preselectValue;
        }
    }

    // For normal admin select
    const departmentSelect = document.getElementById('department_id');
    if (departmentSelect) {
        departmentSelect.addEventListener('change', function () {
            populateTaskTypes(this.value);
        });
    }

    // For employees, auto-populate task types on page load
    const employeeDeptId = "{{ auth()->user()->employee->department->id ?? '' }}";
    if (employeeDeptId) {
        populateTaskTypes(employeeDeptId, "{{ old('task_type') }}");
    }

    // Restore old values for admin
    const oldDept = "{{ old('department_id') }}";
    const oldTask = "{{ old('task_type') }}";
    if (oldDept && departmentSelect) {
        departmentSelect.value = oldDept;
        populateTaskTypes(oldDept, oldTask);
    }
});
</script>

@endsection
