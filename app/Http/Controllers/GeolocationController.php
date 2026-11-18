<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GeolocationController extends Controller
{
    /**
     * Geocodificación inversa con caché y fallback a puntos de referencia de Ubaté
     */
    public function reverseGeocode(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $lat = (float) $validated['latitude'];
        $lng = (float) $validated['longitude'];

        // Redondear a 4 decimales para caché (~11 metros de precisión)
        $cacheKey = sprintf('geo_rev_%.4f_%.4f', $lat, $lng);

        $address = Cache::remember($cacheKey, 86400, function () use ($lat, $lng) {
            try {
                $response = Http::withHeaders([
                    'User-Agent' => 'AYD_TAXI_Ubate/1.0 (contacto@aydtaxi.com)',
                    'Accept-Language' => 'es-CO,es;q=0.9',
                ])->timeout(3)->get('https://nominatim.openstreetmap.org/reverse', [
                    'format' => 'json',
                    'lat' => $lat,
                    'lon' => $lng,
                    'zoom' => 18,
                    'addressdetails' => 1,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (!empty($data['display_name'])) {
                        $parts = array_map('trim', explode(',', $data['display_name']));
                        return implode(', ', array_slice($parts, 0, 3));
                    }
                }
            } catch (\Throwable $e) {
                // Fallback silencioso
            }

            return $this->findNearestUbateLandmark($lat, $lng);
        });

        return response()->json([
            'status' => 'success',
            'latitude' => $lat,
            'longitude' => $lng,
            'address' => $address,
        ]);
    }

    /**
     * Conductores disponibles para visualización en mapa en tiempo real
     */
    public function availableDrivers(): JsonResponse
    {
        $drivers = User::where('role', 'conductor')
            ->where('is_available', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with('vehicle:id,driver_id,license_plate,brand,model,color')
            ->select(['id', 'name', 'phone', 'license_number', 'latitude', 'longitude', 'is_available'])
            ->get();

        return response()->json([
            'status' => 'success',
            'drivers' => $drivers,
        ]);
    }

    /**
     * Estado completo de la flota y viajes para el mapa del Administrador
     */
    public function fleetStatus(): JsonResponse
    {
        $drivers = User::where('role', 'conductor')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with('vehicle:id,driver_id,license_plate,brand,model,color')
            ->select(['id', 'name', 'phone', 'license_number', 'latitude', 'longitude', 'is_available'])
            ->get();

        $activeTrips = Trip::whereIn('status', ['solicitado', 'aceptado', 'en_camino'])
            ->with(['passenger:id,name,phone', 'driver:id,name,phone'])
            ->select([
                'id', 'passenger_id', 'driver_id', 'origin_address', 'origin_latitude', 'origin_longitude',
                'destination_address', 'destination_latitude', 'destination_longitude', 'distance_km',
                'estimated_fare', 'status', 'created_at'
            ])
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'drivers' => $drivers,
            'active_trips' => $activeTrips,
        ]);
    }

    /**
     * Puntos de referencia conocidos en el Valle de Ubaté para fallback offline
     */
    private function findNearestUbateLandmark(float $lat, float $lng): string
    {
        $landmarks = [
            ['name' => 'Parque Principal de Ubaté (Cl. 9 # 6-30)', 'lat' => 5.3080, 'lng' => -73.8150],
            ['name' => 'Basílica Menor Santo Cristo de Ubaté', 'lat' => 5.3086, 'lng' => -73.8155],
            ['name' => 'Hospital El Salvador de Ubaté (Cra. 5 # 12-40)', 'lat' => 5.3165, 'lng' => -73.8210],
            ['name' => 'Terminal de Transportes de Ubaté (Cra. 7)', 'lat' => 5.3050, 'lng' => -73.8190],
            ['name' => 'Plaza de Mercado San José (Cl. 8)', 'lat' => 5.3095, 'lng' => -73.8130],
            ['name' => 'Universidad de Cundinamarca - Sede Ubaté', 'lat' => 5.3180, 'lng' => -73.8140],
            ['name' => 'Estadio Municipal de Ubaté', 'lat' => 5.3140, 'lng' => -73.8240],
            ['name' => 'Vereda Sucunchoque - Sector El Molino', 'lat' => 5.3280, 'lng' => -73.8350],
        ];

        $closest = null;
        $minDist = null;

        foreach ($landmarks as $lm) {
            $dist = sqrt(pow($lat - $lm['lat'], 2) + pow($lng - $lm['lng'], 2));
            if ($minDist === null || $dist < $minDist) {
                $minDist = $dist;
                $closest = $lm['name'];
            }
        }

        return $closest ?? sprintf('Ubicación en Ubaté (%.4f, %.4f)', $lat, $lng);
    }
}
