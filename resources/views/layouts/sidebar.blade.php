@php
    use App\Models\MenuItem;

    $user = Auth::user();
    $userRoleIds = $user->roles->pluck('id')->toArray();

    $menuItems = MenuItem::all()->filter(function ($item) use ($userRoleIds) {
        return !empty(array_intersect($userRoleIds, $item->roles ?? []));
    });
@endphp

<aside class="sidebar w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 px-4 py-[1.5rem]">
    <nav class="space-y-2 flex flex-col gap-4">
        @auth       
           @foreach ($menuItems as $item)
    <a href="{{ $item->route === '#' ? '#' : route($item->route) }}"
       class="sidebar_link flex items-center gap-4 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white">
        
        @if (!empty($item->icon))
            <ion-icon name="{{ $item->icon }}" class="text-lg w-5 h-5 text-[#1E1E1E]"></ion-icon>
        @endif
        <span class='inline-block text-[14px] font-[600] font-[DM-sans] text-[#1E1E1E]' aria-hidden="true">{{ $item->label }}</span>
    </a>
@endforeach


            {{-- Logout --}}
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="block text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white mt-6 flex items-center gap-4">
               <ion-icon name="log-out-outline" class="text-lg w-5 text-[#1E1E1E]"></ion-icon>
                <span class='inline-block text-[14px] font-[600] font-[DM-sans] text-[#1E1E1E]' aria-hidden="true">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        @endauth
    </nav>
</aside>
