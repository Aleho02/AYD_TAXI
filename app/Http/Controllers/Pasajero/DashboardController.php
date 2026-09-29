<?php

namespace App\Http\Controllers\Pasajero;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use App\Models\User;
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
            ->paginate(5);

        $availableDrivers = User::where('role', 'conductor')
            ->where('is_available', true)
            ->with('vehicle')
            ->take(6)
            ->get();

        return view('pasajero.dashboard', compact('passenger', 'trips', 'availableDrivers'));
    }
}
