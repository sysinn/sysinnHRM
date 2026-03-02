@extends('layouts.app')

@section('content')
    <style>
        .min-h-screen.bg-gray-100.dark\:bg-gray-900 {
            min-height: unset
        }
    </style>

    <div class="flex flex-row justify-between">
        @include('layouts.sidebar')

        <div class="w-full">
            <main class="flex-1 bg-white p-8 font-[PlusJakartaSans]">
                <div class="max-w-7xl mx-auto">
                    <!-- Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Daily Work Status</h1>
                        <form action="{{ route('daily-work.adminStatus') }}" method="GET" class="flex items-center gap-2">
                            <input type="date" 
                                   name="date" 
                                   value="{{ $selectedDate }}" 
                                   class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   onchange="this.form.submit()">
                        </form>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                            <div class="text-blue-600 font-semibold">Date</div>
                            <div class="text-xl font-bold text-blue-800">{{ \Carbon\Carbon::parse($selectedDate)->format('d M Y') }}</div>
                        </div>
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                            <div class="text-blue-600 font-semibold">Total Employees</div>
                            <div class="text-3xl font-bold text-blue-800">{{ count($usersWithStatus) }}</div>
                        </div>
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                            <div class="text-green-600 font-semibold">Submitted</div>
                            <div class="text-3xl font-bold text-green-800">{{ $usersWithStatus->where('has_work_today', true)->count() }}</div>
                        </div>
                        <div class="bg-gray-50 border-l-4 border-gray-400 p-4 rounded-lg">
                            <div class="text-gray-600 font-semibold">Not Submitted</div>
                            <div class="text-3xl font-bold text-gray-800">{{ $usersWithStatus->where('has_work_today', false)->count() }}</div>
                        </div>
                    </div>

                    <!-- Employee Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($usersWithStatus as $user)
                            <a href="{{ route('daily-work.index', ['user_id' => $user['id']]) }}" 
                               class="block bg-white rounded-xl shadow-sm border-2 transition-all duration-200 
                                      hover:shadow-lg hover:-translate-y-1 hover:scale-[1.02] cursor-pointer
                                      {{ $user['has_work_today'] ? 'border-green-400' : 'border-gray-200' }}">
                                <div class="p-4">
                                    <!-- User Avatar & Name -->
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($user['name'], 0, 2)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-semibold text-gray-800 truncate">{{ $user['name'] }}</h3>
                                            <p class="text-xs text-gray-500 truncate">{{ $user['email'] }}</p>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <div class="mb-3">
                                        @if($user['has_work_today'])
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Completed Today
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                </svg>
                                                Not Submitted
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Work Details (if submitted) -->
                                    @if($user['has_work_today'] && $user['work_detail'])
                                        <div class="text-xs text-gray-600 bg-gray-50 rounded-lg p-2">
                                            <div class="font-medium">{{ $user['work_detail']['task_type'] ?? 'N/A' }}</div>
                                            <div class="text-gray-500">Number of Tasks: {{ $user['work_detail']['quantity'] ?? 0 }}</div>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @if(count($usersWithStatus) === 0)
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <p class="text-gray-500 text-lg">No employees found</p>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
@endsection
