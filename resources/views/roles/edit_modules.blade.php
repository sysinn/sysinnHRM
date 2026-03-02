@extends('layouts.app')

@section('content')
@include('layouts.sidebar')

<main class="p-6">
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Assign Modules to Role: {{ $role->name }}</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('role-modules.update', $role->id) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                @foreach ($modules as $module)
                    <label class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="modules[]" value="{{ $module->id }}"
                               @if(in_array($module->id, $assigned)) checked @endif
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring focus:ring-indigo-300">
                        <span>{{ $module->label }}</span>
                    </label>
                @endforeach
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                    Save Modules
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
