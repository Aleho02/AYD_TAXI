@extends('layouts.app')

@section('title', 'Analítica Urbana y Demanda - TaxiUbaté')

@section('content')
<style>
    .analytics-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1.5rem;
        margin-bottom: 1.15rem;
        flex-wrap: wrap;
    }

    .an-kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.15rem;
        margin-bottom: 1.35rem;
    }

    .an-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.2rem 1.3rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .an-kpi-card.dark {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    .an-kpi-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        font-size: 0.66rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        color: #64748b;
        margin-bottom: 0.55rem;
    }

    .an-kpi-val {
        font-family: 'Outfit', sans-serif;
        font-size: 2.15rem;
        font-weight: 800;
        line-height: 1;
        letter-spacing: -0.8px;
        margin-bottom: 0.75rem;
    }

    .an-kpi-foot {
        padding-top: 0.65rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.7rem;
        color: #64748b;
    }

    .an-kpi-card.dark .an-kpi-foot {
        border-top-color: rgba(255, 255, 255, 0.1);
        color: #94a3b8;
    }

    .charts-split {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.35rem;
    }

    .od-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.55rem 0.25rem;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.76rem;
        gap: 0.5rem;
    }

    .od-item:last-child {
        border-bottom: none;
    }

    .normative-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.1rem;
        margin-bottom: 1.35rem;
    }

    .normative-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.1rem;
    }

    @media (max-width: 1150px) {
        .an-kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .charts-split, .normative-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- CABECERA ANALÍTICA URBANA Y DEMANDA -->
<div class="analytics-header">
    <div>
        <div style="font-size: 0.66rem; font-weight: 800; color: #ea580c; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 0.3rem;">
            <i class="bi bi-bar-chart-steps"></i> INTELIGENCIA DE MOVILIDAD PROVINCIAL (DATOS REALES BD)
        </div>
        <div style="display: flex; align-items: baseline; gap: 0.75rem; flex-wrap: wrap;">
            <h1 style="font-family: 'Outfit', sans-serif; font-size: 1.85rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px;">
                Analítica Urbana y Demanda
            </h1>
            <span style="font-size: 0.72rem; font-weight: 600; color: #64748b;">Métricas en Tiempo Real</span>
        </div>
        <p style="font-size: 0.82rem; color: #64748b; margin-top: 0.25rem; max-width: 620px;">
            Estadísticas calculadas directamente a partir de los viajes, distancias, tarifas y flota registrados en la base de datos.
        </p>
    </div>

    <div style="display: flex; gap: 0.5rem;">
        <button type="button" class="btn btn-outline btn-sm" onclick="window.print()">
            <i class="bi bi-download"></i> Exportar Informe
        </button>
    </div>
</div>

<!-- 4 TARJETAS KPI 100% REALES -->
<div class="an-kpi-grid">
    <div class="an-kpi-card">
        <div>
            <div class="an-kpi-top">
                <span>TOTAL VIAJES<br>REGISTRADOS</span>
                <i class="bi bi-taxi-front" style="color: #ea580c; font-size: 1rem;"></i>
            </div>
            <div style="display: flex; align-items: baseline; gap: 0.5rem;">
                <div class="an-kpi-val">{{ $stats['total_trips'] }}</div>
                <span class="status-badge status-success" style="font-size: 0.66rem;">{{ $stats['completed_trips'] }} Completados</span>
            </div>
        </div>
        <div class="an-kpi-foot">
            <span>En curso / solicitados:</span>
            <strong style="color: #0f172a;">{{ $stats['active_trips'] }}</strong>
        </div>
    </div>

    <div class="an-kpi-card">
        <div>
            <div class="an-kpi-top">
                <span>DISTANCIA RECORRIDA<br>TOTAL</span>
                <i class="bi bi-signpost-split" style="color: #0f172a; font-size: 1rem;"></i>
            </div>
            <div style="display: flex; align-items: baseline; gap: 0.35rem;">
                <div class="an-kpi-val">{{ number_format($stats['total_distance'], 1) }}</div>
                <span style="font-size: 0.8rem; color: #64748b; font-weight: 600;">km</span>
            </div>
        </div>
        <div class="an-kpi-foot">
            <span>Promedio por viaje:</span>
            <strong style="color: #0f172a;">{{ $stats['avg_distance'] }} km</strong>
        </div>
    </div>

    <div class="an-kpi-card">
        <div>
            <div class="an-kpi-top">
                <span>FLOTA Y CONDUCTORES<br>ACTIVOS</span>
                <i class="bi bi-car-front" style="color: #0f172a; font-size: 1rem;"></i>
            </div>
            <div style="display: flex; align-items: baseline; gap: 0.35rem;">
                <div class="an-kpi-val">{{ $stats['active_drivers'] }}</div>
                <span style="font-size: 0.78rem; color: #64748b; font-weight: 500;">/ {{ $stats['total_drivers'] }} conductores</span>
            </div>
        </div>
        <div class="an-kpi-foot">
            <span>Vehículos operativos:</span>
            <strong style="color: #047857;">{{ $stats['active_vehicles'] }} / {{ $stats['total_vehicles'] }}</strong>
        </div>
    </div>

    <div class="an-kpi-card dark">
        <div>
            <div class="an-kpi-top">
                <span style="color: #34d399;">INGRESOS REALES (COMPLETADOS)</span>
                <i class="bi bi-wallet2" style="color: #34d399; font-size: 1rem;"></i>
            </div>
            <div style="display: flex; align-items: baseline; gap: 0.35rem;">
                <div class="an-kpi-val" style="color: #ffffff; font-size: 1.8rem;">${{ number_format($stats['estimated_revenue'], 0, ',', '.') }}</div>
                <span style="font-size: 0.75rem; color: #34d399; font-weight: 700;">COP</span>
            </div>
        </div>
        <div class="an-kpi-foot">
            <span>Viajes cancelados:</span>
            <strong style="color: #ffffff;">{{ $stats['cancelled_trips'] }}</strong>
        </div>
    </div>
</div>

<!-- FILA CENTRAL: DISTRIBUCIÓN DE ESTADOS + ÚLTIMAS RUTAS ORIGEN-DESTINO REALES -->
<div class="charts-split">
    <div class="card" style="margin-bottom: 0; display: flex; flex-direction: column; justify-content: space-between;">
        <div>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.75rem;">
                <div>
                    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 700; color: #0f172a;">
                        <span style="color: #b45309;">■</span> Estado Real de Solicitudes y Despachos
                    </h3>
                    <p style="font-size: 0.73rem; color: #64748b; margin-top: 0.15rem;">
                        Proporción real de servicios completados, activos y cancelados en la base de datos.
                    </p>
                </div>
                <span class="status-badge status-info">Total: {{ $stats['total_trips'] }} viajes</span>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.85rem; margin: 1.25rem 0;">
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 1rem; text-align: center;">
                    <div style="font-size: 0.65rem; font-weight: 800; color: #047857;">COMPLETADOS</div>
                    <div style="font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800; color: #047857; margin: 0.25rem 0;">
                        {{ $stats['completed_trips'] }}
                    </div>
                    <div style="font-size: 0.68rem; color: #065f46;">Finalizados con éxito</div>
                </div>

                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 1rem; text-align: center;">
                    <div style="font-size: 0.65rem; font-weight: 800; color: #b45309;">ACTIVOS / EN COLA</div>
                    <div style="font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800; color: #92400e; margin: 0.25rem 0;">
                        {{ $stats['active_trips'] }}
                    </div>
                    <div style="font-size: 0.68rem; color: #b45309;">Solicitados o en camino</div>
                </div>

                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 10px; padding: 1rem; text-align: center;">
                    <div style="font-size: 0.65rem; font-weight: 800; color: #dc2626;">CANCELADOS</div>
                    <div style="font-family: 'Outfit', sans-serif; font-size: 1.8rem; font-weight: 800; color: #b91c1c; margin: 0.25rem 0;">
                        {{ $stats['cancelled_trips'] }}
                    </div>
                    <div style="font-size: 0.68rem; color: #dc2626;">Sin cobro</div>
                </div>
            </div>
        </div>

        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 9px; padding: 0.65rem 0.85rem; display: flex; align-items: center; justify-content: space-between; font-size: 0.74rem; color: #475569;">
            <span>Tarifa regulada: Base $5.000 COP + $1.500 COP / km (Mínimo $6.000 COP)</span>
            <strong style="color: #0f172a;">Distancia Total: {{ number_format($stats['total_distance'], 1) }} km</strong>
        </div>
    </div>

    <!-- Top Origen - Destino (O-D) Reales -->
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.25rem;">
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #0f172a;">
                ■ Rutas Origen - Destino Registradas ({{ $topRoutes->count() }})
            </h3>
            <span style="font-size: 0.64rem; font-weight: 800; color: #64748b; background: #f8fafc; border: 1px solid #e2e8f0; padding: 0.15rem 0.45rem; border-radius: 4px;">
                BD REAL
            </span>
        </div>
        <p style="font-size: 0.72rem; color: #64748b; margin-bottom: 0.75rem;">
            Últimos trayectos solicitados por los pasajeros en la plataforma
        </p>

        <div>
            @forelse($topRoutes as $idx => $routeTrip)
                <div class="od-item">
                    <div>
                        <span style="font-size: 0.68rem; font-weight: 800; color: #ea580c;">#{{ $idx + 1 }}</span>
                        <strong style="color: #0f172a;">{{ $routeTrip->origin_address }}</strong>
                        <div style="font-size: 0.7rem; color: #64748b;">→ {{ $routeTrip->destination_address }}</div>
                    </div>
                    <div style="text-align: right; white-space: nowrap;">
                        <strong>${{ number_format($routeTrip->estimated_fare, 0, ',', '.') }}</strong>
                        <div style="font-size: 0.66rem; color: #64748b;">{{ $routeTrip->distance_km }} km</div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 2rem 1rem; color: #64748b; font-size: 0.78rem;">
                    0 rutas registradas. Cuando un pasajero solicite un viaje, aparecerá aquí.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- SECCIÓN INFERIOR: MONITOREO REAL DE CONDUCTORES Y VEHÍCULOS -->
<div class="card" style="margin-bottom: 0;">
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 38px; height: 38px; border-radius: 9px; background: #0f172a; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                <i class="bi bi-bank"></i>
            </div>
            <div>
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                    Registro de Monitoreo de Conductores y Unidades en Base de Datos
                </h3>
                <p style="font-size: 0.73rem; color: #64748b;">
                    Estado actual de los conductores y vehículos registrados en el sistema
                </p>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>MÓVIL & PLACA</th>
                    <th>CONDUCTOR ACREDITADO</th>
                    <th>COORDENADAS GPS</th>
                    <th>ESTADO VEHÍCULO</th>
                    <th>DISPONIBILIDAD</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $driver)
                    <tr>
                        <td>
                            <strong style="color: #0f172a;">
                                {{ $driver->vehicle ? $driver->vehicle->license_plate : 'Sin vehículo' }}
                            </strong>
                        </td>
                        <td>{{ $driver->name }} ({{ $driver->email }})</td>
                        <td style="font-family: 'JetBrains Mono', monospace; font-size: 0.75rem;">
                            {{ $driver->latitude ? number_format($driver->latitude, 4) . ', ' . number_format($driver->longitude, 4) : 'Sin señal GPS' }}
                        </td>
                        <td>{{ $driver->vehicle ? ucfirst($driver->vehicle->status) : 'N/A' }}</td>
                        <td>
                            @if($driver->is_available)
                                <span style="color: #047857; font-weight: 700;">● Disponible</span>
                            @else
                                <span style="color: #dc2626; font-weight: 700;">● Inactivo / Off</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: #64748b;">
                            No hay conductores registrados en la base de datos (0 conductores).
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
