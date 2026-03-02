@extends('layouts.app')

@section('content')
<!-- <style>
    a.bg-blue-600.hover\:bg-blue-700.text-white.font-medium.py-2.px-4.rounded {
        background-color: blue;
    }
    button.bg-blue-600.hover\:bg-blue-700.text-white.font-medium.py-2.px-4.rounded {
        background-color: blue !important;
    }
</style> -->

<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content -->
    <main class="flex-1 p-6 bg-white">
        <div class="max-w-4xl">

            <h1 class="text-2xl font-bold  mb-6">Employee Document Management</h1>

            <!-- Upload Document -->
            <div class="bg-white mb-10">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Upload Document</h3>

                <form action="{{ route('employees.documents.store', $employee->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Document Title</label>
                        <input type="text" name="title" required class="w-full mt-1 px-4 py-2 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Choose File</label>
                        <input type="file" name="document" required class="w-full mt-1 px-4 py-2 border rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Upload
                    </button>
                </form>
            </div>

            <!-- Uploaded Documents -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Uploaded Documents</h3>

                @if($employee->documents->count())
                    <ul class="list-disc list-inside text-gray-800 dark:text-gray-200 space-y-2">
                       @foreach ($employees as $employee)
    <a href="{{ route('employees.documents.index', $employee->id) }}"
       class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded inline-block mb-2">
       Upload Document for {{ $employee->first_name }}
    </a>
@endforeach

                    </ul>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">No documents uploaded yet.</p>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection
