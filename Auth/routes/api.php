<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;


// Todas las rutas que tengan el prefijo /v1
Route::prefix('v1')->group(function () {
    // Login
    Route::post('/login', [AuthController::class, 'login']); //todos los usuarios pueden acceder a esta ruta para iniciar sesión

    Route::apiResource('users', UserController::class); 
     
    // Rutas protegidas con JWT
    Route::middleware('auth.api')->group(function () {

        

        Route::middleware('role:administrador')->group(function () {
            // Rutas para administración de usuarios
            
        });

        Route::middleware('role:editor, administrador')->group(function () {
            Route::apiResource('/roles', RolController::class);
        });
    });
});
