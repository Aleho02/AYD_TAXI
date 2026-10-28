<?php

namespace Tests\Feature;

use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TripAndGeolocationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $conductor;
    private User $pasajero;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Administrador General AYD',
            'email' => 'admin@aydtaxi.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'phone' => '3101234567',
            'is_available' => false,
        ]);

        $this->conductor = User::create([
            'name' => 'Carlos Rodríguez (Conductor)',
            'email' => 'conductor@aydtaxi.com',
            'password' => Hash::make('password123'),
            'role' => 'conductor',
            'phone' => '3117654321',
            'license_number' => 'LIC-UBATE-9988',
            'latitude' => 5.3114000,
            'longitude' => -73.8182000,
            'is_available' => true,
        ]);

        Vehicle::create([
            'driver_id' => $this->conductor->id,
            'license_plate' => 'UBT345',
            'brand' => 'Hyundai',
            'model' => 'Accent Taxi',
            'year' => 2022,
            'color' => 'Amarillo',
            'status' => 'operativo',
        ]);

        $this->pasajero = User::create([
            'name' => 'Mariana Gómez (Pasajera)',
            'email' => 'pasajero@aydtaxi.com',
            'password' => Hash::make('password123'),
            'role' => 'pasajero',
            'phone' => '3129876543',
            'latitude' => 5.3080000,
            'longitude' => -73.8150000,
            'is_available' => false,
        ]);
    }

    /**
     * 01. Pasajero solicita taxi desde el panel web y aparece en los paneles de conductor y admin
     */
    public function test_01_web_pasajero_solicita_taxi_y_aparece_en_conductor_y_admin(): void
    {
        $response = $this->actingAs($this->pasajero)->post('/pasajero/trips', [
            'origin_address' => 'Parque Principal de Ubaté',
            'origin_latitude' => 5.3080,
            'origin_longitude' => -73.8150,
            'destination_address' => 'Hospital El Salvador de Ubaté',
            'destination_latitude' => 5.3165,
            'destination_longitude' => -73.8210,
            'distance_km' => 2.5,
            'driver_id' => $this->conductor->id,
        ]);

        $response->assertRedirect(route('pasajero.dashboard'));
        $this->assertDatabaseHas('trips', [
            'passenger_id' => $this->pasajero->id,
            'origin_address' => 'Parque Principal de Ubaté',
            'status' => 'solicitado',
        ]);

        // Verificar que aparece en el panel del conductor
        $conductorView = $this->actingAs($this->conductor)->get('/conductor/dashboard');
        $conductorView->assertStatus(200)
                      ->assertSee('Parque Principal de Ubaté')
                      ->assertSee('Mariana Gómez (Pasajera)');

        // Verificar que aparece en el panel del administrador
        $adminView = $this->actingAs($this->admin)->get('/admin/dashboard');
        $adminView->assertStatus(200)
                  ->assertSee('Parque Principal de Ubaté');
    }

    /**
     * 02. Pasajero puede cancelar su servicio desde el panel web
     */
    public function test_02_web_pasajero_cancela_servicio(): void
    {
        $trip = Trip::create([
            'passenger_id' => $this->pasajero->id,
            'origin_address' => 'Plaza de Mercado de Ubaté',
            'origin_latitude' => 5.3060,
            'origin_longitude' => -73.8130,
            'destination_address' => 'Terminal de Transportes de Ubaté',
            'destination_latitude' => 5.3042,
            'destination_longitude' => -73.8178,
            'distance_km' => 1.8,
            'estimated_fare' => 7700,
            'status' => 'solicitado',
        ]);

        $response = $this->actingAs($this->pasajero)->patch("/pasajero/trips/{$trip->id}/cancel");

        $response->assertRedirect(route('pasajero.dashboard'));
        $this->assertDatabaseHas('trips', [
            'id' => $trip->id,
            'status' => 'cancelado',
        ]);
    }

    /**
     * 03. Conductor acepta y finaliza un viaje desde su panel web
     */
    public function test_03_web_conductor_acepta_y_finaliza_servicio(): void
    {
        $trip = Trip::create([
            'passenger_id' => $this->pasajero->id,
            'origin_address' => 'Basílica Menor de Ubaté',
            'origin_latitude' => 5.3086,
            'origin_longitude' => -73.8142,
            'destination_address' => 'Universidad de Cundinamarca',
            'destination_latitude' => 5.3128,
            'destination_longitude' => -73.8115,
            'distance_km' => 2.0,
            'estimated_fare' => 8000,
            'status' => 'solicitado',
        ]);

        // Conductor acepta
        $acceptResp = $this->actingAs($this->conductor)->patch("/conductor/trips/{$trip->id}/accept");
        $acceptResp->assertRedirect(route('conductor.dashboard'));
        $this->assertDatabaseHas('trips', [
            'id' => $trip->id,
            'driver_id' => $this->conductor->id,
            'status' => 'en_camino',
        ]);

        // Conductor finaliza
        $finishResp = $this->actingAs($this->conductor)->patch("/conductor/trips/{$trip->id}/status", [
            'status' => 'completado',
        ]);
        $finishResp->assertRedirect(route('conductor.dashboard'));
        $this->assertDatabaseHas('trips', [
            'id' => $trip->id,
            'status' => 'completado',
        ]);
    }

    /**
     * 04. API GET /api/drivers/available lista conductores activos en Ubaté
     */
    public function test_04_api_listar_conductores_disponibles(): void
    {
        $token = $this->pasajero->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/drivers/available');

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'count' => 1,
                 ]);
    }

    /**
     * 05. API GET /api/drivers/nearby busca taxis cercanos por radio GPS y calcula ETA
     */
    public function test_05_api_buscar_conductores_cercanos_por_geolocalizacion(): void
    {
        $token = $this->pasajero->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson('/api/drivers/nearby?latitude=5.3080&longitude=-73.8150&radius_km=10');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'search_center' => ['latitude', 'longitude', 'radius_km'],
                     'count',
                     'drivers' => [
                         '*' => ['id', 'name', 'distance_km', 'eta_minutes', 'vehicle'],
                     ],
                 ]);
    }

    /**
     * 06. API POST /api/trips/estimate cotiza tarifa, distancia vial y geometría de ruta
     */
    public function test_06_api_cotizar_ruta_optima_y_tarifa(): void
    {
        $token = $this->pasajero->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/trips/estimate', [
                             'origin_latitude' => 5.3080,
                             'origin_longitude' => -73.8150,
                             'destination_latitude' => 5.3165,
                             'destination_longitude' => -73.8210,
                         ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'estimation' => [
                         'distance_km',
                         'estimated_duration_minutes',
                         'estimated_fare',
                         'currency',
                         'routing_engine',
                         'route_geometry',
                         'nearest_driver',
                     ],
                 ]);
    }

    /**
     * 07. API POST /api/trips solicita taxi con geolocalización y auto-asignación
     */
    public function test_07_api_solicitar_viaje_con_geolocalizacion(): void
    {
        $token = $this->pasajero->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/trips', [
                             'origin_address' => 'Parque Principal de Ubaté',
                             'origin_latitude' => 5.3080,
                             'origin_longitude' => -73.8150,
                             'destination_address' => 'Hospital El Salvador de Ubaté',
                             'destination_latitude' => 5.3165,
                             'destination_longitude' => -73.8210,
                             'auto_assign_nearest' => true,
                         ]);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'trip' => ['id', 'origin_address', 'destination_address', 'estimated_fare', 'status'],
                     'geolocation_meta' => ['routing_engine', 'estimated_duration_minutes', 'nearest_driver'],
                 ]);
    }

    /**
     * 08. API GET /api/trips/{id}/tracking devuelve rastreo GPS en tiempo real
     */
    public function test_08_api_rastreo_gps_en_tiempo_real(): void
    {
        $trip = Trip::create([
            'passenger_id' => $this->pasajero->id,
            'driver_id' => $this->conductor->id,
            'origin_address' => 'Parque Principal de Ubaté',
            'origin_latitude' => 5.3080,
            'origin_longitude' => -73.8150,
            'destination_address' => 'Hospital El Salvador de Ubaté',
            'destination_latitude' => 5.3165,
            'destination_longitude' => -73.8210,
            'distance_km' => 2.4,
            'estimated_fare' => 8600,
            'status' => 'en_camino',
        ]);

        $token = $this->pasajero->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->getJson("/api/trips/{$trip->id}/tracking");

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'trip_id',
                     'trip_status',
                     'origin',
                     'destination',
                     'driver_tracking' => [
                         'driver_id',
                         'latitude',
                         'longitude',
                         'distance_to_pickup_km',
                         'eta_to_pickup_minutes',
                     ],
                 ]);
    }

    /**
     * 09. API POST /api/driver/location actualiza coordenadas GPS del conductor
     */
    public function test_09_api_conductor_actualiza_ubicacion_gps(): void
    {
        $token = $this->conductor->createToken('driver_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                         ->postJson('/api/driver/location', [
                             'latitude' => 5.3125,
                             'longitude' => -73.8160,
                             'is_available' => true,
                         ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                 ]);
    }

    /**
     * 10. API PATCH /api/trips/{id}/accept, /status y /cancel flujo completo de estados
     */
    public function test_10_api_aceptar_actualizar_y_cancelar_viaje(): void
    {
        $trip = Trip::create([
            'passenger_id' => $this->pasajero->id,
            'origin_address' => 'Parque Principal de Ubaté',
            'origin_latitude' => 5.3080,
            'origin_longitude' => -73.8150,
            'destination_address' => 'Terminal de Transportes',
            'destination_latitude' => 5.3042,
            'destination_longitude' => -73.8178,
            'distance_km' => 1.5,
            'estimated_fare' => 7300,
            'status' => 'solicitado',
        ]);

        $driverToken = $this->conductor->createToken('driver_token')->plainTextToken;
        $passengerToken = $this->pasajero->createToken('passenger_token')->plainTextToken;

        // 1. Conductor acepta el viaje
        $this->withHeader('Authorization', 'Bearer ' . $driverToken)
             ->patchJson("/api/trips/{$trip->id}/accept")
             ->assertStatus(200)
             ->assertJsonPath('trip.status', 'aceptado');

        // 2. Conductor cambia estado a en_camino
        $this->withHeader('Authorization', 'Bearer ' . $driverToken)
             ->patchJson("/api/trips/{$trip->id}/status", ['status' => 'en_camino'])
             ->assertStatus(200)
             ->assertJsonPath('trip.status', 'en_camino');

        // 3. Pasajero cancela el viaje
        $this->withHeader('Authorization', 'Bearer ' . $passengerToken)
             ->patchJson("/api/trips/{$trip->id}/cancel")
             ->assertStatus(200)
             ->assertJsonPath('trip.status', 'cancelado');
    }
}
