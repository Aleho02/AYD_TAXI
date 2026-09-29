@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.85rem; font-weight: 800;">Panel Central de Monitoreo (CMS)</h1>
    <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.25rem;">
        Control de flota geoespacial y trazabilidad de taxis en la provincia del Valle de Ubaté.
    </p>
</div>

<!-- Grid de Métricas Clave -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
    <div class="card" style="margin-bottom: 0;">
        <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Conductores Activos</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: var(--primary); margin-top: 0.5rem;">
            {{ $stats['active_drivers'] }} <span style="font-size: 1rem; color: var(--text-muted); font-weight: normal;">/ {{ $stats['total_drivers'] }}</span>
        </div>
        <span style="font-size: 0.8rem; color: #34d399;">● Conexión GPS continua</span>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Vehículos en Flota</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #60a5fa; margin-top: 0.5rem;">
            {{ $stats['active_vehicles'] }} <span style="font-size: 1rem; color: var(--text-muted); font-weight: normal;">/ {{ $stats['total_vehicles'] }}</span>
        </div>
        <span style="font-size: 0.8rem; color: var(--text-muted);">Taxis amarillos registrados</span>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Viajes Solicitados / Activos</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #fbbf24; margin-top: 0.5rem;">
            {{ $stats['active_trips'] }}
        </div>
        <span style="font-size: 0.8rem; color: var(--text-muted);">{{ $stats['completed_trips'] }} completados en total</span>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <span style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">Total Pasajeros</span>
        <div style="font-size: 2.2rem; font-weight: 800; color: #a78bfa; margin-top: 0.5rem;">
            {{ $stats['total_passengers'] }}
        </div>
        <span style="font-size: 0.8rem; color: var(--text-muted);">Usuarios en la aplicación móvil</span>
    </div>
</div>

<!-- Tablas Recientes -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(480px, 1fr)); gap: 1.5rem;">
    <!-- Últimos Viajes -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Últimos Viajes Registrados</h3>
            <span class="brand-badge">Tiempo Real</span>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Origen / Destino</th>
                        <th>Pasajero</th>
                        <th>Tarifa Est.</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTrips as $trip)
                        <tr>
                            <td>
                                <div style="font-weight: 600;">{{ $trip->origin_address }}</div>
                                <div style="font-size: 0.78rem; color: var(--text-muted);">➔ {{ $trip->destination_address }} ({{ $trip->distance_km }} km)</div>
                            </td>
                            <td>{{ $trip->passenger ? $trip->passenger->name : 'N/A' }}</td>
                            <td style="font-weight: 700; color: var(--primary);">${{ number_format($trip->estimated_fare, 0, ',', '.') }} COP</td>
                            <td>
                                @if($trip->status === 'completado')
                                    <span class="status-badge status-success">Completado</span>
                                @elseif($trip->status === 'en_camino')
                                    <span class="status-badge status-warning">En camino</span>
                                @elseif($trip->status === 'aceptado')
                                    <span class="status-badge status-info">Aceptado</span>
                                @else
                                    <span class="status-badge status-danger">{{ ucfirst($trip->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted);">No hay viajes registrados aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Conductores en Servicio -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Conductores en Servicio</h3>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary btn-sm">Ver Todos</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Conductor</th>
                        <th>Placa Taxi</th>
                        <th>GPS Ubaté</th>
                        <th>Disponibilidad</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($drivers as $driver)
                        <tr>
                            <td style="display: flex; align-items: center; gap: 0.75rem;">
                                @if($driver->photo_path)
                                    <img src="{{ asset('storage/' . $driver->photo_path) }}" alt="{{ $driver->name }}" class="avatar">
                                @else
                                    <div class="avatar">{{ substr($driver->name, 0, 1) }}</div>
                                @endif
                                <div>
                                    <div style="font-weight: 600;">{{ $driver->name }}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">Lic: {{ $driver->license_number ?? 'Pendiente' }}</div>
                                </div>
                            </td>
                            <td>
                                @if($driver->vehicle)
                                    <span style="font-weight: 700; background: #fbbf24; color: #000; padding: 0.15rem 0.45rem; border-radius: 4px; font-size: 0.8rem;">
                                        {{ $driver->vehicle->license_plate }}
                                    </span>
                                @else
                                    <span style="color: var(--text-muted); font-size: 0.8rem;">Sin vehículo</span>
                                @endif
                            </td>
                            <td style="font-size: 0.82rem; color: var(--text-muted);">
                                @if($driver->latitude && $driver->longitude)
                                    📍 {{ number_format($driver->latitude, 4) }}, {{ number_format($driver->longitude, 4) }}
                                @else
                                    Sin señal
                                @endif
                            </td>
                            <td>
                                @if($driver->is_available)
                                    <span class="status-badge status-success">Disponible</span>
                                @else
                                    <span class="status-badge status-danger">Ocupado / Off</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted);">No hay conductores registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
