<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_drivers' => User::where('role', 'conductor')->count(),
            'active_drivers' => User::where('role', 'conductor')->where('is_available', true)->count(),
            'total_passengers' => User::where('role', 'pasajero')->count(),
            'total_vehicles' => Vehicle::count(),
            'active_vehicles' => Vehicle::where('status', 'operativo')->count(),
            'total_trips' => Trip::count(),
            'completed_trips' => Trip::where('status', 'completado')->count(),
            'active_trips' => Trip::whereIn('status', ['solicitado', 'aceptado', 'en_camino'])->count(),
            'estimated_revenue' => Trip::where('status', 'completado')->sum('estimated_fare'),
        ];

        $recentTrips = Trip::with(['passenger', 'driver'])
            ->latest()
            ->take(5)
            ->get();

        $drivers = User::where('role', 'conductor')
            ->with('vehicle')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentTrips', 'drivers'));
    }
}
