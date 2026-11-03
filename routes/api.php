<?php

use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\EmpleadoController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\RolController;
use App\Http\Controllers\Api\UsuarioController;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::get('/health', fn () => response()->json(['status' => 'ok']));

    // CRUD interno: solo administradores autenticados (sesión web o token Sanctum).
    Route::middleware(['auth:sanctum', 'rol:'.Rol::ADMINISTRADOR])->group(function () {
        Route::apiResource('roles', RolController::class)->parameters(['roles' => 'rol']);
        Route::apiResource('usuarios', UsuarioController::class);
        Route::apiResource('empleados', EmpleadoController::class);
        Route::apiResource('clientes', ClienteController::class);
        Route::apiResource('empresas', EmpresaController::class);
    });
});
