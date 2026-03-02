@extends('layouts.app')

@section('content')
<style>
    input:focus{
        border:none !important;
        outline:none !important;
    }
</style>
<div class="flex md:w-[85%] w-full m-[2rem] m-auto mb-6 md:flex-nowrap flex-wrap items-stretch min-h-[80vh]">
<div class="md:w-[45%] w-[100%] mx-auto mt-12">
    <img src="{{ asset('img/Logo.webp') }}" alt="Logo Photo" class='ml-[2rem] mb-[1rem]'>
        <form method="POST" action="{{ url('/usersregister') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-[#5F6377]">Name</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}"
                       class="w-full px-4 py-2 border rounded-[2px] border-[#C5C5C5] dark:bg-gray-700 dark:text-white"
                       required>
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-[#5F6377]">Email</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       class="w-full px-4 py-2 border rounded-[2px] border-[#C5C5C5] dark:bg-gray-700 dark:text-white"
                       required>
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-[#5F6377]">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-[2px] border-[#C5C5C5] dark:bg-gray-700 dark:text-white"
                       required>
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-[#5F6377]">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       class="w-full px-4 py-2 border rounded-[2px] border-[#C5C5C5] dark:bg-gray-700 dark:text-white"
                       required>
            </div>

            <div class="mb-4">
    <label for="profile_picture" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-[#5F6377]">Profile Picture</label>
    <input type="file" id="profile_picture" name="profile_picture"
           class="w-full px-4 py-2 border rounded-[2px] border-[#C5C5C5] dark:bg-gray-700 dark:text-white">
    @error('profile_picture') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
   </div>



    <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 text-[#5F6377]">Search Roles</label>
    
    <!-- Search Input -->
    <input type="text" id="roleSearch"
           placeholder="Type to search roles..."
           class="w-full px-4 py-2 border rounded-[2px] border-[#C5C5C5] dark:bg-gray-700 dark:text-white">
    
    <!-- Checkboxes List -->
    <div id="rolesList" class="space-y-2 max-h-48 overflow-y-auto border p-3 rounded-md dark:border-gray-600 dark:bg-gray-800">
        @foreach($roles as $role)
            <label class="flex items-center role-item text-[#5F6377]">
                <input type="checkbox" name="role_id[]" value="{{ $role->id }}"
                       {{ is_array(old('role_id')) && in_array($role->id, old('role_id')) ? 'checked' : '' }}
                       class="form-checkbox text-blue-600 dark:bg-gray-700 dark:border-gray-600">
                <span class="ml-2 text-gray-700 dark:text-gray-300">{{ ucfirst($role->name) }}</span>
            </label>
        @endforeach
    </div>

    @error('role_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>


            <div class="flex items-center justify-between mt-6">
                <button type="submit"
                        class="bg-[#0057D8]  text-white font-medium py-2 px-4 rounded-[10px]">
                    Register
                </button>
                <a href="{{ url('/') }}"
                   class="text-gray-600 dark:text-gray-300 hover:underline">
                    Cancel
                </a>
            </div>
            <div class="mt-4 text-center">
                <span class='text-[#6C6C6C]'>Don't have an account?</span>
            <a href="{{ url('/userslogin') }}" class="text-blue-600 hover:underline dark:text-blue-400 font-[600]">
                 Sign in
            </a>
            </div>
        </form>
</div>


<div class="image md:w-[55%] w-[100%] md:block hidden  px-4 sm:px-6 lg:px-8 py-[2rem] gap-[20px] mt-12 bg-[#0057D8] flex flex-col items-center justify-center">
    <h2 class='font-[DM-sans] text-[32px] font-semibold leading-[1.3em] text-white'>Welcome Back to SYSINN HRM!</h2>
    <p class='text-white font-[400] text-[14px] font-[DM-sans] leading-[25px] text-center'>Create your account today and begin streamlining your <br>projects with our hassle-free HRM system.</p>
    <img src="{{ asset('img/Login.webp') }}" alt="Login Photo" class='h-[250px] w-[100%]'>
    <p class='text-white font-[600] text-[14px] font-[DM-sans] leading-[25px] text-center'>Powered by SYSINN</p>
</div>

</div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('roleSearch');
        const roleItems = document.querySelectorAll('.role-item');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.toLowerCase();

            roleItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) ? '' : 'none';
            });
        });
    });
</script>

<style>
    #rolesList::-webkit-scrollbar {
        width: 6px;
    }

    #rolesList::-webkit-scrollbar-thumb {
        background-color: rgba(100, 116, 139, 0.5); /* slate-500 */
        border-radius: 4px;
    }
</style>
