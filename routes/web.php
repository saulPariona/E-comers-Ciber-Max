<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\TiendaController;
use App\Models\Rol;
use Illuminate\Support\Facades\Route;

Route::get('/', [TiendaController::class, 'home'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/registro', [RegisterController::class, 'create'])->name('register');
    Route::post('/registro', [RegisterController::class, 'store']);

    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Áreas internas: cada rol entra solo a la suya.
Route::middleware('auth')->group(function () {
    Route::get('/admin', [PanelController::class, 'admin'])
        ->middleware('rol:'.Rol::ADMINISTRADOR)->name('admin.dashboard');

    Route::get('/ventas', [PanelController::class, 'ventas'])
        ->middleware('rol:'.Rol::SUPERVISOR_VENTAS.','.Rol::VENDEDOR)->name('ventas.dashboard');

    Route::get('/almacen', [PanelController::class, 'almacen'])
        ->middleware('rol:'.Rol::SUPERVISOR_ALMACEN.','.Rol::ALMACENERO)->name('almacen.dashboard');
});
