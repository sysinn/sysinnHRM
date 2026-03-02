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
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-6 bg-white">
        <div class="max-w-7xl">

            <h2 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans] mb-[2rem]">All Employee Documents</h2>
         @foreach ($documents as $doc)
    <tr>
        <td class="px-6 py-4 text-gray-900 dark:text-white">
            {{ $doc->employee->first_name }} {{ $doc->employee->last_name }}
            <br>
            <a href="{{ route('employees.documents.index', $doc->employee->id) }}"
               class="text-sm text-blue-500 underline">
               Upload New
            </a>
        </td>
        <!-- other columns... -->
    </tr>
@endforeach



            <!-- Document Table -->
            <div class="overflow-x-auto bg-white">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Employee</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Title</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">File</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Uploaded</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $doc)
                            <tr>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $doc->employee->first_name }} {{ $doc->employee->last_name }}
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $doc->title }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                                        View
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-gray-900 dark:text-white">
                                    {{ $doc->created_at->format('Y-m-d') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No documents found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $documents->links() }}
            </div>
        </div>
    </main>
</div>
@endsection
