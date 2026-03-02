@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-white">
    {{-- Sidebar on the left --}}
    <div class="w-1/5 bg-white">
        @include('layouts.sidebar')
    </div>

    {{-- Main content area --}}
    <div class="w-4/5">
        <h1 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans] mb-[3rem]">All Users</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="text-left">
                    <tr>
                        <th class="px-4 py-2 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">ID</th>
                        <th class="px-4 py-2 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Name</th>
                        <th class="px-4 py-2 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Email</th>
                        <th class="px-4 py-2 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Roles</th>
                        <th class="px-4 py-2 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Email Verified</th>
                        <th class="px-4 py-2 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Profile Picture</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="text-center">
                        <td class="px-4 py-2 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">{{ $user->id }}</td>
                        <td class="px-4 py-2 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-4 py-2 text-[15px]  font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-4 py-2">
                            @foreach($user->roles as $role)
                                <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
                            {{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d') : 'Not Verified' }}
                        </td>
                        <td class="px-4 py-2 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="w-12 h-12 rounded-full mx-auto">
                            @else
                                <span class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px]">No Image</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
