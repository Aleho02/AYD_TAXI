<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalTrips = Trip::count();
        $cancelledTrips = Trip::where('status', 'cancelado')->count();

        $stats = [
            'total_users' => User::count(),
            'total_drivers' => User::where('role', 'conductor')->count(),
            'active_drivers' => User::where('role', 'conductor')->where('is_available', true)->count(),
            'inactive_drivers' => User::where('role', 'conductor')->where('is_available', false)->count(),
            'total_passengers' => User::where('role', 'pasajero')->count(),
            'total_vehicles' => Vehicle::count(),
            'active_vehicles' => Vehicle::where('status', 'operativo')->count(),
            'maintenance_vehicles' => Vehicle::where('status', 'mantenimiento')->count(),
            'total_trips' => $totalTrips,
            'completed_trips' => Trip::where('status', 'completado')->count(),
            'requested_trips' => Trip::where('status', 'solicitado')->count(),
            'in_progress_trips' => Trip::whereIn('status', ['aceptado', 'en_camino'])->count(),
            'active_trips' => Trip::whereIn('status', ['solicitado', 'aceptado', 'en_camino'])->count(),
            'cancelled_trips' => $cancelledTrips,
            'dispatch_rate' => $totalTrips > 0 ? round((($totalTrips - $cancelledTrips) / $totalTrips) * 100, 1) : 0,
            'estimated_revenue' => Trip::where('status', 'completado')->sum('estimated_fare'),
            'total_distance' => Trip::sum('distance_km'),
        ];

        $pendingTrips = Trip::with(['passenger', 'driver.vehicle'])
            ->whereIn('status', ['solicitado', 'aceptado', 'en_camino'])
            ->latest()
            ->get();

        $recentTrips = Trip::with(['passenger', 'driver.vehicle'])
            ->latest()
            ->take(15)
            ->get();

        $drivers = User::where('role', 'conductor')
            ->with('vehicle')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('stats', 'pendingTrips', 'recentTrips', 'drivers'));
    }

    public function dispatchTrip(Request $request, Trip $trip): RedirectResponse
    {
        $driverId = $request->input('driver_id') ?: $trip->driver_id;

        if (!$driverId) {
            $availableDriver = User::where('role', 'conductor')
                ->where('is_available', true)
                ->first();
            $driverId = $availableDriver ? $availableDriver->id : null;
        }

        $status = $request->input('status', 'en_camino');

        $trip->update([
            'driver_id' => $driverId,
            'status' => $status,
        ]);

        return back()->with('success', 'Servicio #TX-' . $trip->id . ' despachado/actualizado en tiempo real.');
    }

    public function audit(): View
    {
        $trips = Trip::with(['passenger', 'driver.vehicle'])
            ->latest()
            ->paginate(15);

        $stats = [
            'total_trips' => Trip::count(),
            'completed_trips' => Trip::where('status', 'completado')->count(),
            'active_trips' => Trip::whereIn('status', ['solicitado', 'aceptado', 'en_camino'])->count(),
            'cancelled_trips' => Trip::where('status', 'cancelado')->count(),
            'total_distance' => Trip::sum('distance_km'),
            'total_revenue' => Trip::where('status', 'completado')->sum('estimated_fare'),
        ];

        return view('admin.audit', compact('trips', 'stats'));
    }

    public function analytics(): View
    {
        $totalTrips = Trip::count();
        $totalDistance = Trip::sum('distance_km');

        $stats = [
            'total_trips' => $totalTrips,
            'completed_trips' => Trip::where('status', 'completado')->count(),
            'active_trips' => Trip::whereIn('status', ['solicitado', 'aceptado', 'en_camino'])->count(),
            'cancelled_trips' => Trip::where('status', 'cancelado')->count(),
            'total_distance' => $totalDistance,
            'avg_distance' => $totalTrips > 0 ? round($totalDistance / $totalTrips, 2) : 0,
            'estimated_revenue' => Trip::where('status', 'completado')->sum('estimated_fare'),
            'total_drivers' => User::where('role', 'conductor')->count(),
            'active_drivers' => User::where('role', 'conductor')->where('is_available', true)->count(),
            'total_vehicles' => Vehicle::count(),
            'active_vehicles' => Vehicle::where('status', 'operativo')->count(),
        ];

        $topRoutes = Trip::with(['passenger', 'driver.vehicle'])
            ->latest()
            ->take(10)
            ->get();

        $drivers = User::where('role', 'conductor')
            ->with('vehicle')
            ->latest()
            ->get();

        return view('admin.analytics', compact('stats', 'topRoutes', 'drivers'));
    }

    public function tariffs(): View
    {
        $vehicles = Vehicle::with('driver')->latest()->get();
        $totalTrips = Trip::count();
        return view('admin.tariffs', compact('vehicles', 'totalTrips'));
    }
}
