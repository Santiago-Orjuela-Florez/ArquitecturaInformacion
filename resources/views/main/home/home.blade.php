@extends('main.home.base')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="stat-card p-6 rounded-3xl bg-red-50 border border-red-100">
        <p class="text-red-400 text-sm font-bold uppercase mb-1">Ventas Hoy</p>
        <h3 class="text-3xl font-extrabold text-gray-800">$12,450</h3>
        <p class="text-xs text-green-500 mt-2">+12% vs ayer</p>
    </div>
    <div class="stat-card p-6 rounded-3xl bg-orange-50 border border-orange-100">
        <p class="text-orange-400 text-sm font-bold uppercase mb-1">Pedidos Pendientes</p>
        <h3 class="text-3xl font-extrabold text-gray-800">48</h3>
        <p class="text-xs text-orange-400 mt-2">12 prioridad alta</p>
    </div>
    <div class="stat-card p-6 rounded-3xl bg-blue-50 border border-blue-100">
        <p class="text-blue-400 text-sm font-bold uppercase mb-1">Eficiencia Carga</p>
        <h3 class="text-3xl font-extrabold text-gray-800">94.2%</h3>
        <p class="text-xs text-blue-400 mt-2">Optimizado</p>
    </div>
</div>

<div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
        <h4 class="font-bold text-gray-700">Distribución Reciente</h4>
        <button class="text-xs font-bold text-red-400 hover:text-red-600">Ver todo</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50">
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">ID Pedido</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Destino</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase">Estado</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase text-right">Monto</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr class="hover:bg-red-50/30 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-gray-700">#CC-8821</td>
                    <td class="px-6 py-4 text-sm text-gray-500">Bogotá - Central Norte</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-600 uppercase">En Camino</span>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-gray-700 text-right">$1,200.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection