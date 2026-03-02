@extends('layouts.app')

@section('content')

<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content -->
    <main class="flex-1 p-8">
        <div class="max-w-3xl mx-auto">

            <!-- Page Heading -->
            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-gray-800">Create Announcement</h2>
                <p class="text-gray-500 text-sm mt-1">Fill in the details below to publish a new announcement.</p>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg shadow-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Card Form -->
            <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200">
                <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-600 mb-1">Title</label>
                        <input type="text" name="title" id="title"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>

                        <!-- Featured Image -->
                    <div>
                        <label for="featured_image" class="block text-sm font-semibold text-gray-600 mb-1">
                            Featured Image
                        </label>

                        <input type="file"
                            name="featured_image"
                            id="featured_image"
                            accept="image/*"
                            class="w-full border border-gray-300 rounded-lg shadow-sm
                                    focus:ring-blue-500 focus:border-blue-500 p-2">

                        <p class="text-xs text-gray-500 mt-1">
                            JPG, PNG, WEBP (Max 2MB)
                        </p>
                    </div>


                    <!-- Body -->
                    <div>
                        <label for="body" class="block text-sm font-semibold text-gray-600 mb-1">Body</label>
                        <textarea name="body" id="body" rows="5"
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  required></textarea>
                    </div>

                    <!-- Publish Date -->
                    <div>
                        <label for="publish_date" class="block text-sm font-semibold text-gray-600 mb-1">Publish Date</label>
                        <input type="date" name="publish_date" id="publish_date"
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Active Checkbox -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked
                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label class="ml-2 text-sm text-gray-700 font-medium">Active</label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 transition text-white font-medium py-2.5 rounded-lg shadow-md">
                            Submit Announcement
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</div>

@endsection
