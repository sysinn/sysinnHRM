<!-- @extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Add New Menu Item</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('menu-items.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold">Label</label>
            <input type="text" name="label" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Route Name</label>
            <input type="text" name="route" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-semibold">Icon (Heroicon name)</label>
            <input type="text" name="icon" class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Roles</label>
            @foreach($roles as $role)
                <label class="inline-flex items-center mr-4">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="mr-1">
                    {{ $role->name }}
                </label>
            @endforeach
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Save Menu Item
        </button>
    </form>
</div>
@endsection -->
