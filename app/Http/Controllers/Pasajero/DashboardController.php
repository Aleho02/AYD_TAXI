<?php

namespace App\Http\Controllers\Pasajero;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $passenger = $request->user();
        $trips = Trip::where('passenger_id', $passenger->id)
            ->with('driver')
            ->latest()
            ->paginate(10);

        $availableDrivers = User::where('role', 'conductor')
            ->where('is_available', true)
            ->with('vehicle')
            ->take(6)
            ->get();

        return view('pasajero.dashboard', compact('passenger', 'trips', 'availableDrivers'));
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
            'driver_id' => ['nullable', 'exists:users,id'],
        ], [
            'origin_address.required' => 'La dirección de origen es obligatoria.',
            'destination_address.required' => 'La dirección de destino es obligatoria.',
            'distance_km.required' => 'La distancia estimada es obligatoria.',
            'distance_km.min' => 'La distancia mínima es de 0.1 km.',
        ]);

        $originLat = (float) ($validated['origin_latitude'] ?? 5.3085000);
        $originLng = (float) ($validated['origin_longitude'] ?? -73.8155000);
        $destLat = (float) ($validated['destination_latitude'] ?? 5.3165000);
        $destLng = (float) ($validated['destination_longitude'] ?? -73.8210000);

        $distance = round((float) $validated['distance_km'], 2);
        // Estimación tarifaria Ubaté: Tarifa base $5,000 + $1,500/km (mínimo $6,000)
        $baseFare = 5000;
        $kmRate = 1500;
        $estimatedFare = max(6000, round($baseFare + ($distance * $kmRate), -2));

        Trip::create([
            'passenger_id' => $request->user()->id,
            'driver_id' => $validated['driver_id'] ?: null,
            'origin_address' => $validated['origin_address'],
            'origin_latitude' => $originLat,
            'origin_longitude' => $originLng,
            'destination_address' => $validated['destination_address'],
            'destination_latitude' => $destLat,
            'destination_longitude' => $destLng,
            'distance_km' => $distance,
            'estimated_fare' => $estimatedFare,
            'status' => 'solicitado',
        ]);

        return redirect()->route('pasajero.dashboard')
            ->with('success', '¡Taxi solicitado con éxito con geolocalización GPS! El servicio ya está visible para el conductor y el administrador.');
    }

    public function cancelTrip(Request $request, Trip $trip): RedirectResponse
    {
        if ($trip->passenger_id !== $request->user()->id) {
            return redirect()->route('pasajero.dashboard')
                ->with('error', 'No tienes permiso para cancelar este viaje.');
        }

        if (in_array($trip->status, ['completado', 'cancelado'])) {
            return redirect()->route('pasajero.dashboard')
                ->with('error', 'Este servicio ya no se puede cancelar.');
        }

        $trip->update([
            'status' => 'cancelado',
        ]);

        return redirect()->route('pasajero.dashboard')
            ->with('success', 'El servicio de taxi ha sido cancelado correctamente.');
    }
}
