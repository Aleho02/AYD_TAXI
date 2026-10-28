<?php

namespace App\Http\Controllers\Conductor;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $driver = $request->user();
        $trips = Trip::where('driver_id', $driver->id)
            ->with('passenger')
            ->latest()
            ->paginate(10);

        $availableTrips = Trip::where('status', 'solicitado')
            ->with('passenger')
            ->latest()
            ->take(10)
            ->get();

        return view('conductor.dashboard', compact('driver', 'trips', 'availableTrips'));
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
}
