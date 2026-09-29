<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DriverController extends Controller
{
    public function index(): View
    {
        $drivers = User::where('role', 'conductor')
            ->with('vehicle')
            ->latest()
            ->paginate(10);

        return view('admin.drivers.index', compact('drivers'));
    }

    public function create(): View
    {
        return view('admin.drivers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+ -]+$/'],
            'license_number' => ['required', 'string', 'max:30'],
            'is_available' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'El nombre del conductor es obligatorio.',
            'name.max' => 'El nombre no puede exceder 100 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un formato de correo válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener mínimo 6 caracteres.',
            'license_number.required' => 'El número de licencia es obligatorio.',
            'phone.regex' => 'El teléfono contiene un formato inválido.',
            'photo.image' => 'El archivo seleccionado debe ser una imagen válida.',
            'photo.mimes' => 'Solo se permiten imágenes en formatos JPG, PNG o WEBP. Archivos PDF o PHP no están permitidos.',
            'photo.max' => 'La fotografía no puede superar los 2048 KB (2 MB).',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('drivers', 'public');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'conductor',
            'phone' => $validated['phone'] ?? null,
            'license_number' => $validated['license_number'],
            'photo_path' => $photoPath,
            'is_available' => $request->boolean('is_available', true),
            'latitude' => 5.3114,
            'longitude' => -73.8182,
        ]);

        return redirect()->route('admin.drivers.index')->with('success', 'Conductor registrado exitosamente con su fotografía.');
    }

    public function edit(User $driver): View
    {
        if (!$driver->isConductor()) {
            abort(404);
        }

        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(Request $request, User $driver): RedirectResponse
    {
        if (!$driver->isConductor()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($driver->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+ -]+$/'],
            'license_number' => ['required', 'string', 'max:30'],
            'is_available' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'file', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ], [
            'name.required' => 'El nombre del conductor es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un formato de correo válido.',
            'email.unique' => 'Este correo ya pertenece a otro usuario.',
            'license_number.required' => 'El número de licencia es obligatorio.',
            'photo.image' => 'El archivo seleccionado debe ser una imagen válida.',
            'photo.mimes' => 'Solo se permiten imágenes en formatos JPG, PNG o WEBP. Archivos PDF o PHP no están permitidos.',
            'photo.max' => 'La fotografía no puede superar los 2048 KB (2 MB).',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'license_number' => $validated['license_number'],
            'is_available' => $request->boolean('is_available'),
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('photo')) {
            // Eliminar foto previa si existe
            if ($driver->photo_path && Storage::disk('public')->exists($driver->photo_path)) {
                Storage::disk('public')->delete($driver->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('drivers', 'public');
        }

        $driver->update($data);

        return redirect()->route('admin.drivers.index')->with('success', 'Conductor y fotografía actualizados exitosamente.');
    }

    public function deletePhoto(User $driver): RedirectResponse
    {
        if (!$driver->isConductor()) {
            abort(404);
        }

        if ($driver->photo_path && Storage::disk('public')->exists($driver->photo_path)) {
            Storage::disk('public')->delete($driver->photo_path);
        }

        $driver->update(['photo_path' => null]);

        return back()->with('success', 'Fotografía eliminada exitosamente del almacenamiento y perfil.');
    }

    public function destroy(User $driver): RedirectResponse
    {
        if (!$driver->isConductor()) {
            abort(404);
        }

        if ($driver->photo_path && Storage::disk('public')->exists($driver->photo_path)) {
            Storage::disk('public')->delete($driver->photo_path);
        }

        $driver->delete();

        return redirect()->route('admin.drivers.index')->with('success', 'Conductor eliminado correctamente.');
    }
}
