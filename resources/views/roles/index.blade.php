@extends('layouts.app')

@section('content')
<div class="flex">
    {{-- ✅ Include sidebar from layouts --}}
    @include('layouts.sidebar') {{-- This loads resources/views/layouts/sidebar.blade.php --}}

    {{-- ✅ Main content --}}
    <div class="flex-1 p-6 bg-white">
        <div style="max-width: 800px;  padding: 20px; background: white; border-radius: 8px;">
            <h2 class="text-[20px] font-semibold text-[#1E1E1E] font-[DM-sans] mb-[2rem]">Manage Roles</h2>

            @if(session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif

            {{-- ✅ Add role form --}}
            <form method="POST" action="{{ route('roles.store') }}" class="mb-6">
                @csrf
                <div class='flex justify-between items-start gap-2'>
                      <input type="text" name="name" placeholder="Enter role name"
                       class="w-full border px-4 py-2 mb-2 rounded" required>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add</button>
                </div>
                
            </form>
                {{-- ✅ Pagination links --}}
<div class="mt-4">
    {{ $roles->links() }}
</div>
            {{-- ✅ Table of roles --}}
            <table class="w-full text-left mt-4">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Role Name</th>
                        <th class="px-4 py-2 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Users Count</th>
                        <th class="px-4 py-2 text-left text-[14px] font-[500] font-[DM-sans] text-[#9291A5] uppercase leading-[21px] whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td class="px-4 py-2 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">{{ $role->name }}</td>
                            <td class="px-4 py-2 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">{{ $role->users_count }}</td>
                            <td class="px-4 py-2 text-[15px] capitalize font-[400] font-[DM-sans] text-[#1E1E1E] leading-[21px] whitespace-nowrap">
                                <a href="{{ route('role-modules.edit', $role->id) }}"
                                   class="text-blue-600 hover:underline">Assign Modules</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">No roles found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
        </div>
    </div>
</div>
@endsection
