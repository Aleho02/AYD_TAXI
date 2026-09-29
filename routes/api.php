<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TripController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas API - AYD TAXII
|--------------------------------------------------------------------------
| Sistema de Información Geoespacial Distribuido para Taxis en Valle de Ubaté.
*/

// Rutas públicas de autenticación API
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas mediante tokens Sanctum
Route::middleware('auth:sanctum')->group(function () {
    // Perfil y cierre de sesión
    Route::get('/user', [AuthController::class, 'profile']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Gestión de viajes / carreras en tiempo real
    Route::get('/trips', [TripController::class, 'index']);
    Route::post('/trips', [TripController::class, 'store']);
    Route::get('/trips/{id}', [TripController::class, 'show']);
    Route::patch('/trips/{id}/accept', [TripController::class, 'accept']);
    Route::patch('/trips/{id}/status', [TripController::class, 'updateStatus']);

    // Ubicación GPS y conductores disponibles en Valle de Ubaté
    Route::post('/driver/location', [TripController::class, 'updateDriverLocation']);
    Route::get('/drivers/available', [TripController::class, 'availableDrivers']);
});
