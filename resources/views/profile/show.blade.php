@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gradient-to-r from-gray-100 to-gray-200">
    @include('layouts.sidebar')

    <main class="flex-1 p-8">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white relative">
                <h2 class="text-3xl font-bold">My Profile</h2>
                <p class="mt-1 text-blue-100">Welcome back, {{ $user->name }}!</p>
                @if (session('success'))
                    <div class="absolute top-6 right-6 bg-green-100 text-green-800 p-3 rounded shadow">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="p-8 space-y-6">
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        @if ($user->employee->profile_picture)
                            <img src="{{ asset('storage/' . $user->employee->profile_picture) }}" alt="Profile Picture" class="w-32 h-32 object-cover rounded-full border-4 border-white shadow-lg hover:scale-105 transition-transform">
                        @else
                            <div class="w-32 h-32 flex items-center justify-center bg-gray-200 rounded-full border-4 border-white shadow-lg">
                                <span class="text-gray-500 text-lg">No Image</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-gray-500">{{ $user->employee->position }}</p>
                        <p class="text-gray-500">{{ $user->email }}</p>
                        <p class="text-gray-500">{{ $user->employee->phone }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                        <h4 class="text-gray-600 font-medium">Email</h4>
                        <p class="text-gray-800 mt-1">{{ $user->email }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                        <h4 class="text-gray-600 font-medium">Phone</h4>
                        <p class="text-gray-800 mt-1">{{ $user->employee->phone }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                        <h4 class="text-gray-600 font-medium">Position</h4>
                        <p class="text-gray-800 mt-1">{{ $user->employee->position }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg shadow hover:shadow-md transition-shadow">
                        <h4 class="text-gray-600 font-medium">Profile Picture</h4>
                        @if ($user->employee->profile_picture)
                            <p class="text-gray-800 mt-1">Uploaded</p>
                        @else
                            <p class="text-gray-800 mt-1">Not uploaded</p>
                        @endif
                    </div>
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('profile.edit') }}" class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition-all transform hover:-translate-y-1 hover:scale-105">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
