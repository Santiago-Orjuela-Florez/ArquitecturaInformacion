@extends('main.home.base')

@section('title', 'Mi Perfil')
@section('breadcrumb', 'Perfil')

@section('content')
<div class="mt-8 max-w-4xl mx-auto">
    <div class="table-container">
        <div class="h-32 bg-gradient-to-r from-red-600 to-red-400"></div>
        <div class="px-8 pb-8">
            <div class="relative flex justify-between items-end -mt-12 mb-6">
                <div class="w-24 h-24 rounded-full bg-white border-4 border-white flex items-center justify-center shadow-lg overflow-hidden">
                    <div class="w-full h-full bg-red-100 text-red-600 flex items-center justify-center text-3xl font-bold">
                        {{ substr($user->name ?? 'U', 0, 1) }}
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-1">{{ auth()->user()->name }}</h2>
                    <p class="text-red-600 font-bold uppercase tracking-wide text-sm">{{ auth()->user()->role ?? 'Usuario' }}</p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Rol en el Sistema</p>
                    <p class="text-lg font-semibold text-gray-800">{{ auth()->user()->role ?? 'Usuario' }}</p>
                </div>
                <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Fecha de Registro</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
