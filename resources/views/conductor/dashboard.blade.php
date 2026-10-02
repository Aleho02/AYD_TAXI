@extends('layouts.app')

@section('title', 'Panel Conductor')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.85rem; font-weight: 800;">Panel del Conductor</h1>
    <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.25rem;">
        Bienvenido, {{ $driver->name }}. Transmisión de ubicación en tiempo real en Valle de Ubaté.
    </p>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <!-- Perfil del Conductor -->
    <div class="card">
        <div style="text-align: center; padding-bottom: 1.25rem; border-bottom: 1px solid var(--border-color); margin-bottom: 1.25rem;">
            @if($driver->photo_path)
                <img src="{{ asset('storage/' . $driver->photo_path) }}" alt="{{ $driver->name }}" style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary); margin: 0 auto 0.75rem;">
            @else
                <div style="width: 90px; height: 90px; border-radius: 50%; background: #334155; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; color: #fff; margin: 0 auto 0.75rem;">
                    <i class="bi bi-taxi-front-fill" style="color: var(--primary);"></i>
                </div>
            @endif
            <h3 style="font-size: 1.25rem; font-weight: 700;">{{ $driver->name }}</h3>
            <span class="role-tag role-conductor">Conductor Autorizado</span>
        </div>

        <div style="font-size: 0.9rem; display: flex; flex-direction: column; gap: 0.75rem;">
            <div>
                <span style="color: var(--text-muted);">Licencia:</span>
                <span style="font-weight: 600; font-family: monospace;">{{ $driver->license_number ?? 'Pendiente' }}</span>
            </div>
            <div>
                <span style="color: var(--text-muted);">Taxi Asignado:</span>
                @if($driver->vehicle)
                    <span style="background: #fbbf24; color: #000; font-weight: 800; padding: 0.15rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                        {{ $driver->vehicle->license_plate }} ({{ $driver->vehicle->brand }} {{ $driver->vehicle->model }})
                    </span>
                @else
                    <span style="color: #f87171;">Sin vehículo asignado</span>
                @endif
            </div>
            <div>
                <span style="color: var(--text-muted);">Disponibilidad:</span>
                @if($driver->is_available)
                    <span class="status-badge status-success">En Servicio (Disponible)</span>
                @else
                    <span class="status-badge status-danger">Fuera de Línea</span>
                @endif
            </div>
            <div>
                <span style="color: var(--text-muted);">Última Telemetría GPS:</span>
                <div style="font-family: monospace; font-size: 0.8rem; background: rgba(0,0,0,0.3); padding: 0.4rem; border-radius: 6px; margin-top: 0.25rem;">
                    Lat: {{ $driver->latitude ?? '5.3114' }} | Lng: {{ $driver->longitude ?? '-73.8182' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Servicios y Solicitudes Disponibles -->
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Solicitudes de Viajes Pendientes</h3>
                <span class="status-badge status-warning">Valle de Ubaté</span>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Origen <i class="bi bi-arrow-right"></i> Destino</th>
                            <th>Distancia</th>
                            <th>Tarifa</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($availableTrips as $trip)
                            <tr>
                                <td>
                                    <div style="font-weight: 600;">{{ $trip->origin_address }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">Hacia: {{ $trip->destination_address }}</div>
                                </td>
                                <td>{{ $trip->distance_km }} km</td>
                                <td style="color: var(--primary); font-weight: 700;">${{ number_format($trip->estimated_fare, 0, ',', '.') }}</td>
                                <td><span class="status-badge status-warning">Esperando taxi</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 1.5rem;">No hay solicitudes pendientes en este momento.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mis Viajes Asignados</h3>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Origen <i class="bi bi-arrow-right"></i> Destino</th>
                            <th>Valor</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trips as $myTrip)
                            <tr>
                                <td style="font-size: 0.8rem; color: var(--text-muted);">{{ $myTrip->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $myTrip->origin_address }} <i class="bi bi-arrow-right"></i> {{ $myTrip->destination_address }}</td>
                                <td style="color: var(--primary); font-weight: 700;">${{ number_format($myTrip->estimated_fare, 0, ',', '.') }}</td>
                                <td><span class="status-badge status-info">{{ ucfirst($myTrip->status) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 1.5rem;">No tienes viajes asignados actualmente.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
