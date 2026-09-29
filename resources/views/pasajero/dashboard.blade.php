@extends('layouts.app')

@section('title', 'Panel Pasajero')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.85rem; font-weight: 800;">Panel del Pasajero</h1>
    <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.25rem;">
        Bienvenido/a, {{ $passenger->name }}. Solicita taxis en tiempo real en la provincia del Valle de Ubaté con estimación previa de tarifa.
    </p>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
    <!-- Conductores cercanos en Ubaté -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Taxis Disponibles Cercanos</h3>
            <span class="status-badge status-success">GPS Activo</span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.85rem;">
            @forelse($availableDrivers as $driver)
                <div style="display: flex; align-items: center; justify-content: space-between; background: rgba(15, 23, 42, 0.4); padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid var(--border-color);">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        @if($driver->photo_path)
                            <img src="{{ asset('storage/' . $driver->photo_path) }}" alt="{{ $driver->name }}" class="avatar">
                        @else
                            <div class="avatar">{{ substr($driver->name, 0, 1) }}</div>
                        @endif
                        <div>
                            <div style="font-weight: 600; font-size: 0.9rem;">{{ $driver->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">
                                Placa: {{ $driver->vehicle ? $driver->vehicle->license_plate : 'En proceso' }} | {{ $driver->vehicle ? $driver->vehicle->model : '' }}
                            </div>
                        </div>
                    </div>
                    <span class="status-badge status-success">Disponible</span>
                </div>
            @empty
                <p style="color: var(--text-muted); text-align: center; padding: 1rem;">No hay taxis disponibles en este instante en la zona.</p>
            @endforelse
        </div>
    </div>

    <!-- Historial de Viajes del Pasajero -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mis Viajes Recientes</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Origen / Destino</th>
                        <th>Tarifa Est.</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trips as $trip)
                        <tr>
                            <td>
                                <div style="font-weight: 600; font-size: 0.88rem;">{{ $trip->origin_address }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">➔ {{ $trip->destination_address }} ({{ $trip->distance_km }} km)</div>
                            </td>
                            <td style="font-weight: 700; color: var(--primary);">${{ number_format($trip->estimated_fare, 0, ',', '.') }}</td>
                            <td>
                                @if($trip->status === 'completado')
                                    <span class="status-badge status-success">Completado</span>
                                @elseif($trip->status === 'en_camino')
                                    <span class="status-badge status-warning">En camino</span>
                                @else
                                    <span class="status-badge status-info">{{ ucfirst($trip->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 1.5rem;">No has realizado viajes aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
