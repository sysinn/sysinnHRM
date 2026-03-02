@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    @include('layouts.sidebar')

    <main class="flex-1 p-6 bg-white">
        <div class="max-w-xl">
            <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans]">Edit Position</h1>

            <form action="{{ route('positions.update', $position) }}" method="POST" class="space-y-6">
                @csrf @method('PUT')
                <div>
                    <label for="name" class="block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Position Name</label>
                    <input type="text" name="name" id="name" value="{{ $position->name }}" required
                           class="mt-1 block w-full rounded-[2px] border border-[#B4B4B4]">
                </div>
                <div>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Update
                    </button>
                    <a href="{{ route('positions.index') }}"
                       class="ml-2 text-gray-600 hover:underline">Cancel</a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
