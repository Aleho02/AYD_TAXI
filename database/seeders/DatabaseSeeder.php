<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Limpiar viajes previos para iniciar en cero sin viajes falsos
        Trip::query()->delete();

        // 1. Administrador del CMS
        User::updateOrCreate(
            ['email' => 'admin@aydtaxi.com'],
            [
                'name' => 'Administrador General AYD',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '3101234567',
                'is_available' => false,
            ]
        );

        // 2. Conductor de taxi de Ubaté
        $conductor = User::updateOrCreate(
            ['email' => 'conductor@aydtaxi.com'],
            [
                'name' => 'Carlos Rodríguez (Conductor)',
                'password' => Hash::make('password123'),
                'role' => 'conductor',
                'phone' => '3117654321',
                'license_number' => 'LIC-UBATE-9988',
                'latitude' => 5.3114000,
                'longitude' => -73.8182000,
                'is_available' => true,
            ]
        );

        // Vehículo asignado al conductor
        Vehicle::updateOrCreate(
            ['license_plate' => 'UBT345'],
            [
                'driver_id' => $conductor->id,
                'brand' => 'Hyundai',
                'model' => 'Accent Taxi',
                'year' => 2022,
                'color' => 'Amarillo',
                'status' => 'operativo',
            ]
        );

        // 3. Pasajero cliente
        User::updateOrCreate(
            ['email' => 'pasajero@aydtaxi.com'],
            [
                'name' => 'Mariana Gómez (Pasajera)',
                'password' => Hash::make('password123'),
                'role' => 'pasajero',
                'phone' => '3129876543',
                'latitude' => 5.3080000,
                'longitude' => -73.8150000,
                'is_available' => false,
            ]
        );
    }
}
