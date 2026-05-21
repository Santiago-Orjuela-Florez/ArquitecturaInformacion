@extends('main.home.base')

@section('title', 'Gestión de Usuarios')
@section('breadcrumb', 'Usuarios')

@section('content')
<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Formulario para agregar usuarios -->
    <div class="lg:col-span-1">
        <div class="card-panel">
            <h3 class="card-title">Nuevo Usuario</h3>
            
            <form action="{{ route('usuarios.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="form-label">Nombre Completo</label>
                    <input type="text" name="name" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Rol</label>
                    <select name="role" required class="form-input bg-white">
                        <option value="Admin">Admin</option>
                        <option value="Logística">Logística</option>
                        <option value="Ventas">Ventas</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-primary">
                    Crear Usuario
                </button>
            </form>
        </div>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="lg:col-span-2">
        <h3 class="card-title">Usuarios Registrados</h3>
        <div class="table-container">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="table-header">
                        <th class="table-header-cell">ID</th>
                        <th class="table-header-cell">Nombre</th>
                        <th class="table-header-cell">Correo</th>
                        <th class="table-header-cell">Rol</th>
                        <th class="table-header-cell">Registro</th>
                        <th class="table-header-cell text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($usuarios as $user)
                    <tr class="table-row">
                        <td class="table-cell font-bold text-gray-500">#{{ $user->id }}</td>
                        <td class="table-cell font-bold text-gray-900">{{ $user->name }}</td>
                        <td class="table-cell font-medium">{{ $user->email }}</td>
                        <td class="table-cell font-bold text-red-600">{{ $user->role }}</td>
                        <td class="table-cell font-medium">{{ $user->created_at->format('d M, Y') }}</td>
                        <td class="table-cell text-center">
                            @if(auth()->user()->id !== $user->id)
                            <form id="delete-user-{{ $user->id }}" action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('delete-user-{{ $user->id }}', '{{ $user->name }}')" class="text-gray-400 hover:text-red-600 transition-colors" title="Eliminar">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-500 font-medium">No hay usuarios registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
