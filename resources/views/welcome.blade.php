<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Syssin HRM - Home</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,700" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white min-h-screen flex flex-col">

<header class="w-full py-6 px-4 lg:px-4 flex justify-between items-center shadow-sm bg-white dark:bg-gray-800">
    <h1 class="text-xl font-bold"><img src="{{ asset('img/Logo.webp') }}" alt="Logo Photo"></h1>
    <nav class="space-x-4">
        <!-- <a href="{{ route('employee.login') }}" class="px-4 py-2 rounded border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white text-sm">Employee login</a> -->

        @if (Route::has('login'))
            @auth
                <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 text-sm">Dashboard</a>
            @else
                <a href="{{ route('userslogin') }}" class="px-4 py-2 rounded border border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white text-sm">Log in</a>
            @endauth
        @endif
    </nav>
</header>


    <main class="flex-grow flex flex-col items-center justify-center text-center px-6 py-12">
        <h2 class="text-4xl lg:text-5xl font-extrabold mb-4 font-[DM-sans]">Streamline Your HR Management</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-xl">Efficient, secure, and user-friendly HRM software to manage your workforce. Built by <strong>Syssin</strong> for companies that care.</p>
        @guest
            <a href="#" class="inline-block px-6 py-3 text-white rounded hover:bg-blue-700 text-base font-medium bg-[#0057D8] rounded-[10px]">Get Started</a>
        @endguest
    </main>

    <section class="bg-gray-100 dark:bg-gray-800 py-12 px-6 lg:px-24 text-center">
        <h3 class="text-2xl font-semibold mb-6">Core Features</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-white dark:bg-gray-900 rounded shadow">
                <h4 class="text-lg font-bold mb-2">Employee Management</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Keep records, roles, departments, and contracts in one place.</p>
            </div>
            <div class="p-6 bg-white dark:bg-gray-900 rounded shadow">
                <h4 class="text-lg font-bold mb-2">Leave & Attendance</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Track leaves, automate approvals, and manage working hours easily.</p>
            </div>
            <div class="p-6 bg-white dark:bg-gray-900 rounded shadow">
                <h4 class="text-lg font-bold mb-2">Payroll Integration</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">Generate payslips, calculate taxes, and integrate with accounts.</p>
            </div>
        </div>
    </section>

    <footer class="text-center text-sm text-gray-500 dark:text-gray-400 py-6">
        &copy; {{ now()->year }} Syssin HRM. All rights reserved.
    </footer>
</body>
</html>
