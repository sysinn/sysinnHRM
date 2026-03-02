@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <div class="w-1/5 bg-white shadow-sm">
        @include('layouts.sidebar')
    </div>

    <!-- Main content -->
    <div class="w-4/5 p-8">
        <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-8 border border-gray-100">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Add New User</span>
            </h1>

            <form action="{{ route('users.storeQuick') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" required>
                </div>

                            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                    required>
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition"
                    required>
            </div>



                  <!-- Roles -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-1">Search Roles</label>
                        <input type="text" id="roleSearch"
                               placeholder="Type to search roles..."
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-3">

                        <div id="rolesList" class="space-y-2 max-h-48 overflow-y-auto border border-gray-300 p-3 rounded-lg">
                            @foreach($roles as $role)
                                <label class="flex items-center role-item">
                                    <input type="checkbox" name="role_id[]" value="{{ $role->id }}"
                                           class="mr-2"
                                           {{ is_array(old('role_id')) && in_array($role->id, old('role_id')) ? 'checked' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </label>
                            @endforeach
                        </div>
                    </div>


                <!-- Profile Picture -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                    <input type="file" name="profile_picture"
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg shadow-md transition transform hover:scale-[1.02]">
                        Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
