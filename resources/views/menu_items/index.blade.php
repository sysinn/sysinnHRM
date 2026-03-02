@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 bg-white p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold">Menu Items</h1>
                <a href="{{ route('menu-items.create') }}" 
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    + Add Menu Item
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <table class="w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">Label</th>
                        <th class="p-2 border">Parent</th>
                        <th class="p-2 border">Route</th>
                        <th class="p-2 border">Icon</th>
                        <th class="p-2 border">Roles</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menuItems as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border">{{ $item->id }}</td>
                            <td class="p-2 border">{{ $item->label }}</td>
                            <td class="p-2 border">{{ $item->parent?->label ?? '-' }}</td>
                            <td class="p-2 border">{{ $item->route }}</td>
                            <td class="p-2 border">{{ $item->icon }}</td>
                            <td class="p-2 border">{{ $item->role_names ?? '-' }}</td>
                            <td class="p-2 border flex gap-2">
                                <a href="{{ route('menu-items.edit', $item) }}" 
                                   class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                    Edit
                                </a>
                                <form action="{{ route('menu-items.destroy', $item) }}" method="POST" 
                                      onsubmit="return confirm('Delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center p-4 text-gray-500">
                                No Menu Items Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $menuItems->links() }}
            </div>
        </div>
    </main>
</div>
@endsection
