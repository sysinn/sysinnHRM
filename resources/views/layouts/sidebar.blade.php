@php
use App\Models\MenuItem;
$user = Auth::user();
$userRoleIds = $user->roles->pluck('id')->toArray();
$menuItems = MenuItem::query()
    ->get()
    ->filter(function ($item) use ($userRoleIds) {
        return !empty(array_intersect($userRoleIds, $item->roles ?? []));
    });
$grouped = $menuItems->groupBy('parent_id');
@endphp
<aside class="sidebar w-64 min-h-screen bg-gradient-to-b from-white to-gray-100 dark:from-gray-800 dark:to-gray-900 border-r px-4 py-6 shadow-md fixed top-0 left-0 h-screen overflow-y-auto">

    <!-- User Info -->
    <div class="flex items-center gap-4 mb-8 px-2 py-3 rounded-lg bg-white/70 dark:bg-gray-700 shadow">
        <div class="relative">
            <img src="{{ asset('img/placeholder.webp') }}"
                 alt="Profile Picture"
                 class="w-12 h-12 rounded-full object-cover border-2 border-white shadow">
            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border border-white"></div>
        </div>
        <div class="text-sm">
            <p class="text-gray-800 dark:text-white font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-gray-500 dark:text-gray-300 text-xs">{{ auth()->user()->roles->pluck('name')->implode(', ') ?: 'User' }}</p>
        </div>
    </div>

    <!-- Menu -->
    <nav class="space-y-2 text-sm font-medium text-gray-700 dark:text-gray-200">
    @foreach ($grouped[null] ?? [] as $item)
    @php $hasChildren = isset($grouped[$item->id]); @endphp

    {{-- Special handling for logout --}}
    @if ($item->route === 'logout')
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 w-full text-left px-2 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out text-[18px]">
                @if (!empty($item->icon))
                    <ion-icon name="{{ $item->icon }}" class="w-5 h-5 text-blue-500 dark:text-blue-400"></ion-icon>
                @endif
                <span>{{ $item->label }}</span>
            </button>
        </form>

@elseif ($hasChildren)
    {{-- Parent menu with dropdown, but not clickable --}}
    <div x-data="{ open: false }" class="space-y-1">
        <div class="flex items-center justify-between cursor-pointer px-2 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out"
             @click="open = !open">
            <div class="flex items-center gap-3 text-gray-700 dark:text-gray-100 text-[18px]">
                @if (!empty($item->icon))
                    <ion-icon name="{{ $item->icon }}" class="w-5 h-5 text-blue-500 dark:text-blue-400"></ion-icon>
                @endif
                <span>{{ $item->label }}</span>
            </div>
            <svg :class="{ 'rotate-180': open }"
                 class="w-4 h-4 transform transition-transform text-gray-500"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        <div x-show="open" x-cloak
             class="ml-6 mt-1 space-y-1 pl-2 border-l border-gray-300 dark:border-gray-600">
            @foreach ($grouped[$item->id] as $child)
                <a href="{{ route($child->route) }}"
                   class="block py-1 px-2 text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-white transition text-[18px]">
                    {{ $child->label }}
                </a>
            @endforeach
        </div>
    </div>
    @else
        <a href="{{ route($item->route) }}"
           class="flex items-center gap-3 px-2 py-2 rounded-lg hover:bg-blue-100 dark:hover:bg-gray-700 transition duration-150 ease-in-out text-[18px]">
            @if (!empty($item->icon))
                <ion-icon name="{{ $item->icon }}" class="w-5 h-5 text-blue-500 dark:text-blue-400"></ion-icon>
            @endif
            <span>{{ $item->label }}</span>
        </a>
    @endif
    @endforeach

</nav>

</aside>
