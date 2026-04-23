<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Coca-Cola System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    @yield('styles')
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden">

    <aside class="sidebar w-64 h-full flex-shrink-0 flex flex-col p-6">
        <div class="mb-10 text-center">
            <h1 class="text-3xl logo-text italic">Coca-Cola</h1>
            <p class="text-[10px] uppercase tracking-widest text-red-400 font-bold">Internal Portal</p>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="{{ route('home') }}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }} flex items-center p-3 rounded-xl transition-all">
                <span class="text-sm font-semibold">Resumen General</span>
            </a>
            <a href="#" class="nav-item flex items-center p-3 rounded-xl transition-all">
                <span class="text-sm font-semibold">Inventario</span>
            </a>
            <a href="#" class="nav-item flex items-center p-3 rounded-xl transition-all">
                <span class="text-sm font-semibold">Logística</span>
            </a>
            <form method="POST" action="{{ route('reportes') }}">
                @csrf
                <button type="submit" class="nav-item flex items-center p-3 rounded-xl transition-all">
                    <span class="text-sm font-semibold">Reportes</span>
                </button>
            </form>
        </nav>

        <div class="mt-auto pt-6 border-t border-red-100">
            <div class="flex items-center space-x-3 mb-4 px-2">
                <div class="w-10 h-10 rounded-full bg-red-200 flex items-center justify-center text-red-600 font-bold">
                    SA
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-gray-800 truncate">{{ auth()->user()->name ?? 'Santiago' }}</p>
                    <p class="text-xs text-gray-500">Backend Dev</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left p-3 text-sm text-gray-500 hover:text-red-500 transition-colors">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-y-auto bg-white rounded-l-[40px] shadow-2xl border-l border-red-50">
        <header class="px-8 py-6 flex justify-between items-center bg-white/50 backdrop-blur-md sticky top-0 z-10">
            <h2 class="text-2xl font-bold text-gray-800">Panel de Control</h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-400">{{ now()->format('d M, Y') }}</span>
                <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center">
                    <div class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></div>
                </div>
            </div>
        </header>

        <div class="px-8 pb-10">
            @yield('content')
        </div>
    </main>

</body>
</html>