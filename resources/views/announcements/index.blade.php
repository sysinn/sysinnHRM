@extends('layouts.app')

@section('content')

<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content -->
    <main class="flex-1 p-8">
        <div class="max-w-7xl mx-auto">

            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold text-gray-800">Announcements</h1>

                <a href="{{ route('announcements.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 transition text-white py-2.5 px-5 rounded-lg shadow-md">
                    <ion-icon name="add-circle-outline" class="text-xl"></ion-icon>
                    <span class="text-sm font-medium">Add New</span>
                </a>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table Container -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                <table class="min-w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Featured Image</th>

                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Publish Date</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Body</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                            @forelse ($announcements as $announcement)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $announcement->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $announcement->title }}</td>
                                <td class="px-6 py-4">
                                @if($announcement->featured_image)
                                    <img
                                        src="{{ asset('storage/' . $announcement->featured_image) }}"
                                        alt="Featured Image"
                                        class="w-20 h-14 object-cover rounded-lg border border-gray-200 shadow-sm"
                                    >
                                @else
                                    <span class="text-xs text-gray-400 italic">No image</span>
                                @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $announcement->publish_date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($announcement->body, 100) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-sm">
                                    No announcements found.
                                </td>
                            </tr>
                        @endforelse
                        
                    </tbody>
                </table>
            </div>

        </div>
    </main>
</div>

@endsection
