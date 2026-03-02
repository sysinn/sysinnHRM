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
    @include('layouts.sidebar')

    <main class="flex-1 p-6 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans]">Position Management</h1>
                <a href="{{ route('positions.create') }}"
                   class="bg-[#0057D8] text-white font-medium py-2 px-4 rounded-[6px] flex items-center gap-2">
                    <ion-icon name="add-circle-outline"></ion-icon>
                 <span class='text-[14px] font-[400] font-[DM-sans] text-white'>Add New</span>
                </a>
            </div>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto bg-white">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">#</th>
                            <th class="px-6 py-3 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Position Name</th>
                            <th class="px-6 py-3 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($positions as $position)
                            <tr>
                                <td class="px-6 py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">{{ $position->name }}</td>
                                <td class="px-6 py-4 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
                                    <a href="{{ route('positions.edit', $position) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('positions.destroy', $position) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline ml-2">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    No positions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
