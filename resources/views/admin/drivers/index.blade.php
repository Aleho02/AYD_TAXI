@extends('layouts.app')

@section('title', 'Gestión de Conductores')

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h2 class="card-title">Gestión de Conductores</h2>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-top: 0.25rem;">
                Administración de conductores, fotos de perfil y licencias para servicio en Ubaté
            </p>
        </div>
        <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary">
            + Nuevo Conductor
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nombre Conductor</th>
                    <th>Email / Teléfono</th>
                    <th>Licencia</th>
                    <th>Taxi Asignado</th>
                    <th>Disponibilidad</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $driver)
                    <tr>
                        <td>
                            @if($driver->photo_path)
                                <img src="{{ asset('storage/' . $driver->photo_path) }}" alt="{{ $driver->name }}" class="avatar">
                            @else
                                <div class="avatar" style="background-color: #475569;">
                                    {{ strtoupper(substr($driver->name, 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ $driver->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">
                                GPS: {{ $driver->latitude ? number_format($driver->latitude, 4) . ', ' . number_format($driver->longitude, 4) : 'Sin telemetría' }}
                            </div>
                        </td>
                        <td>
                            <div>{{ $driver->email }}</div>
                            <div style="font-size: 0.78rem; color: var(--text-muted);">{{ $driver->phone ?? 'Sin teléfono' }}</div>
                        </td>
                        <td>
                            <span style="font-family: monospace; background: rgba(255, 255, 255, 0.08); padding: 0.2rem 0.45rem; border-radius: 4px; font-size: 0.82rem;">
                                {{ $driver->license_number ?? 'Pendiente' }}
                            </span>
                        </td>
                        <td>
                            @if($driver->vehicle)
                                <span style="font-weight: 800; background: #fbbf24; color: #000; padding: 0.15rem 0.45rem; border-radius: 4px; font-size: 0.8rem;">
                                    {{ $driver->vehicle->license_plate }}
                                </span>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.82rem;">Sin vehículo</span>
                            @endif
                        </td>
                        <td>
                            @if($driver->is_available)
                                <span class="status-badge status-success">Disponible</span>
                            @else
                                <span class="status-badge status-danger">Inactivo / Off</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 0.5rem;">
                                <a href="{{ route('admin.drivers.edit', $driver) }}" class="btn btn-secondary btn-sm">Editar / Foto</a>
                                <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST" onsubmit="return confirm('¿Eliminar conductor y su fotografía?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">No hay conductores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.25rem;">
        {{ $drivers->links() }}
    </div>
</div>
@endsection
