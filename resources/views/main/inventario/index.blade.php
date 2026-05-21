@extends('main.home.base')

@section('title', 'Inventario')
@section('breadcrumb', 'Inventario')

@section('content')
<div class="mt-8">
    <h3 class="text-xl font-bold text-gray-800 mb-6">Inventario</h3>
    
    <div class="table-container">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="table-header">
                    <th class="table-header-cell">ID</th>
                    <th class="table-header-cell">Producto</th>
                    <th class="table-header-cell">Cantidad</th>
                    <th class="table-header-cell">Ubicación</th>
                    <th class="table-header-cell text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventarios as $item)
                <tr class="table-row">
                    <td class="table-cell">#{{ $item->id }}</td>
                    <td class="table-cell font-medium text-gray-800">{{ $item->nombre_producto }}</td>
                    <td class="table-cell">{{ $item->cantidad }}</td>
                    <td class="table-cell">{{ $item->ubicacion ?? 'N/A' }}</td>
                    <td class="table-cell text-center">
                        <form id="delete-inventario-{{ $item->id }}" action="{{ route('inventario.destroy', $item->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-inventario-{{ $item->id }}', '{{ $item->nombre_producto }}')" class="text-gray-400 hover:text-red-600 transition-colors" title="Eliminar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-10 text-center text-gray-500 font-medium">No hay productos en inventario.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
