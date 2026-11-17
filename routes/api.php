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

// Estado en tiempo real de la API para clientes móviles
Route::get('/status', function () {
    return response()->json([
        'status' => 'online',
        'app' => 'Ubaté Taxi API Móvil',
        'active_drivers' => \App\Models\User::where('role', 'conductor')->where('is_available', true)->count(),
        'active_trips' => \App\Models\Trip::whereIn('status', ['solicitado', 'aceptado', 'en_camino'])->count(),
        'total_trips' => \App\Models\Trip::count(),
        'timestamp' => now()->toIso8601String(),
    ]);
});

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
    Route::post('/trips/estimate', [TripController::class, 'estimate']);
    Route::get('/trips', [TripController::class, 'index']);
    Route::post('/trips', [TripController::class, 'store']);
    Route::get('/trips/{id}', [TripController::class, 'show']);
    Route::get('/trips/{id}/tracking', [TripController::class, 'tracking']);
    Route::patch('/trips/{id}/accept', [TripController::class, 'accept']);
    Route::patch('/trips/{id}/cancel', [TripController::class, 'cancel']);
    Route::patch('/trips/{id}/status', [TripController::class, 'updateStatus']);

    // Ubicación GPS y conductores disponibles en Valle de Ubaté
    Route::post('/driver/location', [TripController::class, 'updateDriverLocation']);
    Route::get('/drivers/available', [TripController::class, 'availableDrivers']);
    Route::get('/drivers/nearby', [TripController::class, 'nearbyDrivers']);
});
