<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MobileAppController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        // Conductores disponibles reales en BD
        $availableDrivers = User::where('role', 'conductor')
            ->where('is_available', true)
            ->with('vehicle')
            ->get();

        // Viajes del usuario (si es pasajero) o todos los recientes (si es admin/conductor)
        $myTrips = Trip::with(['passenger', 'driver.vehicle'])
            ->where(function ($q) use ($user) {
                $q->where('passenger_id', $user->id)
                  ->orWhere('driver_id', $user->id);
            })
            ->latest()
            ->take(20)
            ->get();

        // Viaje activo en ruta para la pestaña "En Ruta"
        $activePassengerTrip = Trip::with(['passenger', 'driver.vehicle'])
            ->whereIn('status', ['solicitado', 'aceptado', 'en_camino'])
            ->where(function ($q) use ($user) {
                if ($user->isPasajero()) {
                    $q->where('passenger_id', $user->id);
                }
            })
            ->latest()
            ->first();

        // Solicitudes pendientes reales para la pestaña "Conductor" (Imagen 2)
        $incomingDriverTrip = Trip::with(['passenger', 'driver.vehicle'])
            ->where('status', 'solicitado')
            ->latest()
            ->first();

        // Viaje en curso aceptado por conductor para la pestaña "Conductor En Viaje" (Imagen 4)
        $activeDriverTrip = Trip::with(['passenger', 'driver.vehicle'])
            ->whereIn('status', ['aceptado', 'en_camino'])
            ->latest()
            ->first();

        // Estadísticas reales del conductor
        $driverStats = [
            'completed_trips' => Trip::where('status', 'completado')
                ->when($user->isConductor(), fn ($q) => $q->where('driver_id', $user->id))
                ->count(),
            'total_earnings' => Trip::where('status', 'completado')
                ->when($user->isConductor(), fn ($q) => $q->where('driver_id', $user->id))
                ->sum('estimated_fare'),
            'pending_count' => Trip::where('status', 'solicitado')->count(),
        ];

        $defaultTab = $request->query('tab');
        if (!$defaultTab) {
            if ($user->isConductor()) {
                $defaultTab = 'conductor';
            } elseif ($activePassengerTrip) {
                $defaultTab = 'en_ruta';
            } else {
                $defaultTab = 'pedir';
            }
        }

        return view('movil.app', compact(
            'user',
            'availableDrivers',
            'myTrips',
            'activePassengerTrip',
            'incomingDriverTrip',
            'activeDriverTrip',
            'driverStats',
            'defaultTab'
        ));
    }

    public function storeTrip(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'origin_address' => ['required', 'string', 'max:255'],
            'origin_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'origin_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'destination_address' => ['required', 'string', 'max:255'],
            'destination_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'destination_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'distance_km' => ['required', 'numeric', 'min:0.1', 'max:150'],
            'estimated_fare' => ['nullable', 'numeric', 'min:1000'],
        ]);

        $distance = round((float) $validated['distance_km'], 2);
        $baseFare = 5000;
        $kmRate = 1500;
        $calculatedFare = max(6000, round($baseFare + ($distance * $kmRate), -2));
        $estimatedFare = !empty($validated['estimated_fare']) ? (float) $validated['estimated_fare'] : $calculatedFare;

        $nearestDriver = User::where('role', 'conductor')
            ->where('is_available', true)
            ->first();

        Trip::create([
            'passenger_id' => $request->user()->id,
            'driver_id' => $nearestDriver ? $nearestDriver->id : null,
            'origin_address' => $validated['origin_address'],
            'origin_latitude' => (float) ($validated['origin_latitude'] ?? 5.3080000),
            'origin_longitude' => (float) ($validated['origin_longitude'] ?? -73.8150000),
            'destination_address' => $validated['destination_address'],
            'destination_latitude' => (float) ($validated['destination_latitude'] ?? 5.3165000),
            'destination_longitude' => (float) ($validated['destination_longitude'] ?? -73.8210000),
            'distance_km' => $distance,
            'estimated_fare' => $estimatedFare,
            'status' => 'solicitado',
        ]);

        return redirect()->route('movil.index', ['tab' => 'en_ruta'])
            ->with('success', '¡Taxi solicitado en tiempo real! Ya está registrado para el Conductor y Administrador.');
    }

    public function acceptTrip(Request $request, Trip $trip): RedirectResponse
    {
        $user = $request->user();
        $driverId = $user->isConductor() ? $user->id : ($trip->driver_id ?: User::where('role', 'conductor')->value('id'));

        $trip->update([
            'driver_id' => $driverId,
            'status' => 'en_camino',
        ]);

        return redirect()->route('movil.index', ['tab' => 'conductor'])
            ->with('success', '¡Viaje aceptado! Modo navegación activado.');
    }

    public function updateTripStatus(Request $request, Trip $trip): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:en_camino,completado,cancelado'],
        ]);

        $trip->update(['status' => $validated['status']]);

        $nextTab = $validated['status'] === 'completado' ? 'historial' : ($request->input('tab', 'pedir'));

        return redirect()->route('movil.index', ['tab' => $nextTab])
            ->with('success', 'Estado de la carrera actualizado a: ' . ucfirst($validated['status']));
    }

    public function toggleAvailability(Request $request): RedirectResponse
    {
        $user = $request->user();
        $user->update(['is_available' => !$user->is_available]);

        return redirect()->route('movil.index', ['tab' => 'conductor'])
            ->with('success', 'Disponibilidad actualizada a: ' . ($user->is_available ? 'Disponible' : 'Ocupado'));
    }
}
