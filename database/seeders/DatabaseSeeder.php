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
        // 1. Administrador del CMS
        $admin = User::firstOrCreate(
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
        $conductor = User::firstOrCreate(
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
        $vehicle = Vehicle::firstOrCreate(
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
        $pasajero = User::firstOrCreate(
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

        // Viaje de prueba en Valle de Ubaté
        Trip::firstOrCreate(
            [
                'passenger_id' => $pasajero->id,
                'origin_address' => 'Carrera 7 # 8-20, Parque Principal de Ubaté',
            ],
            [
                'driver_id' => $conductor->id,
                'origin_latitude' => 5.3080000,
                'origin_longitude' => -73.8150000,
                'destination_address' => 'Hospital El Salvador de Ubaté, Cl. 10',
                'destination_latitude' => 5.3165000,
                'destination_longitude' => -73.8210000,
                'distance_km' => 2.4,
                'estimated_fare' => 8500.00,
                'status' => 'en_camino',
            ]
        );
    }
}
