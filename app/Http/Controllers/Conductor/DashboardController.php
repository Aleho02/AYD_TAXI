<?php

namespace App\Http\Controllers\Conductor;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $driver = $request->user();
        $trips = Trip::where('driver_id', $driver->id)
            ->latest()
            ->paginate(5);

        $availableTrips = Trip::where('status', 'solicitado')
            ->latest()
            ->take(5)
            ->get();

        return view('conductor.dashboard', compact('driver', 'trips', 'availableTrips'));
    }
}
