<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TripController extends Controller
{
    /**
     * Listar viajes según el rol del usuario autenticado
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $query = Trip::with(['passenger:id,name,phone', 'driver:id,name,phone,license_number,photo_path']);

        if ($user->isAdmin()) {
            $trips = $query->latest()->paginate(15);
        } elseif ($user->isConductor()) {
            $trips = $query->where(function ($q) use ($user) {
                $q->where('driver_id', $user->id)
                  ->orWhere('status', 'solicitado');
            })->latest()->paginate(15);
        } else {
            $trips = $query->where('passenger_id', $user->id)->latest()->paginate(15);
        }

        return response()->json([
            'status' => 'success',
            'data' => $trips,
        ]);
    }

    /**
     * Cotizador geoespacial previo: calcula ruta óptima por calles (OSRM / Haversine), tiempo estimado, tarifa y taxi más cercano
     */
    public function estimate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'origin_latitude' => ['required', 'numeric', 'between:-90,90'],
            'origin_longitude' => ['required', 'numeric', 'between:-180,180'],
            'destination_latitude' => ['required', 'numeric', 'between:-90,90'],
            'destination_longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $routeData = $this->calculateOptimalRoadRoute(
            (float) $validated['origin_latitude'],
            (float) $validated['origin_longitude'],
            (float) $validated['destination_latitude'],
            (float) $validated['destination_longitude']
        );

        $distance = $routeData['distance_km'];
        $baseFare = 5000;
        $kmRate = 1500;
        $estimatedFare = max(6000, round($baseFare + ($distance * $kmRate), -2));

        $nearestDriver = $this->findNearestAvailableDriver(
            (float) $validated['origin_latitude'],
            (float) $validated['origin_longitude']
        );

        return response()->json([
            'status' => 'success',
            'estimation' => [
                'distance_km' => round($distance, 2),
                'estimated_duration_minutes' => $routeData['duration_minutes'],
                'estimated_fare' => $estimatedFare,
                'currency' => 'COP',
                'routing_engine' => $routeData['engine'],
                'route_geometry' => $routeData['geometry'],
                'nearest_driver' => $nearestDriver,
            ],
        ]);
    }

    /**
     * Pasajero solicita una carrera en tiempo real con geolocalización y ruta óptima por calles
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'origin_address' => ['required', 'string', 'max:255'],
            'origin_latitude' => ['required', 'numeric', 'between:-90,90'],
            'origin_longitude' => ['required', 'numeric', 'between:-180,180'],
            'destination_address' => ['required', 'string', 'max:255'],
            'destination_latitude' => ['required', 'numeric', 'between:-90,90'],
            'destination_longitude' => ['required', 'numeric', 'between:-180,180'],
            'driver_id' => ['nullable', 'exists:users,id'],
            'auto_assign_nearest' => ['nullable', 'boolean'],
        ]);

        $routeData = $this->calculateOptimalRoadRoute(
            (float) $validated['origin_latitude'],
            (float) $validated['origin_longitude'],
            (float) $validated['destination_latitude'],
            (float) $validated['destination_longitude']
        );

        $distance = $routeData['distance_km'];

        // Estimación tarifaria Ubaté: Tarifa base $5,000 + $1,500/km (mínimo $6,000)
        $baseFare = 5000;
        $kmRate = 1500;
        $estimatedFare = max(6000, round($baseFare + ($distance * $kmRate), -2));

        $nearestDriver = $this->findNearestAvailableDriver(
            (float) $validated['origin_latitude'],
            (float) $validated['origin_longitude']
        );

        $assignedDriverId = $validated['driver_id'] ?? null;
        if (!$assignedDriverId && !empty($validated['auto_assign_nearest']) && $nearestDriver) {
            $assignedDriverId = $nearestDriver['id'];
        }

        $trip = Trip::create([
            'passenger_id' => $user->id,
            'driver_id' => $assignedDriverId,
            'origin_address' => $validated['origin_address'],
            'origin_latitude' => $validated['origin_latitude'],
            'origin_longitude' => $validated['origin_longitude'],
            'destination_address' => $validated['destination_address'],
            'destination_latitude' => $validated['destination_latitude'],
            'destination_longitude' => $validated['destination_longitude'],
            'distance_km' => round($distance, 2),
            'estimated_fare' => $estimatedFare,
            'status' => 'solicitado',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Carrera solicitada con éxito. Esperando confirmación de conductor.',
            'trip' => $trip->load(['passenger:id,name,phone', 'driver:id,name,phone,license_number']),
            'geolocation_meta' => [
                'routing_engine' => $routeData['engine'],
                'estimated_duration_minutes' => $routeData['duration_minutes'],
                'route_geometry' => $routeData['geometry'],
                'nearest_driver' => $nearestDriver,
            ],
        ], 201);
    }

    /**
     * Consultar detalle de un viaje con control estricto de autorización (ID Authorization Check)
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $trip = Trip::with(['passenger:id,name,phone', 'driver:id,name,phone,license_number,photo_path'])->find($id);

        if (!$trip) {
            return response()->json([
                'status' => 'error',
                'message' => 'El viaje solicitado no existe.',
            ], 404);
        }

        $user = $request->user();

        // Control de autorización: Un usuario pasajero o conductor no puede ver datos de otro viaje ajeno
        if (!$user->isAdmin() && $trip->passenger_id !== $user->id && $trip->driver_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Acceso denegado: No tiene autorización para consultar los datos de este viaje ajeno.',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'trip' => $trip,
        ], 200);
    }

    /**
     * Conductor acepta un viaje solicitado
     */
    public function accept(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        if (!$user->isConductor()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Solo los conductores pueden aceptar solicitudes de viaje.',
            ], 403);
        }

        $trip = Trip::find($id);

        if (!$trip) {
            return response()->json([
                'status' => 'error',
                'message' => 'Viaje no encontrado.',
            ], 404);
        }

        if ($trip->status !== 'solicitado') {
            return response()->json([
                'status' => 'error',
                'message' => 'Este viaje ya fue asignado o no se encuentra disponible.',
            ], 400);
        }

        $trip->update([
            'driver_id' => $user->id,
            'status' => 'aceptado',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ha aceptado el servicio. Proceda al punto de recogida.',
            'trip' => $trip->load(['passenger:id,name,phone', 'driver:id,name,phone,license_number']),
        ], 200);
    }

    /**
     * Pasajero o conductor cancela un viaje activo
     */
    public function cancel(Request $request, int $id): JsonResponse
    {
        $trip = Trip::find($id);

        if (!$trip) {
            return response()->json([
                'status' => 'error',
                'message' => 'Viaje no encontrado.',
            ], 404);
        }

        $user = $request->user();
        if (!$user->isAdmin() && $trip->passenger_id !== $user->id && $trip->driver_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'No tiene permisos para cancelar este viaje.',
            ], 403);
        }

        if (in_array($trip->status, ['completado', 'cancelado'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Este servicio ya no se puede cancelar.',
            ], 400);
        }

        $trip->update(['status' => 'cancelado']);

        return response()->json([
            'status' => 'success',
            'message' => 'El servicio de taxi ha sido cancelado correctamente.',
            'trip' => $trip,
        ], 200);
    }

    /**
     * Actualizar estado del viaje
     */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => ['required', 'in:en_camino,completado,cancelado'],
        ]);

        $trip = Trip::find($id);

        if (!$trip) {
            return response()->json(['message' => 'Viaje no encontrado.'], 404);
        }

        $user = $request->user();

        if (!$user->isAdmin() && $trip->passenger_id !== $user->id && $trip->driver_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'No tiene permisos para modificar este viaje.',
            ], 403);
        }

        $trip->update(['status' => $request->status]);

        return response()->json([
            'status' => 'success',
            'message' => 'Estado del viaje actualizado correctamente.',
            'trip' => $trip,
        ]);
    }

    /**
     * Conductor transmite su posición GPS en tiempo real
     */
    public function updateDriverLocation(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user->isConductor()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Solo los conductores autorizados pueden transmitir telemetría GPS.',
            ], 403);
        }

        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'is_available' => ['nullable', 'boolean'],
        ]);

        $user->update([
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'is_available' => $request->has('is_available') ? $validated['is_available'] : $user->is_available,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ubicación GPS transmitida con éxito.',
            'coordinates' => [
                'latitude' => $user->latitude,
                'longitude' => $user->longitude,
                'is_available' => $user->is_available,
            ],
        ]);
    }

    /**
     * Conductores disponibles en el Valle de Ubaté
     */
    public function availableDrivers(): JsonResponse
    {
        $drivers = User::where('role', 'conductor')
            ->where('is_available', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with('vehicle:id,driver_id,license_plate,brand,model,color')
            ->select(['id', 'name', 'phone', 'license_number', 'latitude', 'longitude', 'photo_path'])
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $drivers->count(),
            'drivers' => $drivers,
        ]);
    }

    /**
     * Buscar taxis cercanos ordenados por distancia Haversine y tiempo estimado de llegada (ETA)
     */
    public function nearbyDrivers(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'radius_km' => ['nullable', 'numeric', 'min:0.5', 'max:50'],
        ]);

        $passengerLat = (float) $validated['latitude'];
        $passengerLng = (float) $validated['longitude'];
        $radiusKm = (float) ($validated['radius_km'] ?? 10.0);

        $drivers = User::where('role', 'conductor')
            ->where('is_available', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with('vehicle:id,driver_id,license_plate,brand,model,color')
            ->select(['id', 'name', 'phone', 'license_number', 'latitude', 'longitude', 'photo_path'])
            ->get()
            ->map(function (User $driver) use ($passengerLat, $passengerLng) {
                $distanceKm = $this->calculateHaversineDistance(
                    $passengerLat,
                    $passengerLng,
                    (float) $driver->latitude,
                    (float) $driver->longitude
                );

                return [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'phone' => $driver->phone,
                    'license_number' => $driver->license_number,
                    'latitude' => (float) $driver->latitude,
                    'longitude' => (float) $driver->longitude,
                    'distance_km' => round($distanceKm, 2),
                    'eta_minutes' => max(1, (int) ceil($distanceKm * 2)),
                    'vehicle' => $driver->vehicle,
                ];
            })
            ->filter(fn (array $driver) => $driver['distance_km'] <= $radiusKm)
            ->sortBy('distance_km')
            ->values();

        return response()->json([
            'status' => 'success',
            'search_center' => [
                'latitude' => $passengerLat,
                'longitude' => $passengerLng,
                'radius_km' => $radiusKm,
            ],
            'count' => $drivers->count(),
            'drivers' => $drivers,
        ]);
    }

    /**
     * Seguimiento geoespacial en tiempo real de un viaje activo
     */
    public function tracking(Request $request, int $id): JsonResponse
    {
        $trip = Trip::with([
            'passenger:id,name,phone',
            'driver:id,name,phone,license_number,latitude,longitude,photo_path',
            'driver.vehicle:id,driver_id,license_plate,brand,model,color',
        ])->find($id);

        if (!$trip) {
            return response()->json([
                'status' => 'error',
                'message' => 'El viaje solicitado no existe.',
            ], 404);
        }

        $user = $request->user();
        if (!$user->isAdmin() && $trip->passenger_id !== $user->id && $trip->driver_id !== $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'No tiene autorización para rastrear este viaje.',
            ], 403);
        }

        $driverTracking = null;
        if ($trip->driver && $trip->driver->latitude !== null && $trip->driver->longitude !== null) {
            $distToPickup = $this->calculateHaversineDistance(
                (float) $trip->driver->latitude,
                (float) $trip->driver->longitude,
                (float) $trip->origin_latitude,
                (float) $trip->origin_longitude
            );
            $distToDestination = $this->calculateHaversineDistance(
                (float) $trip->driver->latitude,
                (float) $trip->driver->longitude,
                (float) $trip->destination_latitude,
                (float) $trip->destination_longitude
            );

            $driverTracking = [
                'driver_id' => $trip->driver->id,
                'name' => $trip->driver->name,
                'phone' => $trip->driver->phone,
                'latitude' => (float) $trip->driver->latitude,
                'longitude' => (float) $trip->driver->longitude,
                'vehicle' => $trip->driver->vehicle,
                'distance_to_pickup_km' => round($distToPickup, 2),
                'eta_to_pickup_minutes' => max(1, (int) ceil($distToPickup * 2)),
                'distance_to_destination_km' => round($distToDestination, 2),
                'eta_to_destination_minutes' => max(1, (int) ceil($distToDestination * 2)),
            ];
        }

        return response()->json([
            'status' => 'success',
            'trip_id' => $trip->id,
            'trip_status' => $trip->status,
            'origin' => [
                'address' => $trip->origin_address,
                'latitude' => $trip->origin_latitude,
                'longitude' => $trip->origin_longitude,
            ],
            'destination' => [
                'address' => $trip->destination_address,
                'latitude' => $trip->destination_latitude,
                'longitude' => $trip->destination_longitude,
            ],
            'distance_km' => $trip->distance_km,
            'estimated_fare' => $trip->estimated_fare,
            'driver_tracking' => $driverTracking,
        ]);
    }

    private function findNearestAvailableDriver(float $lat, float $lng): ?array
    {
        $drivers = User::where('role', 'conductor')
            ->where('is_available', true)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with('vehicle:id,driver_id,license_plate,brand,model,color')
            ->select(['id', 'name', 'phone', 'license_number', 'latitude', 'longitude'])
            ->get();

        $nearest = null;
        $minDistance = null;

        foreach ($drivers as $driver) {
            $dist = $this->calculateHaversineDistance($lat, $lng, (float) $driver->latitude, (float) $driver->longitude);
            if ($minDistance === null || $dist < $minDistance) {
                $minDistance = $dist;
                $nearest = [
                    'id' => $driver->id,
                    'name' => $driver->name,
                    'phone' => $driver->phone,
                    'latitude' => (float) $driver->latitude,
                    'longitude' => (float) $driver->longitude,
                    'distance_km' => round($dist, 2),
                    'eta_minutes' => max(1, (int) ceil($dist * 2)),
                    'vehicle' => $driver->vehicle,
                ];
            }
        }

        return $nearest;
    }

    private function calculateOptimalRoadRoute(float $lat1, float $lon1, float $lat2, float $lon2): array
    {
        try {
            $url = "https://router.project-osrm.org/route/v1/driving/{$lon1},{$lat1};{$lon2},{$lat2}?overview=full&geometries=geojson";
            $response = Http::timeout(2)->get($url);

            if ($response->successful() && isset($response['routes'][0])) {
                $route = $response['routes'][0];
                $distanceKm = max(0.2, ((float) $route['distance']) / 1000);
                $durationMin = max(2, (int) ceil(((float) $route['duration']) / 60));

                return [
                    'distance_km' => $distanceKm,
                    'duration_minutes' => $durationMin,
                    'engine' => 'OSRM (Calles y Carreras)',
                    'geometry' => $route['geometry']['coordinates'] ?? [],
                ];
            }
        } catch (\Throwable $e) {
            // Fallback a Haversine si no hay salida a internet
        }

        $distanceKm = $this->calculateHaversineDistance($lat1, $lon1, $lat2, $lon2);
        return [
            'distance_km' => $distanceKm,
            'duration_minutes' => max(3, (int) ceil($distanceKm * 2)),
            'engine' => 'Haversine (Lineal)',
            'geometry' => [[$lon1, $lat1], [$lon2, $lat2]],
        ];
    }

    private function calculateHaversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}
