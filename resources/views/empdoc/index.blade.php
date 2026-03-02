@extends('layouts.app')

@section('content')
<style>
    .document-card {
        transition: all 0.3s ease;
    }
    .document-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>

<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content -->
    <main class="flex-1 p-6 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Employee Document Management</h1>
                <p class="text-gray-600 mt-1">Manage documents for: <span class="font-semibold text-blue-600">{{ $employee->first_name }} {{ $employee->last_name }}</span></p>
            </div>

            <!-- Upload Document Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    Upload New Document
                </h3>

                <form action="{{ route('employees.documents.store', $employee->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Document Type</label>
                            <select name="document_type" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Document Type</option>
                                @foreach($documentTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Document Title</label>
                            <input type="text" name="title" required placeholder="Enter document title" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Choose File</label>
                        <input type="file" name="document" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Allowed: PDF, DOC, DOCX, JPG, PNG (Max: 2MB)</p>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition-colors">
                        Upload Document
                    </button>
                </form>
            </div>

            <!-- Document Categories -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Uploaded Documents by Category</h3>
                
                @php
                    $categorizedDocs = [
                        'contract' => ['label' => 'Contract', 'icon' => 'file-contract', 'color' => 'blue', 'docs' => $employee->documents->where('document_type', 'contract')],
                        'offer_letter' => ['label' => 'Offer Letter', 'icon' => 'file-text', 'color' => 'green', 'docs' => $employee->documents->where('document_type', 'offer_letter')],
                        'cnic' => ['label' => 'CNIC', 'icon' => 'id-card', 'color' => 'purple', 'docs' => $employee->documents->where('document_type', 'cnic')],
                        'experience_certificate' => ['label' => 'Experience Certificate', 'icon' => 'award', 'color' => 'yellow', 'docs' => $employee->documents->where('document_type', 'experience_certificate')],
                        'other' => ['label' => 'Other Documents', 'icon' => 'folder', 'color' => 'gray', 'docs' => $employee->documents->where('document_type', 'other')]
                    ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categorizedDocs as $key => $category)
                        <div class="document-card bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="bg-{{ $category['color'] }}-100 px-4 py-3 border-b border-{{ $category['color'] }}-200">
                                <h4 class="font-semibold text-{{ $category['color'] }}-800 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $category['label'] }}
                                    <span class="ml-auto bg-{{ $category['color'] }}-200 text-{{ $category['color'] }}-800 text-xs font-bold px-2 py-1 rounded-full">
                                        {{ $category['docs']->count() }}
                                    </span>
                                </h4>
                            </div>
                            <div class="p-4">
                                @if($category['docs']->count() > 0)
                                    <ul class="space-y-3">
                                        @foreach($category['docs'] as $doc)
                                            <li class="flex items-center justify-between p-2 bg-gray-50 rounded-md hover:bg-gray-100 transition-colors">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $doc->title }}</p>
                                                    <p class="text-xs text-gray-500">{{ $doc->created_at->format('M d, Y') }}</p>
                                                </div>
                                                <div class="flex items-center space-x-2 ml-2">
                                                    <a href="{{ route('employee-documents.view', $doc->id) }}" target="_blank" class="text-blue-600 hover:text-blue-800 p-1" title="View">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('employee-documents.download', $doc->id) }}" class="text-green-600 hover:text-green-800 p-1" title="Download">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('employee-documents.destroy', $doc->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 p-1" title="Delete" onclick="return confirm('Are you sure you want to delete this document?')">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-gray-500 text-center py-4">No documents uploaded</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('employees.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Employees
                </a>
            </div>
        </div>
    </main>
</div>
@endsection
