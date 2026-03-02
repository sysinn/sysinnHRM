@extends('layouts.app')

@section('content')
<div class="flex md:w-[85%] w-full m-[2rem] m-auto  order-2 mb-6 md:flex-nowrap flex-wrap items-stretch min-h-[80vh]">
<div class="md:w-[45%] w-[100%] mx-auto mt-12">
     <img src="{{ asset('img/Logo.webp') }}" alt="Logo Photo" class='ml-[2rem]'>
    <div class="bg-white dark:bg-gray-800 p-[2rem] rounded-lg w-full mt-[5rem]">
        <h2 class="text-2xl text-[#1E1E1E] font-semibold text-gray-800 dark:text-white text-start">Sign In</h2>
        <p class='text-white font-[400] text-[14px] font-[DM-sans] leading-[25px] text-[#5C5C5C] mb-6'>Fill up the required fields to login to your account</p>
        @if ($errors->any())
            <div class="mb-4 text-red-600 bg-red-100 border border-red-300 rounded p-4 dark:bg-red-200 dark:text-red-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/userslogin') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-[#5F6377]">Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 outline-none rounded-[2px] dark:bg-gray-700 dark:text-white">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-[#5F6377]">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-[2px]  dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <button type="submit"
                        class="bg-[#0057D8]  text-white font-medium py-2 px-4 rounded-[10px] w-full">
                    Login
                </button>
            </div>
            <div class="mt-4 text-center">
                <span class='text-[#6C6C6C]'>Don't have an account?</span>
            <a href="{{ url('/usersregister') }}" class="text-blue-600 hover:underline dark:text-blue-400 font-[600]">
                 SignUp
            </a>
            </div>

        </form>
    </div>
</div>
<div class="image md:w-[55%] w-[100%] mx-auto md:block hidden  px-4 sm:px-6 lg:px-8 py-[2rem] gap-[20px] mt-12 bg-[#0057D8] flex flex-col items-center justify-center">
    <h2 class='font-[DM-sans] text-[32px] font-semibold leading-[1.3em] text-white'>Welcome Back to SYSINN HRM!</h2>
    <p class='text-white font-[400] text-[14px] font-[DM-sans] leading-[25px] text-center'>Log in now to continue streamlining your projects with <br>our hassle-free HRM system.</p>
    <img src="{{ asset('img/Login.webp') }}" alt="Login Photo" class='h-[250px] w-[100%]'>
    <p class='text-white font-[600] text-[14px] font-[DM-sans] leading-[25px] text-center'>Powered by SYSINN</p>
</div>
</div>
@endsection
