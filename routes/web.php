<?php

use App\Actions\Fortify\CompletarRegistro;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\ResultadosController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('panel');
    } else {
        return redirect()->route('login');
    }
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'registro',
    'verified',
])->group(function () {
    Route::get('/panel', function () {
        return Inertia::render('Dashboard');
    })->name('panel');

    Route::controller(ResultadosController::class)->group(function () {
        Route::get('/resultados', 'index')->name('resultados');
        Route::post('/resultados/enviar', 'enviar')->name('resultados.enviar');
        Route::get('/resultados/consultar/{dni}', 'consultar')->name('consultar');
        Route::get('/resultados/descargar/{file}', 'descargar')->name('descargar');
    });
});

Route::middleware(['guest'])->controller(GoogleController::class)->group(function () {
    Route::get('/google/redirect', 'redirect')->name('google');
    Route::get('/google/callback', 'callback');
});

Route::middleware('auth')->controller(CompletarRegistro::class)->group(function () {
    Route::get('/completar-registro', 'create')->name('completar.registro');
    Route::post('/completar-registro', 'store');
});
