<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- <title>@yield('title', config('app.name', 'Laravel'))</title>
        <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title> -->
        <title>
            @php
                // Get the last segment of the URL (slug)
                $slug = request()->segment(count(request()->segments()));

                // Make it singular and capitalize
                $title = ucfirst(Str::singular(str_replace('-', ' ', $slug)));

                // If no slug (e.g., home page), use site name
                echo $slug ? $title : config('app.name', 'Laravel');
            @endphp
        </title>

            <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            html{
                overflow-x:hidden !important;
            }
            @media screen and (max-width:1024px) {
                
            
            .sidebar{
                transform:translateX(-280px);
                position:absolute;
                transition:all 0.2s ease-in-out;
                box-shadow:0px 0px 3px grey;
            }
            .sidebar.active{
                transform:translateX(0) !important;
                position:relative !important;
            }
            .menuicon{
                cursor: pointer;
            }
        }
        </style>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
           @unless (request()->routeIs('userslogin') || request()->routeIs('usersregister'))
                 @include('layouts.navigation')
           @endunless


            <!-- Page Heading -->
            @isset($header)
                <header class="bg-dark dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')  <!-- This will render content passed from child views -->
            </main>
        </div>



        <script>
            // alert("Hello");
            let menuicon=document.querySelector(".menuicon");
            let sidebar=document.querySelector(".sidebar");
            let sidebar_link=document.querySelectorAll(".sidebar_link");

            menuicon.addEventListener("click",(e)=>{
                sidebar.classList.toggle("active");
            });
            console.log(sidebar_link);
            sidebar_link.forEach((e)=>{
                e.addEventListener("click",()=>{
                    sidebar.classList.remove("active");
                })
            }); 
        </script>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

@yield('scripts') 
    </body>
</html>
