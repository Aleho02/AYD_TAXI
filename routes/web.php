<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\FleetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Conductor\DashboardController as ConductorDashboardController;
use App\Http\Controllers\Pasajero\DashboardController as PasajeroDashboardController;
use Illuminate\Support\Facades\Route;

// Redirección principal
Route::get('/', function () {
    return redirect()->route('login');
});

// Autenticación Web CMS
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // Panel Web CMS - Solo Administrador
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('fleet', FleetController::class);
        Route::resource('users', UserController::class);
        Route::resource('drivers', DriverController::class);
        Route::delete('/drivers/{driver}/photo', [DriverController::class, 'deletePhoto'])->name('drivers.photo.delete');
    });

    // Panel Conductor
    Route::middleware(['role:conductor'])->prefix('conductor')->name('conductor.')->group(function () {
        Route::get('/dashboard', [ConductorDashboardController::class, 'index'])->name('dashboard');
        Route::patch('/trips/{trip}/accept', [ConductorDashboardController::class, 'acceptTrip'])->name('trips.accept');
        Route::patch('/trips/{trip}/status', [ConductorDashboardController::class, 'updateTripStatus'])->name('trips.status');
    });

    // Panel Pasajero
    Route::middleware(['role:pasajero'])->prefix('pasajero')->name('pasajero.')->group(function () {
        Route::get('/dashboard', [PasajeroDashboardController::class, 'index'])->name('dashboard');
        Route::post('/trips', [PasajeroDashboardController::class, 'storeTrip'])->name('trips.store');
        Route::patch('/trips/{trip}/cancel', [PasajeroDashboardController::class, 'cancelTrip'])->name('trips.cancel');
    });
});
