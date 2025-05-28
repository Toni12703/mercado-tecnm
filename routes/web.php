<?php

use App\Http\Controllers\ValidacionVentaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\VentaController;

// Si aún vas a usar la gestión de usuarios
Route::resource('usuarios', UsuarioController::class);
Route::resource('productos', ProductoController::class);

// Ruta principal
Route::get('/', function () {
    return view('index'); // Puedes cambiar a otra vista como inicio.blade.php
})->name('index');

// Rutas protegidas según login
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Rutas para cada tipo de usuario según su rol
    Route::get('/admin', function () {
        return view('paneles.admin');
    })->name('admin');

    Route::get('/gerente', function () {
        return view('paneles.gerente');
    })->name('gerente');

    Route::get('/comprador', function () {
        return view('paneles.comprador');
    })->middleware('auth')->name('comprador');

    Route::get('/vendedor', [ProductoController::class, 'index'])->name('vendedor')->middleware(['auth', 'verified']);

    Route::middleware(['auth'])->group(function () {
        Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    });

    // Ruta de dashboard (si aún la usas)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/ventas/{id}/validar', [ValidacionVentaController::class, 'validar'])->name('ventas.validar');
});
