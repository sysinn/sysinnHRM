@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main content -->
    <main class="flex-1 bg-white py-5">

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Edit Profile</h2>

            @if (session('success'))
                <p class="text-green-600">{{ session('success') }}</p>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                           class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">New Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-2 border rounded dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Profile Picture -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-300">Profile Picture</label>
                    <input type="file" name="profile_picture" class="dark:text-white">
                    @error('profile_picture') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror

                    @if ($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" width="100" height="100"
                             class="mt-2 rounded border" alt="Profile Picture">
                    @endif
                </div>

                <!-- Submit -->
                <div>
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-200">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>

    </main>
</div>
@endsection
