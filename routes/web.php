<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PlantillaController;
use App\Http\Controllers\ProductoController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/reportes', [PlantillaController::class, 'plantilla'])->name('reportes');
Route::post('/reportes', [PlantillaController::class, 'plantilla'])->name('reportes');

// pdf
Route::post('/pdf', [PdfController::class, 'descargarPdf'])
    ->name('formulario.pdf');

Route::post('/buscar-datos', [PdfController::class, 'buscar'])->name('datos.buscar');

// producto
Route::get('/productos', [ProductoController::class, 'mostrar']);
Route::get('/producto/crear', [ProductoController::class, 'create']);
Route::post('/productos', [ProductoController::class, 'store']);

// Rutas para usuarios no autenticados
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// Rutas protegidas
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\LogisticaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\UsuarioController;

Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'main'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rutas de Operaciones
    Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');
    Route::delete('/inventario/{id}', [InventarioController::class, 'destroy'])->name('inventario.destroy');

    Route::get('/logistica', [LogisticaController::class, 'index'])->name('logistica.index');
    Route::delete('/logistica/{id}', [LogisticaController::class, 'destroy'])->name('logistica.destroy');

    Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
    Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');
    Route::delete('/pedidos/{id}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');
    Route::get('/pedidos/export-pdf', [PedidoController::class, 'exportPdf'])->name('pedidos.pdf');

    // Ruta de Perfil
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');

    Route::middleware('role:Admin')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });
});
