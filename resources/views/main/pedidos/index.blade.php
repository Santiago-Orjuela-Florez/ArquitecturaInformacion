@extends('main.home.base')

@section('title', 'Gestión de Pedidos')
@section('breadcrumb', 'Pedidos')

@section('content')
<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Formulario para agregar registros -->
    <div class="lg:col-span-1">
        <div class="card-panel">
            <h3 class="card-title">Sumar Nuevo Pedido</h3>
            
            <form action="{{ route('pedidos.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="form-label">Cliente</label>
                    <input type="text" name="cliente" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Total ($)</label>
                    <input type="number" step="0.01" name="total" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-input bg-white">
                        <option value="Pendiente">Pendiente</option>
                        <option value="Procesando">Procesando</option>
                        <option value="Completado">Completado</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Fecha del Pedido</label>
                    <input type="date" name="fecha_pedido" required value="{{ date('Y-m-d') }}" class="form-input">
                </div>
                
                <button type="submit" class="btn-primary">
                    Guardar Pedido
                </button>
            </form>
        </div>
    </div>

    <!-- Tabla de Pedidos -->
    <div class="lg:col-span-2">
        <div class="card-panel">
            <div class="flex justify-between items-center mb-6">
                <h3 class="card-title mb-0">Listado de Pedidos</h3>
                <a href="{{ route('pedidos.pdf') }}" target="_blank" class="px-4 py-2 bg-gray-800 text-white text-sm font-bold rounded-xl hover:bg-black transition-colors shadow-sm flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Exportar a PDF</span>
                </a>
            </div>
            <div class="table-container">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="table-header">
                            <th class="table-header-cell">ID</th>
                            <th class="table-header-cell">Cliente</th>
                            <th class="table-header-cell">Total</th>
                            <th class="table-header-cell">Estado</th>
                            <th class="table-header-cell">Fecha</th>
                            <th class="table-header-cell text-center">Acciones</th>
                        </tr>
                    </thead>
                <tbody>
                    @forelse($pedidos as $pedido)
                    <tr class="table-row">
                        <td class="table-cell">#{{ $pedido->id }}</td>
                        <td class="table-cell font-medium text-gray-800">{{ $pedido->cliente }}</td>
                        <td class="table-cell">${{ number_format($pedido->total, 2) }}</td>
                        <td class="table-cell">
                            <span class="{{ $pedido->estado === 'Completado' ? 'status-badge-success' : 'status-badge-warning' }}">
                                {{ $pedido->estado }}
                            </span>
                        </td>
                        <td class="table-cell">{{ $pedido->fecha_pedido }}</td>
                        <td class="table-cell text-center">
                            <form id="delete-pedido-{{ $pedido->id }}" action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('delete-pedido-{{ $pedido->id }}', 'Pedido #{{ $pedido->id }}')" class="text-gray-400 hover:text-red-600 transition-colors" title="Eliminar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-500 font-medium">No hay pedidos registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
