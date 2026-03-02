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
        <div class="max-w-7xl ">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans]">Announcements</h1>
                <a href="{{ route('announcements.create') }}"
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
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">#</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Title</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Publish Date</th>
                            <th class="text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px]">Body</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($announcements as $announcement)
                            <tr>
                                <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ $announcement->id }}</td>
                                <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ $announcement->title }}</td>
                                <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ $announcement->publish_date }}</td>
                                <td class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">{{ Str::limit($announcement->body, 100) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No announcements found.
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
