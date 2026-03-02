<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title>Syssin HRM – Smart HR Management Software</title>

    <meta name="description"
        content="Modern HRM software to manage employees, payroll, attendance and leave effortlessly.">



    <link rel="canonical" href="{{ url('/') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=inter:400,600,700,800" rel="stylesheet">



    <script src="https://cdn.tailwindcss.com"></script>



    <style>
        /* Simple animations */

        .fade-up {
            animation: fadeUp 1s ease forwards;
        }

        .fade-delay-1 {
            animation-delay: .2s;
        }

        .fade-delay-2 {
            animation-delay: .4s;
        }



        @keyframes fadeUp {

            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }

        }



        .blob {

            filter: blur(80px);

            opacity: 0.6;

            animation: float 8s ease-in-out infinite;

        }



        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-40px);
            }

        }
    </style>

</head>



<body class="bg-slate-950 text-white font-[Inter] overflow-x-hidden">



    <!-- HEADER -->

    <header class="fixed w-full z-50 bg-slate-950/70 backdrop-blur border-b border-white/10">

        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <div class="flex items-center gap-2 font-bold text-xl">

                <img src="{{ asset('img/Logo-wh.webp') }}" class="h-9" alt="Syssin">

            </div>

            <nav class="space-x-4">

                @auth

                    <a href="/dashboard" class="px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-700 transition">Dashboard</a>

                @else

                    <a href="{{ route('userslogin') }}"
                        class="px-4 py-2 border border-white/20 rounded-lg hover:bg-white/10 transition">Login</a>

                @endauth

            </nav>

        </div>

    </header>



    <!-- HERO -->

    <section class="relative pt-40 pb-32 overflow-hidden">

        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-600 rounded-full blob"></div>

        <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-600 rounded-full blob"></div>



        <div class="relative max-w-7xl mx-auto px-6 text-center">

            <h1 class="text-4xl md:text-6xl font-extrabold leading-tight fade-up">

                Smarter HR Management<br>

                <span class="text-blue-500">Built for Modern Teams</span>

            </h1>

            <p class="mt-6 text-gray-300 max-w-2xl mx-auto fade-up fade-delay-1">

                Manage employees, payroll, attendance, and leave in one powerful HR platform.

            </p>

            <div class="mt-10 flex justify-center gap-4 fade-up fade-delay-2">

                <a href="#" class="px-8 py-4 bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-lg">

                    🚀 Get Started Free

                </a>

                <a href="#features" class="px-8 py-4 border border-white/20 rounded-xl hover:bg-white/10 transition">

                    Learn More

                </a>

            </div>



            <img src="{{ asset('img/hrm-vector.webp') }}" loading="eager" decoding="sync" alt="Dashboard Preview"
                class="mx-auto w-[650px]">

        </div>

    </section>



    <!-- FEATURES -->

    <section id="features" class="py-24 bg-slate-900">

        <div class="max-w-7xl mx-auto px-6 text-center">

            <h2 class="text-3xl font-bold mb-12">Everything You Need in One HR System</h2>



            <div class="grid md:grid-cols-3 gap-8">

                <div class="p-8 rounded-2xl bg-white/5 backdrop-blur border border-white/10 hover:scale-105 transition">

                    <h3 class="text-xl font-semibold mb-3">👥 Employee Management</h3>

                    <p class="text-gray-400 text-sm">Roles, departments, contracts & profiles in one place.</p>

                </div>



                <div class="p-8 rounded-2xl bg-white/5 backdrop-blur border border-white/10 hover:scale-105 transition">

                    <h3 class="text-xl font-semibold mb-3">📅 Attendance & Leave</h3>

                    <p class="text-gray-400 text-sm">Automated leave approvals and attendance tracking.</p>

                </div>



                <div class="p-8 rounded-2xl bg-white/5 backdrop-blur border border-white/10 hover:scale-105 transition">

                    <h3 class="text-xl font-semibold mb-3">💰 Payroll & Reports</h3>

                    <p class="text-gray-400 text-sm">Accurate payroll with tax-ready reports.</p>

                </div>

            </div>

        </div>

    </section>



    <!-- TESTIMONIALS -->

    <section class="py-24">

        <div class="max-w-6xl mx-auto px-6 text-center">

            <h2 class="text-3xl font-bold mb-12">Trusted by Growing Companies</h2>



            <div class="grid md:grid-cols-3 gap-6">

                <div class="p-6 rounded-xl bg-white/5 border border-white/10">

                    <p class="italic text-gray-300">“Sysinn HRM makes it easier to organize daily tasks.”</p>

                    <span class="block mt-4 font-semibold">— Sajid Noor</span>

                </div>

                <div class="p-6 rounded-xl bg-white/5 border border-white/10">

                    <p class="italic text-gray-300">“Sysinn HRM keeps everything organized so you can focus on growing
                        your business.”</p>

                    <span class="block mt-4 font-semibold">— Sarah Rehmatullah</span>

                </div>

                <div class="p-6 rounded-xl bg-white/5 border border-white/10">

                    <p class="italic text-gray-300">“With Sysinn HRM, tracking project progress and deadlines is
                        effortless.”</p>

                    <span class="block mt-4 font-semibold">— Zaryab Khan</span>

                </div>

            </div>

            <div class="grid md:grid-cols-3 gap-6 mt-[20px]">

                <div class="p-6 rounded-xl bg-white/5 border border-white/10">

                    <p class="italic text-gray-300">“Sysinn HRM helps teams stay aligned and improves overall
                        efficiency.”</p>

                    <span class="block mt-4 font-semibold">— Usman Maqbool Rai</span>

                </div>

                <div class="p-6 rounded-xl bg-white/5 border border-white/10">

                    <p class="italic text-gray-300">“Sysinn HRM reduces administrative workload so managers can focus on
                        strategy.”</p>

                    <span class="block mt-4 font-semibold">— Muneeb Alam</span>

                </div>

                <div class="p-6 rounded-xl bg-white/5 border border-white/10">

                    <p class="italic text-gray-300">“From reports to attendance, Sysinn HRM handles it all seamlessly.”
                    </p>

                    <span class="block mt-4 font-semibold">— Rana Adeel</span>

                </div>

            </div>

        </div>

    </section>



    <!-- CTA -->

    <section class="py-24 bg-gradient-to-r from-blue-600 to-purple-600 text-center">

        <h2 class="text-4xl font-extrabold mb-4">Ready to Upgrade Your HR?</h2>

        <p class="mb-8 text-lg text-white/90">Start using Syssin HRM today – fast setup, no hassle.</p>

        <a href="#" class="px-10 py-4 bg-white text-slate-900 font-semibold rounded-xl hover:bg-gray-100 transition">

            Start Free Trial

        </a>

    </section>



    <!-- FOOTER -->

    <footer class="py-8 text-center text-sm text-gray-400 bg-slate-950">

        © {{ now()->year }} Syssin HRM. All rights reserved.

    </footer>



</body>

</html>