@php
    $notifications = auth()->check() ? auth()->user()->unreadNotifications : collect();
@endphp

<nav class="bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">

        <!-- Left -->
        <div class="flex items-center gap-4">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/Logo.webp') }}" alt="Logo" class="h-8">
            </a>

            @auth
                <span class="hidden sm:block text-lg font-semibold text-[#0057D8]">
                    <!-- {{ auth()->user()->name }} -->
                </span>
            @endauth
        </div>

        <!-- Right -->
        <div class="flex items-center gap-4">

            @auth
            <!-- 🔔 Notifications -->
            <div class="relative" 
                 x-data="{ open: false, count: {{ $notifications->count() }} }">

                <button @click="
                        open = !open;
                        if(count > 0) markAsRead().then(() => count = 0);
                    "
                    class="relative focus:outline-none">

                    <ion-icon name="notifications-outline" class="text-[1.5rem] text-gray-700"></ion-icon>

                    <!-- Badge -->
                    <span x-show="count > 0"
                          class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] px-1.5 rounded-full"
                          x-text="count"></span>
                </button>

                <!-- Dropdown -->
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-3 w-80 bg-white rounded-xl shadow-lg overflow-hidden z-50">

                    <div class="px-4 py-2 font-semibold text-gray-700 border-b">
                        Notifications
                    </div>

                    <div class="max-h-72 overflow-y-auto">
                        @forelse($notifications as $notification)
                            <a href="{{ route('user.tasks.show', $notification->data['task_id'] ?? '#') }}"
                               class="block px-4 py-3 hover:bg-gray-100 border-b">
                                <p class="text-sm text-gray-800">
                                    {{ $notification->data['task_subject'] ?? 'New Task Assigned' }}
                                </p>
                                <span class="text-xs text-gray-400">
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </a>
                        @empty
                            <div class="px-4 py-4 text-sm text-gray-500 text-center">
                                No new notifications
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @endauth

            <!-- Profile -->
            @auth
            <div x-data="{ open:false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2">
                    <img src="{{ auth()->user()->employee?->profile_picture
                        ? asset('storage/'.auth()->user()->employee->profile_picture)
                        : asset('images/default-avatar.png') }}"
                        class="w-9 h-9 rounded-full object-cover border">

                    <ion-icon name="chevron-down-outline" class="text-gray-600"></ion-icon>
                </button>

                <div x-show="open" @click.away="open=false" x-transition
                     class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg z-50">
                    <a href="{{ url('/profile/edit') }}"
                       class="block px-4 py-2 hover:bg-gray-100">Profile</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
            @endauth

        </div>
    </div>
</nav>




<script>
function markAsRead() {
    return fetch("{{ route('notifications.read') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        }
    });
}
</script>




<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
