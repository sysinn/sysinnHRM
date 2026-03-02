@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white py-5">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-semibold mb-6">{{ $project->name }}</h1>

            <div class="bg-white shadow rounded-lg p-6 space-y-4">
                <p><strong>Client Name:</strong> {{ $project->client_name ?? '-' }}</p>
                <p><strong>Description:</strong> {{ $project->description ?? '-' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($project->status) }}</p>
                <p><strong>Priority:</strong> {{ ucfirst($project->priority) }}</p>
                <p><strong>Progress:</strong> {{ $project->progress }}%</p>
                <p><strong>Start Date:</strong> {{ $project->start_date ?? '-' }}</p>
                <p><strong>End Date:</strong> {{ $project->end_date ?? '-' }}</p>
                <p><strong>Assigned To:</strong>
                    {{ $project->assignedEmployee->first_name ?? 'Unassigned' }}
                    {{ $project->assignedEmployee->last_name ?? '' }}
                </p>
            </div>

            <div class="mt-6">
                <a href="{{ route('projects.index') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    Back to List
                </a>
            </div>
        </div>
    </main>
</div>
@endsection
