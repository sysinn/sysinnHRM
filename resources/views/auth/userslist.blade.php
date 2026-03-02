@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    {{-- Sidebar --}}
    <div class="w-1/5 bg-white shadow-sm">
        @include('layouts.sidebar')
    </div>

    {{-- Main content --}}
    <div class="w-4/5 p-8">

        {{-- Header & Button --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 font-[DM-sans]">All Users</h1>
            <a href="{{ route('users.createQuick') }}"
               class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-5 py-2 rounded-lg shadow-md text-sm transition duration-200">
                + Add New User
            </a>
        </div>

        {{-- Users Table --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table id="usersTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Status</th>
                       
                        <th>Profile Picture</th>
                    </tr>

                    {{-- Search inputs --}}
                    <tr>
                        <th><input type="text" placeholder="Search Name" class="w-full px-2 py-1 text-xs border rounded"></th>
                        <th><input type="text" placeholder="Search Email" class="w-full px-2 py-1 text-xs border rounded"></th>
                        <th><input type="text" placeholder="Search Roles" class="w-full px-2 py-1 text-xs border rounded"></th>
                        <th><input type="text" placeholder="Search Status" class="w-full px-2 py-1 text-xs border rounded"></th>
                        <th><input type="text" placeholder="Search Verified" class="w-full px-2 py-1 text-xs border rounded"></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                {{ $user->name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $user->email }}
                            </td>

                            <td class="px-6 py-4">
                                @foreach($user->roles as $role)
                                    <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-1">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>

                         <td class="px-6 py-4 text-sm text-center">
                        <button
                            data-id="{{ $user->id }}"
                            class="toggle-status px-3 py-1 rounded-full text-xs font-semibold
                            {{ $user->isActive()
                                ? 'bg-green-100 text-green-700'
                                : 'bg-red-100 text-red-700' }}">
                            {{ $user->isActive() ? 'Active' : 'Inactive' }}
                        </button>
                    </td>


                          

                            <td class="px-6 py-4 text-center">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}"
                                         class="w-12 h-12 rounded-full border mx-auto">
                                @else
                                    <span class="text-xs text-gray-400">No Image</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function () {
    let table = $('#usersTable').DataTable({
        responsive: true,
        orderCellsTop: true,
        fixedHeader: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100]
    });

    // Column search
    $('#usersTable thead tr:eq(1) th').each(function (i) {
        $('input', this).on('keyup change', function () {
            if (table.column(i).search() !== this.value) {
                table.column(i).search(this.value).draw();
            }
        });
    });

    // ✅ TOGGLE STATUS (AJAX)
    $(document).on('click', '.toggle-status', function () {
        let button = $(this);
        let userId = button.data('id');

        $.ajax({
            url: `/users/${userId}/toggle-status`,
            type: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response.status === 'Active') {
                    button
                        .removeClass('bg-red-100 text-red-700')
                        .addClass('bg-green-100 text-green-700')
                        .text('Active');
                } else {
                    button
                        .removeClass('bg-green-100 text-green-700')
                        .addClass('bg-red-100 text-red-700')
                        .text('Inactive');
                }
            },
            error: function () {
                alert('Something went wrong!');
            }
        });
    });

});
</script>
@endsection
