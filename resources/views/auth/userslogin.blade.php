@extends('layouts.app')

@section('content')
<div class="flex flex-wrap md:flex-nowrap w-full min-h-[90vh]">
    
    <!-- Left Section: Form -->
    <div class="md:w-[45%] w-full flex flex-col justify-center px-6 lg:px-12 py-12 bg-white dark:bg-gray-900">
        <div class="max-w-md mx-auto w-full">
            <div class="flex items-center mb-8">
                <img src="{{ asset('img/Logo.webp') }}" alt="Logo Photo" class="h-12">
            </div>

            <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Sign In</h2>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Fill in your credentials to access your account.</p>

                @if ($errors->any())
                    <div class="mb-4 text-red-600 bg-red-100 border border-red-300 rounded p-4 dark:bg-red-200 dark:text-red-800">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ url('/userslogin') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" id="email" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <input type="password" name="password" id="password" required
                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full bg-[#0057D8] hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition">
                            Login
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <span class="text-gray-500 dark:text-gray-400">Don't have an account?</span>
                    <a href="{{ url('/usersregister') }}" class="ml-1 text-blue-600 hover:underline dark:text-blue-400 font-semibold">
                        Sign Up
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Section: Welcome Message -->
    <div class="md:w-[55%] hidden md:flex flex-col justify-center items-center bg-gradient-to-br from-blue-600 via-blue-500 to-blue-700 text-white px-10 py-12">
        <div class="max-w-lg text-center">
            <h2 class="font-[DM-sans] text-4xl font-bold leading-tight mb-4">Welcome Back to Syssin HRM!</h2>
            <p class="mb-8 text-base opacity-90">
                Log in now to continue streamlining your projects with our hassle-free HRM system.
            </p>
            <img src="{{ asset('img/Login.webp') }}" alt="Login Illustration" class="rounded-lg shadow-xl mb-6 w-full max-w-sm mx-auto">
            <p class="font-semibold tracking-wide">Powered by Syssin</p>
        </div>
    </div>

</div>
@endsection
