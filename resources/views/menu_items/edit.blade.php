@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white p-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl font-bold mb-6">Edit Menu Item</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc pl-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('menu-items.update', $menu_item->id) }}" method="POST" class="bg-gray-50 p-6 rounded-lg shadow-md space-y-6">
                @csrf
                @method('PUT')

                <!-- Label -->
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700">Label</label>
                    <input type="text" name="label" id="label" value="{{ old('label', $menu_item->label) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm">
                </div>

                <!-- Route -->
                <div>
                    <label for="route" class="block text-sm font-medium text-gray-700">Route</label>
                    <input type="text" name="route" id="route" value="{{ old('route', $menu_item->route) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm">
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700">Icon (CSS class or SVG)</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon', $menu_item->icon) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm">
                </div>

                <!-- Parent -->
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Menu Item</label>
                    <select name="parent_id" id="parent_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm">
                        <option value="">None</option>
                        @foreach($parents as $id => $label)
                            <option value="{{ $id }}" {{ old('parent_id', $menu_item->parent_id) == $id ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Roles -->
                <div>
                    <label for="roles" class="block text-sm font-medium text-gray-700">Roles (comma separated)</label>
                    <input type="text" name="roles" id="roles" value="{{ old('roles', is_array($menu_item->roles) ? implode(',', $menu_item->roles) : $menu_item->roles) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 sm:text-sm">
                </div>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <a href="{{ route('menu-items.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-md shadow">
                        ← Back
                    </a>

                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow">
                        Update Menu Item
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
