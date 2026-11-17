<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\FleetController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Conductor\DashboardController as ConductorDashboardController;
use App\Http\Controllers\MobileAppController;
use App\Http\Controllers\Pasajero\DashboardController as PasajeroDashboardController;
use Illuminate\Support\Facades\Route;

// Portal Principal / Landing Page Oficial TaxiUbaté
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/inicio', function () {
    return view('welcome');
})->name('inicio');

// Autenticación Web CMS
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password/send-code', [AuthController::class, 'sendResetCode'])->name('password.send.code');
Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // App Móvil Unificada (Para Celulares Android / iOS y Navegador Móvil)
    Route::prefix('movil')->name('movil.')->group(function () {
        Route::get('/', [MobileAppController::class, 'index'])->name('index');
        Route::post('/trips', [MobileAppController::class, 'storeTrip'])->name('trips.store');
        Route::patch('/trips/{trip}/accept', [MobileAppController::class, 'acceptTrip'])->name('trips.accept');
        Route::patch('/trips/{trip}/status', [MobileAppController::class, 'updateTripStatus'])->name('trips.status');
        Route::patch('/availability', [MobileAppController::class, 'toggleAvailability'])->name('availability');
    });

    // Panel Web CMS - Solo Administrador
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/audit', [AdminDashboardController::class, 'audit'])->name('audit');
        Route::get('/analytics', [AdminDashboardController::class, 'analytics'])->name('analytics');
        Route::get('/tariffs', [AdminDashboardController::class, 'tariffs'])->name('tariffs');
        Route::patch('/trips/{trip}/dispatch', [AdminDashboardController::class, 'dispatchTrip'])->name('trips.dispatch');
        Route::resource('fleet', FleetController::class);
        Route::resource('users', UserController::class);
        Route::resource('drivers', DriverController::class);
        Route::patch('/drivers/{driver}/toggle', [DriverController::class, 'toggleAvailability'])->name('drivers.toggle');
        Route::delete('/drivers/{driver}/photo', [DriverController::class, 'deletePhoto'])->name('drivers.photo.delete');
    });

    // Panel Conductor
    Route::middleware(['role:conductor'])->prefix('conductor')->name('conductor.')->group(function () {
        Route::get('/dashboard', [ConductorDashboardController::class, 'index'])->name('dashboard');
        Route::patch('/availability', [ConductorDashboardController::class, 'toggleAvailability'])->name('availability');
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
