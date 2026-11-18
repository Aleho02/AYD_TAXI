<?php

namespace App\Http\Controllers\Conductor;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $driver = $request->user()->load('vehicle');

        $trips = Trip::where('driver_id', $driver->id)
            ->with('passenger')
            ->latest()
            ->paginate(10);

        $availableTrips = Trip::where('status', 'solicitado')
            ->where(function ($query) use ($driver) {
                $query->whereNull('driver_id')
                      ->orWhere('driver_id', $driver->id);
            })
            ->with('passenger')
            ->latest()
            ->take(10)
            ->get();

        $activeTrip = Trip::where('driver_id', $driver->id)
            ->whereIn('status', ['aceptado', 'en_camino'])
            ->with('passenger')
            ->latest()
            ->first() ?? $availableTrips->first();

        $driverStats = [
            'completed_trips' => Trip::where('driver_id', $driver->id)->where('status', 'completado')->count(),
            'total_earnings' => Trip::where('driver_id', $driver->id)->where('status', 'completado')->sum('estimated_fare'),
            'total_km' => Trip::where('driver_id', $driver->id)->where('status', 'completado')->sum('distance_km'),
            'active_count' => Trip::where('driver_id', $driver->id)->whereIn('status', ['aceptado', 'en_camino'])->count(),
        ];

        return view('conductor.dashboard', compact('driver', 'trips', 'availableTrips', 'activeTrip', 'driverStats'));
    }

    public function toggleAvailability(Request $request): RedirectResponse
    {
        $driver = $request->user();
        $isAvailable = $request->has('is_available')
            ? $request->boolean('is_available')
            : !$driver->is_available;

        $driver->update(['is_available' => $isAvailable]);

        return redirect()->route('conductor.dashboard')
            ->with('success', 'Estado operativo actualizado a: ' . ($isAvailable ? 'Disponible' : 'Ocupado / Pausa'));
    }

    public function acceptTrip(Request $request, Trip $trip): RedirectResponse
    {
        $trip->update([
            'driver_id' => $request->user()->id,
            'status' => 'en_camino',
        ]);

        return redirect()->route('conductor.dashboard')
            ->with('success', 'Has aceptado el servicio. Ahora aparece en tus viajes asignados como "En camino".');
    }

    public function updateTripStatus(Request $request, Trip $trip): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:en_camino,completado,cancelado'],
        ]);

        $trip->update(['status' => $validated['status']]);

        return redirect()->route('conductor.dashboard')
            ->with('success', 'Estado del servicio actualizado correctamente.');
    }

    /**
     * Actualizar ubicación GPS del conductor desde el panel web o móvil
     */
    public function updateLocation(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'is_available' => ['nullable', 'boolean'],
        ]);

        $driver = $request->user();
        $driver->update([
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'is_available' => $request->has('is_available') ? $validated['is_available'] : $driver->is_available,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ubicación GPS transmitida con éxito.',
            'latitude' => (float) $driver->latitude,
            'longitude' => (float) $driver->longitude,
            'is_available' => (bool) $driver->is_available,
        ]);
    }
}
