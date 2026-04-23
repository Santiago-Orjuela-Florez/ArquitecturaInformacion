<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController,
    App\Http\Controllers\PlantillaController,
    App\Http\Controllers\PdfController,
    App\Http\Controllers\LoginController,
    App\Http\Controllers\HomeController;
     


Route::get('/reportes', [PlantillaController::class, 'plantilla'])->name('reportes');
Route::post('/reportes', [PlantillaController::class, 'plantilla'])->name('reportes');

#pdf
Route::post('/pdf', [PdfController::class, 'descargarPdf'])
    ->name('formulario.pdf');

Route::post('/buscar-datos', [PdfController::class, 'buscar'])->name('datos.buscar');

#producto
Route::get('/productos', [ProductoController::class, 'mostrar']);
Route::get('/producto/crear', [ProductoController::class, 'create']);
Route::post('/productos', [ProductoController::class, 'store']);


// Rutas para usuarios no autenticados
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

// Rutas protegidas

Route::get('/home', [HomeController::class, 'main'])->name('home');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
