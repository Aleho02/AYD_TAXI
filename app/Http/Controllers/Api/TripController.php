<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * Pasajero solicita una carrera en tiempo real
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
        ]);

        // Cálculo de distancia mediante fórmula de Haversine (km)
        $distance = $this->calculateHaversineDistance(
            $validated['origin_latitude'],
            $validated['origin_longitude'],
            $validated['destination_latitude'],
            $validated['destination_longitude']
        );

        // Estimación tarifaria Ubaté: Tarifa base $5,000 + $1,500/km (mínimo $6,000)
        $baseFare = 5000;
        $kmRate = 1500;
        $estimatedFare = max(6000, round($baseFare + ($distance * $kmRate), -2));

        $trip = Trip::create([
            'passenger_id' => $user->id,
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
            'message' => 'Carrera solicitada con éxito. Esperando asignación de conductor.',
            'trip' => $trip->load('passenger:id,name,phone'),
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
