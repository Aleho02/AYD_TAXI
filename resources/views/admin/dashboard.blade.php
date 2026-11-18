@extends('layouts.app')

@section('title', 'Monitoreo y Despacho - Central de Control')

@section('content')
<style>
    .kpi-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.15rem;
        margin-bottom: 1.35rem;
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem 1.25rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
    }

    .kpi-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.5rem;
        margin-bottom: 0.65rem;
    }

    .kpi-label {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        line-height: 1.25;
    }

    .kpi-pill {
        font-size: 0.66rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 6px;
        white-space: nowrap;
        line-height: 1.2;
        text-align: right;
    }

    .kpi-pill-green {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
    }

    .kpi-pill-amber {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    .kpi-value-row {
        display: flex;
        align-items: baseline;
        gap: 0.45rem;
        margin-bottom: 0.85rem;
    }

    .kpi-big-num {
        font-family: 'Outfit', sans-serif;
        font-size: 2.25rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
        letter-spacing: -1px;
    }

    .kpi-unit {
        font-size: 0.78rem;
        color: #64748b;
        font-weight: 500;
    }

    .kpi-footer-box {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 9px;
        padding: 0.55rem 0.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.72rem;
        color: #475569;
    }

    .dispatch-split {
        display: grid;
        grid-template-columns: 1fr 375px;
        gap: 1.25rem;
        margin-bottom: 1.35rem;
    }

    .gis-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem 1.25rem;
        display: flex;
        flex-direction: column;
    }

    .gis-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 0.75rem;
    }

    .gis-title-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-family: 'Outfit', sans-serif;
        font-size: 0.98rem;
        font-weight: 700;
        color: #0f172a;
    }

    .gis-subtitle {
        font-size: 0.72rem;
        color: #64748b;
        margin-left: 1.1rem;
        margin-top: 0.15rem;
    }

    .gis-layers {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        margin-bottom: 0.85rem;
    }

    .layer-btn {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 7px;
        padding: 0.32rem 0.65rem;
        font-size: 0.72rem;
        font-weight: 600;
        color: #334155;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .layer-btn.active {
        background: #ffffff;
        border-color: #cbd5e1;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06);
        color: #0f172a;
    }

    .gis-map-viewport {
        position: relative;
        width: 100%;
        height: 430px;
        background: linear-gradient(145deg, #eef2ff 0%, #f1f5f9 45%, #e8eef5 100%);
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .gis-grid-overlay {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(to right, rgba(148, 163, 184, 0.14) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(148, 163, 184, 0.14) 1px, transparent 1px);
        background-size: 48px 48px;
        pointer-events: none;
    }

    .map-road-label {
        position: absolute;
        background: rgba(255, 255, 255, 0.92);
        border: 1px solid #cbd5e1;
        padding: 0.22rem 0.6rem;
        border-radius: 6px;
        font-size: 0.68rem;
        font-weight: 600;
        color: #334155;
        pointer-events: none;
    }

    .map-center-tag {
        position: absolute;
        top: 45%;
        left: 52%;
        transform: translate(-50%, -50%);
        background: #0f172a;
        color: #ffffff;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        padding: 0.2rem 0.55rem;
        border-radius: 4px;
        z-index: 4;
    }

    .map-taxi-marker {
        position: absolute;
        background: #ffffff;
        border: 1.5px solid #0f172a;
        border-radius: 999px;
        padding: 0.2rem 0.55rem;
        font-size: 0.68rem;
        font-weight: 800;
        color: #0f172a;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        box-shadow: 0 3px 8px rgba(15, 23, 42, 0.14);
        z-index: 6;
    }

    .gis-bottom-bar {
        position: absolute;
        bottom: 10px;
        left: 12px;
        right: 12px;
        background: rgba(255, 255, 255, 0.94);
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.42rem 0.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.68rem;
        font-weight: 600;
        color: #334155;
        z-index: 10;
    }

    .queue-column {
        display: flex;
        flex-direction: column;
        gap: 0.9rem;
    }

    .queue-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .urgent-dispatch-box {
        background: #fffcf7;
        border: 1.5px solid #fed7aa;
        border-radius: 12px;
        padding: 0.9rem;
        margin-top: 0.65rem;
        margin-bottom: 0.75rem;
    }

    .secondary-queue-item {
        padding: 0.7rem 0.25rem;
        border-top: 1px solid #f1f5f9;
        font-size: 0.75rem;
    }

    .stream-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem 1.35rem;
    }

    .stream-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 0.9rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .stream-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.68rem 0.35rem;
        border-bottom: 1px solid #f8fafc;
        font-size: 0.8rem;
        gap: 1rem;
    }

    .stream-row:last-child {
        border-bottom: none;
    }

    @media (max-width: 1200px) {
        .kpi-grid-4 {
            grid-template-columns: repeat(2, 1fr);
        }
        .dispatch-split {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- 4 TARJETAS KPI 100% REALES DESDE BASE DE DATOS -->
<div class="kpi-grid-4">
    <!-- 1. Flota Conectada -->
    <div class="kpi-card">
        <div>
            <div class="kpi-top">
                <div class="kpi-label">
                    <i class="bi bi-taxi-front" style="color: #10b981; font-size: 0.9rem;"></i>
                    <span>FLOTA<br>CONECTADA</span>
                </div>
                <span class="kpi-pill kpi-pill-green">
                    {{ $stats['total_drivers'] }} Registrados
                </span>
            </div>
            <div class="kpi-value-row">
                <span class="kpi-big-num">{{ $stats['active_drivers'] }}</span>
                <span class="kpi-unit">conductores disponibles</span>
            </div>
        </div>
        <div class="kpi-footer-box">
            <div><strong style="color: #0f172a;">{{ $stats['active_vehicles'] }}</strong><br><span style="font-size: 0.66rem;">Vehículos Op.</span></div>
            <div><strong style="color: #0f172a;">{{ $stats['total_vehicles'] }}</strong><br><span style="font-size: 0.66rem;">Total Flota</span></div>
            <div><strong style="color: #ea580c;">{{ $stats['inactive_drivers'] }}</strong><br><span style="font-size: 0.66rem; color: #ea580c;">En Pausa</span></div>
        </div>
    </div>

    <!-- 2. Servicios Activos -->
    <div class="kpi-card">
        <div>
            <div class="kpi-top">
                <div class="kpi-label">
                    <i class="bi bi-sign-turn-right" style="color: #d97706; font-size: 0.9rem;"></i>
                    <span>SERVICIOS<br>ACTIVOS</span>
                </div>
                <span class="kpi-pill kpi-pill-amber">
                    ● {{ $stats['requested_trips'] }} Solicitados
                </span>
            </div>
            <div class="kpi-value-row">
                <span class="kpi-big-num">{{ $stats['active_trips'] }}</span>
                <span class="kpi-unit">carreras vivas</span>
            </div>
        </div>
        <div class="kpi-footer-box">
            <span>Viajes Completados: <strong style="color: #0f172a;">{{ $stats['completed_trips'] }}</strong></span>
            <strong style="color: #047857; font-size: 0.76rem;">Total: {{ $stats['total_trips'] }}</strong>
        </div>
    </div>

    <!-- 3. Tasa Despacho Directo -->
    <div class="kpi-card">
        <div>
            <div class="kpi-top">
                <div class="kpi-label">
                    <i class="bi bi-check2-circle" style="color: #10b981; font-size: 0.9rem;"></i>
                    <span>TASA<br>DESPACHO<br>DIRECTO</span>
                </div>
                <span class="kpi-pill kpi-pill-green">
                    Sin Comisión
                </span>
            </div>
            <div class="kpi-value-row">
                <span class="kpi-big-num">{{ $stats['dispatch_rate'] }}%</span>
                <span class="kpi-unit">efectividad real</span>
            </div>
        </div>
        <div class="kpi-footer-box">
            <span>Cancelados: <strong style="color: #dc2626;">{{ $stats['cancelled_trips'] }}</strong></span>
            <span>En Ruta: <strong style="color: #0f172a;">{{ $stats['in_progress_trips'] }}</strong></span>
        </div>
    </div>

    <!-- 4. Facturación & Pasajeros -->
    <div class="kpi-card">
        <div>
            <div class="kpi-top">
                <div class="kpi-label">
                    <i class="bi bi-shield-check" style="color: #0f172a; font-size: 0.9rem;"></i>
                    <span>RECAUDO &<br>PASAJEROS</span>
                </div>
                <span class="kpi-pill kpi-pill-green">
                    ● {{ $stats['total_passengers'] }} Pasajeros
                </span>
            </div>
            <div class="kpi-value-row">
                <span class="kpi-big-num" style="font-size: 1.85rem;">${{ number_format($stats['estimated_revenue'], 0, ',', '.') }}</span>
                <span class="kpi-unit">COP</span>
            </div>
        </div>
        <div class="kpi-footer-box" style="background: #f0fdf4; border-color: #bbf7d0;">
            <span>Distancia acumulada:</span>
            <strong style="color: #047857; font-size: 0.76rem;">{{ number_format($stats['total_distance'], 1) }} km</strong>
        </div>
    </div>
</div>

<!-- SECCIÓN CENTRAL: MAPA GIS SATELITAL + COLA DE DESPACHO INMEDIATO REAL -->
<div class="dispatch-split">
    <!-- Mapa GIS -->
    <div class="gis-card">
        <div class="gis-header">
            <div>
                <div class="gis-title-row">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                    <span>Provincia del Valle de Ubaté — GIS Satelital Telemetría (Datos Reales)</span>
                </div>
                <div class="gis-subtitle">
                    Conductores activos en BD: {{ $stats['active_drivers'] }} • Solicitudes activas: {{ $stats['active_trips'] }}
                </div>
            </div>
            <div style="display: flex; gap: 0.4rem;">
                <a href="{{ route('admin.drivers.index') }}" class="btn btn-outline btn-sm">Conductores ({{ $stats['total_drivers'] }})</a>
                <a href="{{ route('admin.fleet.index') }}" class="btn btn-outline btn-sm">Flota ({{ $stats['total_vehicles'] }})</a>
            </div>
        </div>

        <div class="gis-layers">
            <button type="button" class="layer-btn active">
                <i class="bi bi-fire" style="color: #ea580c;"></i> Demanda ({{ $stats['active_trips'] }})
            </button>
            <button type="button" class="layer-btn">
                <i class="bi bi-car-front" style="color: #10b981;"></i> Unidades en Línea ({{ $stats['active_drivers'] }})
            </button>
            <button type="button" class="layer-btn">
                <i class="bi bi-signpost-split" style="color: #64748b;"></i> Troncal 45A
            </button>
        </div>

        <div style="position: relative; border-radius: 12px; overflow: hidden; border: 1px solid #cbd5e1; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
            <div id="adminGisMap" style="width: 100%; height: 420px; z-index: 1;"></div>
            <div class="gis-bottom-bar" style="position: absolute; bottom: 0; left: 0; right: 0; z-index: 1000; background: rgba(15, 23, 42, 0.9); color: #fff; padding: 0.5rem 1rem; backdrop-filter: blur(4px);">
                <div style="display: flex; align-items: center; gap: 0.85rem; font-size: 0.73rem;">
                    <span><span style="color: #10b981;">●</span> Disponible ({{ $stats['active_drivers'] }})</span>
                    <span><span style="color: #d97706;">●</span> En Carrera ({{ $stats['in_progress_trips'] }})</span>
                    <span><span style="color: #2563eb;">●</span> Solicitados ({{ $stats['requested_trips'] }})</span>
                </div>
                <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.65rem; color: #94a3b8;">
                    Monitoreo Satelital en Tiempo Real • Valle de Ubaté
                </div>
            </div>
        </div>
    </div>

    <!-- Columna Derecha: Cola de Despacho Inmediato (100% Real desde Base de Datos) -->
    <div class="queue-column">
        <div class="queue-card">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.35rem;">
                <div style="display: flex; align-items: center; gap: 0.45rem; font-family: 'Outfit', sans-serif; font-size: 0.98rem; font-weight: 700; color: #0f172a;">
                    <i class="bi bi-lightning-charge-fill" style="color: #ea580c;"></i>
                    <span>Cola de Despacho<br>Inmediato</span>
                </div>
                <div style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 0.68rem; font-weight: 700; padding: 0.22rem 0.55rem; border-radius: 6px; text-align: center;">
                    {{ $pendingTrips->count() }}<br>Solicitudes
                </div>
            </div>
            <p style="font-size: 0.7rem; color: #64748b; line-height: 1.35; margin-bottom: 0.5rem;">
                Solicitudes reales enviadas por los pasajeros desde el portal web o API móvil.
            </p>

            @if($pendingTrips->count() > 0)
                @php
                    $firstPending = $pendingTrips->first();
                @endphp

                <!-- Primera Solicitud Real Destacada -->
                <div class="urgent-dispatch-box">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem;">
                        <span style="background: #eff6ff; color: #1d4ed8; font-size: 0.64rem; font-weight: 800; padding: 0.18rem 0.45rem; border-radius: 4px;">
                            ! SERVICIO #TX-{{ $firstPending->id }} • {{ strtoupper(str_replace('_', ' ', $firstPending->status)) }}
                        </span>
                        <span style="font-size: 0.68rem; font-weight: 700; color: #d97706;">
                            {{ $firstPending->created_at ? $firstPending->created_at->diffForHumans() : 'Ahora' }}
                        </span>
                    </div>

                    <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.65rem;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: #0f172a; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                            <i class="bi bi-person"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; font-size: 0.84rem; color: #0f172a;">
                                {{ $firstPending->passenger ? $firstPending->passenger->name : 'Pasajero' }}
                            </div>
                            <div style="font-size: 0.7rem; color: #64748b;">
                                Origen: {{ $firstPending->origin_address }}
                            </div>
                        </div>
                    </div>

                    <div style="background: #ffffff; border: 1px solid #f1f5f9; border-radius: 8px; padding: 0.5rem 0.65rem; margin-bottom: 0.6rem; font-size: 0.74rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.25rem;">
                            <span style="color: #64748b;"><i class="bi bi-geo-alt" style="color: #ea580c;"></i> Destino:</span>
                            <strong style="color: #0f172a;">{{ $firstPending->destination_address }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: #64748b;">Tarifa ({{ $firstPending->distance_km }} km):</span>
                            <strong style="color: #047857; font-size: 0.82rem;">${{ number_format($firstPending->estimated_fare, 0, ',', '.') }} COP</strong>
                        </div>
                    </div>

                    <form action="{{ route('admin.trips.dispatch', $firstPending) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div style="margin-bottom: 0.55rem;">
                            <select name="driver_id" class="form-control" style="font-size: 0.75rem; padding: 0.4rem 0.6rem;">
                                <option value="">-- Asignar conductor disponible --</option>
                                @foreach($drivers as $drv)
                                    <option value="{{ $drv->id }}" {{ $firstPending->driver_id == $drv->id ? 'selected' : '' }}>
                                        {{ $drv->name }} {{ $drv->vehicle ? '(' . $drv->vehicle->license_plate . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                            <button type="submit" name="status" value="en_camino" class="btn btn-navy btn-sm" style="justify-content: center;">
                                <i class="bi bi-check-circle"></i> Despachar
                            </button>
                            <button type="submit" name="status" value="completado" class="btn btn-outline btn-sm" style="justify-content: center; color: #047857; border-color: #a7f3d0;">
                                <i class="bi bi-check2-all"></i> Completar
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Siguientes Solicitudes Reales en Cola -->
                @foreach($pendingTrips->skip(1) as $queuedTrip)
                    <div class="secondary-queue-item">
                        <div style="display: flex; justify-content: space-between; font-size: 0.65rem; font-weight: 700; color: #b45309; margin-bottom: 0.2rem;">
                            <span>SERVICIO #TX-{{ $queuedTrip->id }} • {{ strtoupper($queuedTrip->status) }}</span>
                            <span style="color: #64748b;">{{ $queuedTrip->distance_km }} km</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.15rem;">
                            <strong style="color: #0f172a; font-size: 0.8rem;">{{ $queuedTrip->passenger ? $queuedTrip->passenger->name : 'Pasajero' }}</strong>
                            <strong style="color: #047857; font-size: 0.8rem;">${{ number_format($queuedTrip->estimated_fare, 0, ',', '.') }} COP</strong>
                        </div>
                        <div style="font-size: 0.7rem; color: #64748b; margin-bottom: 0.45rem;">
                            {{ $queuedTrip->origin_address }} → {{ $queuedTrip->destination_address }}
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.68rem; color: #475569;">
                                Conductor: <strong>{{ $queuedTrip->driver ? $queuedTrip->driver->name : 'Sin asignar' }}</strong>
                            </span>
                            <form action="{{ route('admin.trips.dispatch', $queuedTrip) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="en_camino">
                                <button type="submit" class="btn btn-outline btn-sm" style="padding: 0.2rem 0.55rem; font-size: 0.68rem;">
                                    Despachar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div style="background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 11px; padding: 2rem 1rem; text-align: center; margin-top: 0.75rem;">
                    <i class="bi bi-inbox" style="font-size: 1.6rem; color: #94a3b8;"></i>
                    <div style="font-weight: 700; font-size: 0.84rem; color: #0f172a; margin-top: 0.45rem;">
                        0 Solicitudes Pendientes
                    </div>
                    <p style="font-size: 0.72rem; color: #64748b; margin-top: 0.25rem; line-height: 1.4;">
                        La cola está en cero. Cuando un pasajero seleccione y solicite una ruta, aparecerá aquí en tiempo real.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- BITÁCORA OPERATIVA & FLUJO DE EVENTOS EN TIEMPO REAL (100% REAL DE BD) -->
<div class="stream-card">
    <div class="stream-header">
        <div style="display: flex; align-items: center; gap: 0.85rem;">
            <i class="bi bi-hdd-network" style="font-size: 1.1rem; color: #0f172a;"></i>
            <div>
                <h3 style="font-size: 0.96rem; font-weight: 700; color: #0f172a;">
                    Bitácora Operativa & Flujo de Eventos en Tiempo Real ({{ $recentTrips->count() }} registros)
                </h3>
            </div>
            <span style="background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; font-size: 0.64rem; font-weight: 800; padding: 0.2rem 0.5rem; border-radius: 5px;">
                DATOS REALES BD
            </span>
        </div>

        <a href="{{ route('admin.audit') }}" class="btn btn-outline btn-sm">Ver Auditoría Completa</a>
    </div>

    <div>
        @forelse($recentTrips as $trip)
            <div class="stream-row">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.72rem; color: #64748b; font-weight: 600;">
                        {{ $trip->created_at ? $trip->created_at->format('H:i:s') : '--:--' }}
                    </span>
                    <span style="width: 24px; height: 24px; border-radius: 50%; background: {{ $trip->status === 'completado' ? '#ecfdf5' : ($trip->status === 'cancelado' ? '#fef2f2' : '#fffbeb') }}; color: {{ $trip->status === 'completado' ? '#047857' : ($trip->status === 'cancelado' ? '#dc2626' : '#d97706') }}; display: inline-flex; align-items: center; justify-content: center; font-size: 0.72rem;">
                        <i class="bi bi-taxi-front"></i>
                    </span>
                    <div>
                        <strong>#TX-{{ $trip->id }}</strong> •
                        Pasajero <strong>{{ $trip->passenger ? $trip->passenger->name : 'N/A' }}</strong>
                        registró ruta desde <strong>{{ $trip->origin_address }}</strong>
                        hacia <strong>{{ $trip->destination_address }}</strong>
                        ({{ $trip->distance_km }} km • <strong style="color: #047857;">${{ number_format($trip->estimated_fare, 0, ',', '.') }} COP</strong>)
                        — Conductor: <strong>{{ $trip->driver ? $trip->driver->name : 'Sin asignar' }}</strong>
                    </div>
                </div>
                <span class="status-badge {{ $trip->status === 'completado' ? 'status-success' : ($trip->status === 'cancelado' ? 'status-danger' : 'status-warning') }}">
                    {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                </span>
            </div>
        @empty
            <div style="text-align: center; padding: 2rem; color: #64748b; font-size: 0.84rem;">
                No hay viajes ni eventos registrados aún en la base de datos (0 registros).
            </div>
        @endforelse
    </div>
</div>

<script>
    const adminMap = L.map('adminGisMap').setView([5.3110, -73.8165], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap - Centro de Despacho Ubaté'
    }).addTo(adminMap);

    const driversGroup = L.layerGroup().addTo(adminMap);
    const tripsGroup = L.layerGroup().addTo(adminMap);

    function updateFleetOnMap(drivers, activeTrips) {
        driversGroup.clearLayers();
        tripsGroup.clearLayers();

        // 1. Renderizar conductores con coordenadas GPS reales
        if (drivers && drivers.length) {
            drivers.forEach(d => {
                if (!d.latitude || !d.longitude) return;

                const bg = d.is_available ? '#10b981' : '#64748b';
                const taxiIcon = L.divIcon({
                    className: '',
                    html: `<div style="background:${bg};color:#fff;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2.5px solid #fff;box-shadow:0 3px 8px rgba(0,0,0,0.35);font-size:15px;cursor:pointer;">
                            <i class="bi bi-taxi-front-fill"></i>
                           </div>`,
                    iconSize: [32, 32],
                    iconAnchor: [16, 16]
                });

                const m = L.marker([parseFloat(d.latitude), parseFloat(d.longitude)], { icon: taxiIcon });
                const plate = d.vehicle ? d.vehicle.license_plate : 'Sin placa';
                m.bindPopup(`
                    <div style="font-family:'Inter',sans-serif;font-size:0.75rem;line-height:1.4;">
                        <strong style="font-size:0.85rem;color:#0f172a;">🚖 ${d.name}</strong><br>
                        <span style="color:${d.is_available ? '#047857' : '#64748b'};font-weight:700;">● ${d.is_available ? 'Disponible' : 'En Pausa / Ocupado'}</span><br>
                        Placa: <strong>${plate}</strong><br>
                        ${d.vehicle ? 'Vehículo: ' + d.vehicle.brand + ' ' + d.vehicle.model : ''}<br>
                        ${d.phone ? 'Tel: ' + d.phone : ''}<br>
                        <span style="color:#64748b;font-size:0.68rem;">GPS: ${parseFloat(d.latitude).toFixed(4)}, ${parseFloat(d.longitude).toFixed(4)}</span>
                    </div>
                `);
                driversGroup.addLayer(m);
            });
        }

        // 2. Renderizar viajes activos
        if (activeTrips && activeTrips.length) {
            activeTrips.forEach(t => {
                if (!t.origin_latitude || !t.destination_latitude) return;

                const oLat = parseFloat(t.origin_latitude);
                const oLng = parseFloat(t.origin_longitude);
                const dLat = parseFloat(t.destination_latitude);
                const dLng = parseFloat(t.destination_longitude);

                const pIcon = L.divIcon({
                    className: '',
                    html: '<div style="background:#10b981;color:#fff;width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;font-weight:800;font-size:11px;">A</div>',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });

                const dIcon = L.divIcon({
                    className: '',
                    html: '<div style="background:#ef4444;color:#fff;width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;font-weight:800;font-size:11px;">B</div>',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });

                const mO = L.marker([oLat, oLng], { icon: pIcon });
                mO.bindPopup(`<b>Viaje #TX-${t.id} (Origen)</b><br>${t.origin_address}<br>Pasajero: ${t.passenger ? t.passenger.name : 'N/A'}`);
                tripsGroup.addLayer(mO);

                const mD = L.marker([dLat, dLng], { icon: dIcon });
                mD.bindPopup(`<b>Viaje #TX-${t.id} (Destino)</b><br>${t.destination_address}`);
                tripsGroup.addLayer(mD);

                const line = L.polyline([[oLat, oLng], [dLat, dLng]], {
                    color: t.status === 'en_camino' ? '#d97706' : '#2563eb',
                    weight: 3.5,
                    dashArray: '5, 5',
                    opacity: 0.8
                });
                tripsGroup.addLayer(line);
            });
        }
    }

    async function refreshFleetMap() {
        try {
            const res = await fetch('/geo/fleet');
            if (res.ok) {
                const data = await res.json();
                if (data.status === 'success') {
                    updateFleetOnMap(data.drivers, data.active_trips);
                }
            }
        } catch (e) {}
    }

    // Carga inicial
    refreshFleetMap();

    // Actualización continua cada 10 segundos
    setInterval(refreshFleetMap, 10000);
</script>
@endsection
