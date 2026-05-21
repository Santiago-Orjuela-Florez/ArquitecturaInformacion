@extends('main.home.base')

@section('title', 'Resumen General')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="stat-card p-6 rounded-3xl bg-red-50 border border-red-100">
        <p class="text-red-400 text-sm font-bold uppercase mb-1">Ventas Hoy</p>
        <h3 class="text-3xl font-extrabold text-gray-800">${{ number_format($stats['ventas_hoy'] ?? 0, 2) }}</h3>
    </div>
    <div class="stat-card p-6 rounded-3xl bg-orange-50 border border-orange-100">
        <p class="text-orange-400 text-sm font-bold uppercase mb-1">Pedidos Pendientes</p>
        <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['pedidos_pendientes'] ?? 0 }}</h3>
    </div>
    <div class="stat-card p-6 rounded-3xl bg-blue-50 border border-blue-100">
        <p class="text-blue-400 text-sm font-bold uppercase mb-1">Eficiencia Carga</p>
        <h3 class="text-3xl font-extrabold text-gray-800">{{ $stats['eficiencia'] ?? '0%' }}</h3>
    </div>
</div>

<!-- Gráficos -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
    <div class="card-panel">
        <h4 class="font-bold text-gray-700 mb-4">Estado de los Pedidos</h4>
        <div class="relative w-full h-64 flex justify-center items-center">
            <canvas id="pedidosChart"></canvas>
        </div>
    </div>
</div>

<div class="table-container">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
        <h4 class="font-bold text-gray-700">Distribución Reciente</h4>
        <button class="text-xs font-bold text-red-400 hover:text-red-600">Ver todo</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="table-header">
                    <th class="table-header-cell">ID Pedido</th>
                    <th class="table-header-cell">Destino</th>
                    <th class="table-header-cell">Estado</th>
                    <th class="table-header-cell text-right">Monto</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr class="table-row">
                    <td class="table-cell font-medium text-gray-700">#CC-8821</td>
                    <td class="table-cell">Bogotá - Central Norte</td>
                    <td class="table-cell">
                        <span class="status-badge-success uppercase">En Camino</span>
                    </td>
                    <td class="table-cell font-bold text-gray-700 text-right">$1,200.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('pedidosChart').getContext('2d');
    const chartData = @json($chartData ?? []);
    
    const labels = Object.keys(chartData);
    const data = Object.values(chartData);

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels.length ? labels : ['Sin Datos'],
            datasets: [{
                data: data.length ? data : [1],
                backgroundColor: [
                    '#f87171', // red-400
                    '#fb923c', // orange-400
                    '#4ade80', // green-400
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endsection