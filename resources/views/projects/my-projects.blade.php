@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    @include('layouts.sidebar')

    <main class="flex-1 p-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <ion-icon name="briefcase-outline" class="text-blue-600 text-3xl"></ion-icon>
                My Projects
            </h1>

            @if($projects->count())
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg border border-gray-200">
                    <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="bg-blue-50 text-gray-700 uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-6 py-3">Project Name</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Start Date</th>
                                <th class="px-6 py-3">End Date</th>
                                <th class="px-6 py-3 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($projects as $project)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 font-medium text-gray-800">{{ $project->name }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'ongoing' => 'bg-blue-100 text-blue-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'on-hold' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$project->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $project->start_date ?? '—' }}</td>
                                    <td class="px-6 py-4">{{ $project->end_date ?? '—' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('projects.show', $project->id) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-lg text-xs font-medium hover:bg-blue-700 transition">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $projects->links() }}
                </div>
            @else
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <ion-icon name="alert-circle-outline" class="text-gray-400 text-5xl mb-2"></ion-icon>
                    <p class="text-gray-500 text-lg">No projects assigned to you.</p>
                </div>
            @endif
        </div>
    </main>
</div>

<!-- Ionicons -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@endsection
