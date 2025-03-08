<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EncuestaController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\HistorialEncuestaController;

Route::resource('usuarios', UsuarioController::class);
Route::resource('encuestas', EncuestaController::class); // Esta ruta genera automáticamente /encuestas/create
Route::resource('preguntas', PreguntaController::class);
Route::resource('respuestas', RespuestaController::class);
Route::resource('historial-encuestas', HistorialEncuestaController::class);


Route::get('/', [EncuestaController::class, 'showindex'],function () {
    return view('index');
})->name('index');

Route::get("/admin", function(){
   // return view("admin");
});

Route::prefix('encuestas')->group(function() {
    // Definir la ruta para mostrar la encuesta, utilizando el código
    //en lo q quieras sopas
    //o een los errorsasos que hay en la ceracion de encuestas
    Route::get('/encuesta/{code}', [EncuestaController::class, 'show'])->name('encuesta');
});

Route::post('/encuestas/{id}/respuestas', [RespuestaController::class, 'store'])->name('respuestas.store');

Route::get('/encuestas/{id_survey}/resultados', [EncuestaController::class, 'verResultados'])->name('encuestas.resultados');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
    