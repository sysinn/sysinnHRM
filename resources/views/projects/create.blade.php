@extends('layouts.app')

@section('content')
<style>
    label {
        font-weight: 500;
        font-family: 'DM-sans';
    }
</style>

<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white py-5">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans] mb-6">
                {{ isset($project) ? 'Edit' : 'Create' }} Project
            </h1>

            <form action="{{ isset($project) ? route('projects.update', $project) : route('projects.store') }}" method="POST">
                @csrf
                @if(isset($project)) @method('PUT') @endif

                <div class="mb-4">
                    <label class="block mb-2">Project Name</label>
                    <input type="text" name="name" value="{{ old('name', $project->name ?? '') }}"
                           class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Description</label>
                    <textarea name="description"
                              class="border border-gray-300 rounded w-full p-2 h-32 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $project->description ?? '') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Status</label>
                    <select name="status"
                            class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['pending', 'ongoing', 'completed', 'on-hold'] as $status)
                            <option value="{{ $status }}" {{ old('status', $project->status ?? '') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $project->start_date ?? '') }}"
                           class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-4">
                    <label class="block mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $project->end_date ?? '') }}"
                           class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="mb-6">
                    <label class="block mb-2">Assign To</label>
                    <select name="assigned_to"
                            class="border border-gray-300 rounded w-full p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Select Employee --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ old('assigned_to', $project->assigned_to ?? '') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded text-sm font-medium">
                    {{ isset($project) ? 'Update Project' : 'Create Project' }}
                </button>
            </form>

        </div>
    </main>
</div>
@endsection
