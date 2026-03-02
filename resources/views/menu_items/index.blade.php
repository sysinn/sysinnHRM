@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-6">All Menu Items</h2>

    <!-- ✅ Add Menu Form -->
    <div class="mb-8 p-4 border rounded bg-gray-50">
        <h3 class="text-lg font-semibold mb-4">Add Menu Item</h3>

        <form action="{{ route('menu-items.store') }}" method="POST">
            @csrf

            @php
                // Use old input after validation failure or default to empty array
                $selectedRoles = old('roles', []);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium">Label</label>
                    <input type="text" name="label" class="w-full border px-3 py-2 rounded" value="{{ old('label') }}" required>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Route</label>
                    <input type="text" name="route" class="w-full border px-3 py-2 rounded" placeholder="e.g. employees.index" value="{{ old('route') }}">
                </div>

                <div>
                    <label class="block mb-1 font-medium">Icon (HTML Entity Code)</label>
                    <input type="text" name="icon" class="w-full border px-3 py-2 rounded" placeholder="e.g. &#128214;" value="{{ old('icon') }}" required>
                    <small class="text-gray-500">Use HTML entity like <code>&amp;#128214;</code> or <code>&amp;rarr;</code></small>
                </div>

                <div>
                    <label class="block mb-1 font-medium">Roles <span class="text-red-500">*</span></label>
                    <select name="roles[]" multiple class="w-full border px-3 py-2 rounded h-32">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ in_array($role->id, $selectedRoles) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-gray-500">Hold Ctrl (Windows) or Command (Mac) to select multiple roles</small>
                </div>
            </div>

            <div class="mt-4 text-right">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save
                </button>
            </div>
        </form>
    </div>

    <!-- ✅ Menu Items Table -->
    <table class="w-full border text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-2">Label</th>
                <th class="p-2">Route</th>
                <th class="p-2">Icon</th>
                <th class="p-2">Roles</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($menuItems as $item)
                <tr class="border-t">
                    <td class="p-2">{{ $item->label }}</td>
                    <td class="p-2">{{ $item->route }}</td>
                    <td class="p-2 text-xl">
                        @if ($item->icon)
                            <span aria-hidden="true">{!! $item->icon !!}</span>
                        @else
                            <span class="text-gray-400 italic">No icon</span>
                        @endif
                    </td>
                    <td class="p-2">
                        @foreach ($item->roles as $roleId)
                            @php $role = \App\Models\Role::find($roleId); @endphp
                            <span class="inline-block bg-gray-200 px-2 rounded text-xs">
                                {{ $role ? $role->name : 'Unknown' }}
                            </span>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
