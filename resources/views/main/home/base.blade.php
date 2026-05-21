<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Coca-Cola System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('styles')
</head>
<body class="layout-wrapper">

    <aside class="sidebar-panel">
        <div class="logo-container">
            <h1 class="logo-text logo-title">Coca-Cola</h1>
            <p class="logo-subtitle">Internal Portal</p>
        </div>

        <nav class="flex-1 space-y-2">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'nav-btn-active' : 'nav-btn' }}">
                <span class="text-sm">Resumen General</span>
            </a>

            <!-- Dropdown Operaciones -->
            <div>
                <button type="button" onclick="toggleDropdown('operacionesDropdown', 'operacionesIcon')" class="{{ request()->routeIs('pedidos.*') || request()->routeIs('inventario.*') || request()->routeIs('logistica.*') ? 'nav-btn-active' : 'nav-btn' }} justify-between w-full">
                    <span class="text-sm">Operaciones</span>
                    <svg id="operacionesIcon" class="w-4 h-4 transition-transform duration-200 transform {{ request()->routeIs('pedidos.*') || request()->routeIs('inventario.*') || request()->routeIs('logistica.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="operacionesDropdown" class="{{ request()->routeIs('pedidos.*') || request()->routeIs('inventario.*') || request()->routeIs('logistica.*') ? 'flex' : 'hidden' }} flex-col pl-4 mt-2 space-y-1">
                    <a href="{{ route('pedidos.index') }}" class="{{ request()->routeIs('pedidos.*') ? 'subnav-btn-active' : 'subnav-btn' }}">
                        <span class="text-sm">Pedidos</span>
                    </a>
                    <a href="{{ route('inventario.index') }}" class="{{ request()->routeIs('inventario.*') ? 'subnav-btn-active' : 'subnav-btn' }}">
                        <span class="text-sm">Inventario</span>
                    </a>
                    <a href="{{ route('logistica.index') }}" class="{{ request()->routeIs('logistica.*') ? 'subnav-btn-active' : 'subnav-btn' }}">
                        <span class="text-sm">Logística</span>
                    </a>
                </div>
            </div>

            <!-- Menú Administración -->
            @if(auth()->user()->role === 'Admin')
            <div>
                <button type="button" onclick="toggleDropdown('adminDropdown', 'adminIcon')" class="{{ request()->routeIs('usuarios.*') ? 'nav-btn-active' : 'nav-btn' }} justify-between w-full">
                    <span class="text-sm">Administración</span>
                    <svg id="adminIcon" class="w-4 h-4 transition-transform duration-200 transform {{ request()->routeIs('usuarios.*') ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div id="adminDropdown" class="{{ request()->routeIs('usuarios.*') ? 'flex' : 'hidden' }} flex-col pl-4 mt-2 space-y-1">
                    <a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'subnav-btn-active' : 'subnav-btn' }}">
                        <span class="text-sm">Usuarios</span>
                    </a>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('reportes') }}" class="mt-2">
                @csrf
                <button type="submit" class="nav-btn w-full text-left">
                    <span class="text-sm">Reportes</span>
                </button>
            </form>
        </nav>

        <div class="mt-auto pt-6 border-t border-red-100">
            <a href="{{ route('perfil.index') }}" class="flex items-center space-x-3 mb-4 px-2 hover:bg-red-50 p-2 rounded-xl transition-colors cursor-pointer group">
                <div class="w-10 h-10 rounded-full bg-red-200 flex items-center justify-center text-red-600 font-bold group-hover:bg-red-600 group-hover:text-white transition-colors">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold text-gray-800 truncate group-hover:text-red-600 transition-colors">{{ auth()->user()->name ?? 'Usuario' }}</p>
                    <p class="text-xs text-gray-500">{{ auth()->user()->role ?? 'Usuario' }}</p>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left p-3 text-sm text-gray-500 hover:text-red-500 transition-colors">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <main class="main-content">
        <header class="header-bar">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-extrabold text-gray-900">
                    @yield('title', 'Panel de Control')
                </h2>
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-semibold text-gray-600">{{ now()->format('d M, Y') }}</span>
                    <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center shadow-sm border border-red-200">
                        <div class="w-2.5 h-2.5 rounded-full bg-red-600 animate-pulse"></div>
                    </div>
                </div>
            </div>
            
            <!-- Breadcrumbs -->
            <nav class="flex text-sm text-gray-500 font-semibold" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-red-600 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            Inicio
                        </a>
                    </li>
                    @hasSection('breadcrumb')
                        <li>
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mx-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <span class="text-gray-700">@yield('breadcrumb')</span>
                            </div>
                        </li>
                    @endif
                </ol>
            </nav>
        </header>

        <div class="px-8 pb-10">
            @yield('content')
        </div>
    </main>

    <script>
        function toggleDropdown(dropdownId, iconId) {
            const dropdown = document.getElementById(dropdownId);
            const icon = document.getElementById(iconId);
            dropdown.classList.toggle('hidden');
            dropdown.classList.toggle('flex');
            icon.classList.toggle('rotate-180');
        }

        // Configuración global para Toasts de SweetAlert2
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        
        // Atrapamos las variables de sesión de Laravel y lanzamos Toasts
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session("success") }}'
            });
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                Toast.fire({
                    icon: 'error',
                    title: '{{ $error }}'
                });
            @endforeach
        @endif

        function confirmDelete(formId, entityName) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción. Se eliminará: " + entityName,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
    @yield('scripts')
</body>
</html>