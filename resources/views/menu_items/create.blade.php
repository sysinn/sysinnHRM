@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white p-8">
        <div class="max-w-3xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Add Menu Item</h1>
                <a href="{{ route('menu-items.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    ← Back
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('menu-items.store') }}" method="POST" class="space-y-5 bg-gray-50 p-6 rounded-lg shadow">
                @csrf

                <!-- Parent Menu -->
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Parent Menu</label>
                    <select name="parent_id" id="parent_id" class="w-full border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- None (Top Level) --</option>
                        @foreach($parents as $id => $label)
                            <option value="{{ $id }}" {{ old('parent_id') == $id ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Label -->
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700 mb-1">Label <span class="text-red-500">*</span></label>
                    <input type="text" name="label" id="label" value="{{ old('label') }}" class="w-full border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500" required>
                </div>

                <!-- Route -->
                <div>
                    <label for="route" class="block text-sm font-medium text-gray-700 mb-1">Route</label>
                    <input type="text" name="route" id="route" value="{{ old('route') }}" class="w-full border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icon</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon') }}" placeholder="e.g. fa fa-home" class="w-full border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Roles -->
                <div>
                    <label for="roles" class="block text-sm font-medium text-gray-700 mb-1">Roles</label>
                    <input type="text" name="roles" id="roles" value="{{ old('roles') }}" placeholder="Comma separated role IDs" class="w-full border-gray-300 rounded p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Submit -->
                <div class="pt-4">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        Save Menu Item
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
