@extends('layouts.app')

@section('title', 'Parque Automotor y Flota - TaxiUbaté')

@section('content')
<div style="display: flex; align-items: flex-end; justify-content: space-between; gap: 1.5rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
    <div>
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.4rem;">
            <span style="font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.7px; color: #b45309;">PARQUE AUTOMOTOR OFICIAL</span>
            <span style="font-size: 0.7rem; font-weight: 600; color: #475569; padding-left: 0.75rem; border-left: 2px solid #cbd5e1;">Padrón Vehicular Homologado STTU</span>
        </div>
        <h1 style="font-family: 'Outfit', sans-serif; font-size: 1.85rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px;">
            Gestión de Flota de Taxis y Tarjetas de Operación
        </h1>
        <p style="font-size: 0.84rem; color: #64748b; margin-top: 0.35rem;">
            Control de vehículos amarillos autorizados, placas oficiales y asignación de conductores en la provincia de Ubaté.
        </p>
    </div>

    <div style="display: flex; align-items: center; gap: 0.6rem;">
        <a href="{{ route('admin.drivers.index') }}" class="btn btn-outline">
            <i class="bi bi-people"></i> Ver Padrón de Conductores
        </a>
        <a href="{{ route('admin.fleet.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> + Registrar Vehículo
        </a>
    </div>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1rem 1.35rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9;">
        <div style="display: flex; align-items: center; gap: 0.65rem;">
            <h3 style="font-size: 1.02rem; font-weight: 700; color: #0f172a;">Unidades Registradas en Flota</h3>
            <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 0.7rem; font-weight: 700; padding: 0.2rem 0.55rem; border-radius: 6px;">
                {{ $vehicles->total() }} Vehículos en BD
            </span>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>PLACA OFICIAL</th>
                    <th>MARCA Y MODELO</th>
                    <th>AÑO / COLOR</th>
                    <th>CONDUCTOR ASIGNADO</th>
                    <th>CONFORMIDAD T.O.</th>
                    <th>ESTADO OPERATIVO</th>
                    <th style="text-align: right;">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                    <tr>
                        <td>
                            <div class="plate-badge">
                                <span class="plate-col">COL</span>
                                <span>{{ $vehicle->license_plate }}</span>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 700; color: #0f172a;">{{ $vehicle->brand }} {{ $vehicle->model }}</div>
                            <div style="font-size: 0.74rem; color: #64748b;">Móvil #0{{ 20 + $vehicle->id }} • Servicio Público</div>
                        </td>
                        <td>
                            <div style="font-weight: 600;">{{ $vehicle->year }}</div>
                            <div style="font-size: 0.74rem; color: #64748b;">Color: {{ $vehicle->color }}</div>
                        </td>
                        <td>
                            @if($vehicle->driver)
                                <div style="font-weight: 700; color: #0f172a;">{{ $vehicle->driver->name }}</div>
                                <div style="font-size: 0.74rem; color: #64748b;">{{ $vehicle->driver->phone ?? 'Lic: ' . ($vehicle->driver->license_number ?? 'Vigente') }}</div>
                            @else
                                <span style="color: #94a3b8; font-size: 0.8rem;">Sin conductor asignado</span>
                            @endif
                        </td>
                        <td>
                            <span style="background: #dcfce7; color: #15803d; font-size: 0.68rem; font-weight: 700; padding: 0.2rem 0.5rem; border-radius: 5px;">
                                ● SOAT & T.O. Vigente
                            </span>
                        </td>
                        <td>
                            @if($vehicle->status === 'operativo')
                                <span class="status-badge status-success">● Operativo</span>
                            @elseif($vehicle->status === 'mantenimiento')
                                <span class="status-badge status-warning">● Mantenimiento</span>
                            @else
                                <span class="status-badge status-danger">● Inactivo</span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 0.45rem;">
                                <a href="{{ route('admin.fleet.edit', $vehicle) }}" class="btn btn-outline btn-sm">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                                <form action="{{ route('admin.fleet.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('¿Seguro de retirar este vehículo de la flota?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash3"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #64748b; padding: 2rem;">No hay vehículos registrados en la flota.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($vehicles->hasPages())
        <div style="padding: 1rem 1.35rem; border-top: 1px solid #f1f5f9;">
            {{ $vehicles->links() }}
        </div>
    @endif
</div>
@endsection
