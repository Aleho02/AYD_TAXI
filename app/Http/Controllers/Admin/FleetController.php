<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FleetController extends Controller
{
    public function index(): View
    {
        $vehicles = Vehicle::with('driver')->latest()->paginate(10);
        $availableDrivers = User::where('role', 'conductor')
            ->whereDoesntHave('vehicle')
            ->get();

        return view('admin.fleet.index', compact('vehicles', 'availableDrivers'));
    }

    public function create(): View
    {
        $drivers = User::where('role', 'conductor')->get();
        return view('admin.fleet.create', compact('drivers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'license_plate' => [
                'required',
                'string',
                'max:7',
                'regex:/^[A-Z]{3}-?[0-9]{3}$/i',
                'unique:vehicles,license_plate',
            ],
            'brand' => ['required', 'string', 'max:50'],
            'model' => ['required', 'string', 'max:50'],
            'year' => ['required', 'integer', 'min:2000', 'max:2030'],
            'color' => ['required', 'string', 'max:30'],
            'status' => ['required', 'in:operativo,mantenimiento,inactivo'],
            'driver_id' => ['nullable', 'exists:users,id'],
        ], [
            'license_plate.required' => 'La placa del taxi es obligatoria.',
            'license_plate.regex' => 'El formato de placa es inválido. Debe tener 3 letras y 3 números (Ej: UBA123 o UBT-456).',
            'license_plate.unique' => 'Esta placa ya se encuentra registrada en la flota.',
            'brand.required' => 'La marca del vehículo es obligatoria.',
            'brand.max' => 'La marca no puede exceder 50 caracteres.',
            'model.required' => 'El modelo de vehículo es obligatorio.',
            'model.max' => 'El modelo no puede exceder 50 caracteres.',
            'year.required' => 'El año del vehículo es obligatorio.',
            'year.integer' => 'El año debe ser un valor numérico entero.',
            'year.min' => 'El año no puede ser anterior al 2000.',
            'year.max' => 'El año no puede ser superior al 2030.',
            'status.in' => 'El estado seleccionado no es válido.',
        ]);

        Vehicle::create([
            'license_plate' => strtoupper(str_replace('-', '', $validated['license_plate'])),
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'color' => $validated['color'],
            'status' => $validated['status'],
            'driver_id' => $validated['driver_id'] ?: null,
        ]);

        return redirect()->route('admin.fleet.index')->with('success', 'Vehículo registrado en la flota exitosamente.');
    }

    public function edit(Vehicle $vehicle): View
    {
        $drivers = User::where('role', 'conductor')->get();
        return view('admin.fleet.edit', compact('vehicle', 'drivers'));
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $validated = $request->validate([
            'license_plate' => [
                'required',
                'string',
                'max:7',
                'regex:/^[A-Z]{3}-?[0-9]{3}$/i',
                Rule::unique('vehicles', 'license_plate')->ignore($vehicle->id),
            ],
            'brand' => ['required', 'string', 'max:50'],
            'model' => ['required', 'string', 'max:50'],
            'year' => ['required', 'integer', 'min:2000', 'max:2030'],
            'color' => ['required', 'string', 'max:30'],
            'status' => ['required', 'in:operativo,mantenimiento,inactivo'],
            'driver_id' => ['nullable', 'exists:users,id'],
        ], [
            'license_plate.required' => 'La placa del taxi es obligatoria.',
            'license_plate.regex' => 'El formato de placa es inválido. Debe tener 3 letras y 3 números (Ej: UBA123).',
            'year.integer' => 'El año debe ser un número entero.',
            'status.in' => 'El estado seleccionado es inválido.',
        ]);

        $vehicle->update([
            'license_plate' => strtoupper(str_replace('-', '', $validated['license_plate'])),
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'color' => $validated['color'],
            'status' => $validated['status'],
            'driver_id' => $validated['driver_id'] ?: null,
        ]);

        return redirect()->route('admin.fleet.index')->with('success', 'Vehículo actualizado exitosamente.');
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        $vehicle->delete();
        return redirect()->route('admin.fleet.index')->with('success', 'Vehículo eliminado de la flota.');
    }
}
