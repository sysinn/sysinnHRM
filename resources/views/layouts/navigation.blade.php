<nav class="bg-white dark:bg-gray-800">
    <div class='max-w-7xl mx-auto px-4 h-16 flex items-center justify-between'>

        <div class="flex items-center justify-between min-w-[25%]  md:w-[40%] w-[60%]">
            <a href="{{ url('/') }}" class="text-xl font-bold text-gray-800 dark:text-white">
                <img src="{{ asset('img/Logo.webp') }}" alt="Logo Photo">
            </a>

            <ion-icon name="menu-outline" class='menuicon text-[1.3rem] lg:hidden block'></ion-icon>

            @auth
                <a href="#" class="text-[24px] text-[#0057D8] font-[600] font-[DM-sans] sm-block hidden">
                    {{ Auth::user()->name }} ..!
                </a>
            @endauth
        </div>

        <div class="flex items-center space-x-4">
            <div class="icon">
                <ion-icon name="notifications-outline" class='text-[1.5rem] mt-2'></ion-icon>
            </div>

            @auth
                @php
                    $roleId = Auth::user()->role_id ?? null;
                @endphp

                <div class="relative inline-block text-left" x-data="{ open: false }">
                    <!-- Profile Button -->
                    <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('images/default-avatar.png') }}"
                             alt="Pic" class="w-10 h-10 rounded-full border border-gray-300 object-cover">
                        <svg class="w-3 h-3 text-[#0057D8]" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-md shadow-lg z-50">
                        <a href="{{ url('/profile/edit') }}"
                           class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}"
                   class="text-gray-700 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 font-semibold">
                    Login
                </a>
            @endguest
        </div>
    </div>
</nav>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
