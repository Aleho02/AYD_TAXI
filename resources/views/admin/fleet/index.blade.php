@extends('layouts.app')

@section('title', 'Gestión de Flota de Taxis')

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h2 class="card-title">Gestión de Flota de Taxis</h2>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-top: 0.25rem;">Parque automotor autorizado en la provincia de Ubaté</p>
        </div>
        <a href="{{ route('admin.fleet.create') }}" class="btn btn-primary">
            + Registrar Vehículo
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Marca y Modelo</th>
                    <th>Año</th>
                    <th>Conductor Asignado</th>
                    <th>Estado</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                    <tr>
                        <td>
                            <span style="font-weight: 800; background: #fbbf24; color: #000; padding: 0.2rem 0.55rem; border-radius: 4px; font-size: 0.85rem; letter-spacing: 0.5px;">
                                {{ $vehicle->license_plate }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Color: {{ $vehicle->color }}</div>
                        </td>
                        <td>{{ $vehicle->year }}</td>
                        <td>
                            @if($vehicle->driver)
                                <div>{{ $vehicle->driver->name }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $vehicle->driver->phone ?? 'Sin teléfono' }}</div>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.82rem;">Sin conductor asignado</span>
                            @endif
                        </td>
                        <td>
                            @if($vehicle->status === 'operativo')
                                <span class="status-badge status-success">Operativo</span>
                            @elseif($vehicle->status === 'mantenimiento')
                                <span class="status-badge status-warning">Mantenimiento</span>
                            @else
                                <span class="status-badge status-danger">Inactivo</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 0.5rem;">
                                <a href="{{ route('admin.fleet.edit', $vehicle) }}" class="btn btn-secondary btn-sm">Editar</a>
                                <form action="{{ route('admin.fleet.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('¿Seguro de retirar este vehículo de la flota?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">No hay vehículos registrados en la flota.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.25rem;">
        {{ $vehicles->links() }}
    </div>
</div>
@endsection
