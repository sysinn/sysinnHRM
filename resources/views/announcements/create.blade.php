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
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content -->
    <main class="flex-1 p-6 bg-white">
        <div class="max-w-4xl">
            <div class="mb-6">
                <h2 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans] mb-[2rem]">Create Announcement</h2>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('announcements.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="mb-1 block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Title</label>
                    <input type="text" name="title" id="title" class="w-full rounded-[2px] border border-[#B4B4B4]" required>
                </div>

                <div>
                    <label for="body" class="mb-1 block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Body</label>
                    <textarea name="body" id="body" rows="5" class="w-full rounded-[2px] border border-[#B4B4B4]" required></textarea>
                </div>

                <div>
                    <label for="publish_date" class="mb-1 block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">Publish Date</label>
                    <input type="date" name="publish_date" id="publish_date" class="w-full rounded-[2px] border border-[#B4B4B4]">
                </div>

                <div>
                    <label class="mb-1 block text-[14px] font-[500] text-[#5F6377] font-[DM-sans] leading-[20px]">
                        <input type="checkbox" name="is_active" value="1" checked class="mr-2">
                        Active
                    </label>
                </div>

                <div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
