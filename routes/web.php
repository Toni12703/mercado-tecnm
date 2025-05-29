<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ValidacionVentaController;

// 🟢 Rutas públicas
Route::get('/', [ProductoController::class, 'mostrarPublicamente'])->name('index');

// Rutas REST básicas si estás usando controladores con resource
Route::resource('usuarios', UsuarioController::class);
Route::resource('productos', ProductoController::class);

// 🔁 Redirección según rol después de login
Route::get('/redirect-by-role', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'cliente-comprador' => redirect()->route('comprador'),
        'cliente-vendedor' => redirect()->route('vendedor'),
        default => redirect()->route('index'),
    };
})->middleware('auth')->name('redirect.by.role');

// 🔒 Rutas protegidas para usuarios autenticados
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Paneles por rol
    Route::get('/admin', function () {
        return view('admin.admin');
    })->name('admin');

    Route::get('/gerente', function () {
        return view('paneles.gerente');
    })->name('gerente');

    Route::get('/comprador', function () {
        return view('paneles.comprador');
    })->name('comprador');

    Route::get('/vendedor', [ProductoController::class, 'index'])->name('vendedor');

    // Ventas
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/{id}/validar', [ValidacionVentaController::class, 'validar'])->name('ventas.validar');

    // ✅ Ruta para iniciar proceso de compra / subir ticket
    Route::get('/comprar/{producto}', [VentaController::class, 'comprar'])->name('comprar.producto');
});

// 🔐 Solo para admins
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/usuarios/crear-gerente', [AdminController::class, 'createGerente'])->name('admin.gerentes.create');
    Route::post('/admin/usuarios/guardar-gerente', [AdminController::class, 'storeGerente'])->name('admin.gerentes.store');
});
