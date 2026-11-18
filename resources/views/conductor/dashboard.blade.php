@extends('layouts.app')

@section('title', 'Portal Conductor - TaxiUbaté')

@section('content')
<style>
    .driver-hero-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.15rem 1.4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.25rem;
        margin-bottom: 1.35rem;
        flex-wrap: wrap;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
    }

    .driver-hero-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .driver-photo-wrap {
        position: relative;
        width: 66px;
        height: 66px;
    }

    .driver-photo-img {
        width: 66px;
        height: 66px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        background: #0f172a;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        font-weight: 800;
    }

    .driver-verified-dot {
        position: absolute;
        bottom: -4px;
        right: -4px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #d97706;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.65rem;
        border: 2px solid #fff;
    }

    .driver-meta-pills {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin: 0.3rem 0;
        flex-wrap: wrap;
    }

    .c2-pill {
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 0.64rem;
        font-weight: 800;
        padding: 0.14rem 0.45rem;
        border-radius: 4px;
    }

    .movil-pill {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
        font-size: 0.64rem;
        font-weight: 800;
        padding: 0.14rem 0.45rem;
        border-radius: 4px;
    }

    .driver-hero-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .availability-switcher {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        padding: 0.22rem;
        display: inline-flex;
        align-items: center;
        gap: 0.2rem;
    }

    .avail-option {
        padding: 0.35rem 0.7rem;
        border-radius: 7px;
        font-size: 0.74rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border: none;
        background: transparent;
    }

    .avail-option.active {
        background: #0f172a;
        color: #ffffff;
        font-weight: 700;
    }

    .conductor-main-grid {
        display: grid;
        grid-template-columns: 1.35fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.35rem;
    }

    .exclusive-dispatch-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-top: 3px solid #f59e0b;
        border-radius: 14px;
        padding: 1.25rem 1.35rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .exclusive-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .exclusive-badge {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.2rem 0.55rem;
        border-radius: 5px;
    }

    .exclusive-body {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 1.15rem;
        margin-bottom: 1.1rem;
    }

    .route-timeline {
        margin-top: 0.85rem;
        padding-left: 0.25rem;
    }

    .route-point {
        position: relative;
        padding-left: 1.35rem;
        padding-bottom: 0.85rem;
        border-left: 2px dashed #cbd5e1;
    }

    .route-point:last-child {
        border-left-color: transparent;
        padding-bottom: 0;
    }

    .route-dot {
        position: absolute;
        left: -6px;
        top: 2px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #fff;
        border: 2.5px solid #d97706;
    }

    .net-fare-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 11px;
        padding: 0.95rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .contiguous-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.8rem 0.95rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.85rem;
        margin-bottom: 0.65rem;
    }

    .contiguous-num {
        width: 28px;
        height: 28px;
        border-radius: 7px;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.72rem;
        font-weight: 800;
        color: #0f172a;
        flex-shrink: 0;
    }

    .earnings-pair {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin: 0.85rem 0;
    }

    .earning-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.85rem;
    }

    .runt-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.65rem;
        margin-top: 0.85rem;
    }

    .runt-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        padding: 0.7rem;
    }

    @media (max-width: 1150px) {
        .conductor-main-grid, .exclusive-body {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- 1. BANNER PERFIL DEL CONDUCTOR (100% DATOS REALES DEL CONDUCTOR AUTENTICADO) -->
<div class="driver-hero-card">
    <div class="driver-hero-left">
        <div class="driver-photo-wrap">
            @if($driver->photo_path)
                <img src="{{ asset('storage/' . $driver->photo_path) }}" alt="{{ $driver->name }}" class="driver-photo-img">
            @else
                <div class="driver-photo-img">
                    {{ strtoupper(substr($driver->name, 0, 2)) }}
                </div>
            @endif
            <span class="driver-verified-dot"><i class="bi bi-shield-check"></i></span>
        </div>

        <div>
            <h1 style="font-family: 'Outfit', sans-serif; font-size: 1.28rem; font-weight: 800; color: #0f172a; line-height: 1.15;">
                {{ $driver->name }}
            </h1>
            <div class="driver-meta-pills">
                <span class="c2-pill">LICENCIA: {{ $driver->license_number ?? 'PENDIENTE' }}</span>
                @if($driver->vehicle)
                    <span class="movil-pill">{{ $driver->vehicle->license_plate }}</span>
                    <span style="font-size: 0.74rem; font-weight: 700; color: #0f172a;">
                        {{ $driver->vehicle->brand }} {{ $driver->vehicle->model }} ({{ $driver->vehicle->year }})
                    </span>
                @else
                    <span style="font-size: 0.74rem; color: #dc2626; font-weight: 600;">Sin vehículo asignado</span>
                @endif
            </div>
            <div style="font-size: 0.73rem; color: #64748b; font-weight: 600;">
                Servicios completados: <strong style="color: #0f172a;">{{ $driverStats['completed_trips'] }}</strong> •
                Tel: {{ $driver->phone ?? 'No registrado' }}
            </div>
        </div>
    </div>

    <div class="driver-hero-right">
        <form action="{{ route('conductor.availability') }}" method="POST" style="margin: 0;">
            @csrf
            @method('PATCH')
            <div class="availability-switcher">
                <button type="submit" name="is_available" value="1" class="avail-option {{ $driver->is_available ? 'active' : '' }}">
                    <span style="width: 7px; height: 7px; border-radius: 50%; background: #10b981;"></span> Disponible
                </button>
                <button type="submit" name="is_available" value="0" class="avail-option {{ !$driver->is_available ? 'active' : '' }}">
                    <span style="width: 7px; height: 7px; border-radius: 50%; background: #f59e0b;"></span> Ocupado / Pausa
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. GRID PRINCIPAL: DESPACHO + COLA (IZQUIERDA) Y LIQUIDACIÓN + RUNT (DERECHA) -->
<div class="conductor-main-grid" id="despacho-conductor">
    <!-- Columna Izquierda -->
    <div>
        <!-- Mapa Interactivo y Telemetría GPS en Vivo del Conductor -->
        <div class="card" style="margin-bottom: 1rem; padding: 1.1rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.65rem; flex-wrap: wrap; gap: 0.5rem;">
                <div>
                    <div style="font-size: 0.62rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">TELEMETRÍA GPS SATELITAL</div>
                    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 700; color: #0f172a; margin: 0;">
                        Mapa de Navegación en Tiempo Real
                    </h3>
                </div>
                <div style="display: flex; gap: 0.4rem; align-items: center;">
                    <button type="button" id="btnToggleGpsBroadcast" class="btn btn-sm" style="background: #10b981; color: #fff; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem;" onclick="toggleGpsBroadcast()">
                        <i class="bi bi-broadcast-pin"></i> <span id="gpsBroadcastLabel">Activar Transmisión GPS</span>
                    </button>
                    <button type="button" class="btn btn-sm" style="background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;" onclick="centerConductorMap()" title="Centrar en mi ubicación">
                        <i class="bi bi-crosshair"></i>
                    </button>
                </div>
            </div>
            <div id="conductorGpsAlert" style="display: none; padding: 0.45rem 0.75rem; border-radius: 6px; font-size: 0.73rem; margin-bottom: 0.5rem; font-weight: 600;"></div>
            <div id="conductorMap" style="width: 100%; height: 270px; border-radius: 10px; border: 1px solid #cbd5e1; z-index: 1;"></div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem; font-size: 0.72rem; color: #64748b; flex-wrap: wrap; gap: 0.3rem;">
                <span id="gpsCoordDisplay">GPS Actual: {{ $driver->latitude ? number_format($driver->latitude, 4) . ', ' . number_format($driver->longitude, 4) : '5.3114, -73.8182' }}</span>
                <span id="gpsLiveBadge" style="display: none; color: #047857; font-weight: 700;">
                    <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#10b981;margin-right:3px;"></span> Transmitiendo posición a la central
                </span>
            </div>
        </div>

        <!-- Tarjeta Despacho Exclusivo Asignado (Datos 100% Reales de $activeTrip) -->
        <div class="exclusive-dispatch-card">
            @if($activeTrip)
                <div class="exclusive-top">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <span class="exclusive-badge">
                            ● SERVICIO #TX-{{ $activeTrip->id }} ({{ strtoupper(str_replace('_', ' ', $activeTrip->status)) }})
                        </span>
                        <span style="font-size: 0.72rem; color: #64748b; font-weight: 600;">
                            {{ $activeTrip->created_at ? $activeTrip->created_at->diffForHumans() : 'Reciente' }}
                        </span>
                    </div>
                </div>

                <div class="exclusive-body">
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.65rem;">
                            <div style="width: 38px; height: 38px; border-radius: 50%; background: #f1f5f9; border: 1px solid #cbd5e1; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem; color: #0f172a;">
                                {{ $activeTrip->passenger ? strtoupper(substr($activeTrip->passenger->name, 0, 2)) : 'PA' }}
                            </div>
                            <div>
                                <strong style="font-size: 0.95rem; color: #0f172a;">
                                    {{ $activeTrip->passenger ? $activeTrip->passenger->name : 'Pasajero' }}
                                </strong>
                                <div style="font-size: 0.72rem; color: #64748b;">
                                    Tel: {{ ($activeTrip->passenger && $activeTrip->passenger->phone) ? $activeTrip->passenger->phone : 'Registrado en plataforma' }}
                                </div>
                            </div>
                        </div>

                        <div class="route-timeline">
                            <div class="route-point">
                                <span class="route-dot"></span>
                                <div style="font-size: 0.62rem; font-weight: 800; color: #64748b; text-transform: uppercase;">
                                    DIRECCIÓN DE ORIGEN (RECOGIDA)
                                </div>
                                <div style="font-size: 0.84rem; font-weight: 700; color: #0f172a; margin-top: 0.1rem;">
                                    {{ $activeTrip->origin_address }}
                                </div>
                            </div>

                            <div class="route-point">
                                <span class="route-dot" style="border-color: #64748b;"></span>
                                <div style="font-size: 0.62rem; font-weight: 800; color: #64748b; text-transform: uppercase;">
                                    DIRECCIÓN DE DESTINO ({{ $activeTrip->distance_km }} KM)
                                </div>
                                <div style="font-size: 0.84rem; font-weight: 700; color: #0f172a; margin-top: 0.1rem;">
                                    {{ $activeTrip->destination_address }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="net-fare-box">
                        <div>
                            <div style="font-size: 0.62rem; font-weight: 800; color: #64748b; text-transform: uppercase;">
                                TARIFA REGULADA NETA
                            </div>
                            <div style="font-family: 'Outfit', sans-serif; font-size: 1.85rem; font-weight: 800; color: #0f172a; line-height: 1.1; margin: 0.2rem 0;">
                                ${{ number_format($activeTrip->estimated_fare, 0, ',', '.') }}
                            </div>
                            <div style="font-size: 0.66rem; color: #64748b; margin-bottom: 0.45rem;">COP</div>

                            <div style="font-size: 0.68rem; font-weight: 700; color: #047857; margin-bottom: 0.3rem;">
                                <i class="bi bi-check-circle"></i> 100% Para el Conductor
                            </div>
                            <p style="font-size: 0.66rem; color: #64748b; line-height: 1.35;">
                                Distancia calculada: {{ $activeTrip->distance_km }} km.
                            </p>
                        </div>

                        <div style="text-align: right; font-size: 0.68rem; color: #475569; margin-top: 0.5rem; padding-top: 0.4rem; border-top: 1px solid #e2e8f0;">
                            PIN de Abordaje: <strong>{{ str_pad(($activeTrip->id * 137) % 10000, 4, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1.3fr; gap: 0.75rem;">
                    <form action="{{ route('conductor.trips.status', $activeTrip) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="cancelado">
                        <button type="submit" class="btn btn-outline" style="width: 100%; justify-content: center; padding: 0.68rem; color: #dc2626; border-color: #fecaca;">
                            <i class="bi bi-x-lg"></i> Rechazar / Cancelar
                        </button>
                    </form>

                    @if($activeTrip->status === 'solicitado')
                        <form action="{{ route('conductor.trips.accept', $activeTrip) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-navy" style="width: 100%; justify-content: center; padding: 0.68rem;">
                                <i class="bi bi-check2-circle"></i> Aceptar Carrera Inmediata
                            </button>
                        </form>
                    @else
                        <form action="{{ route('conductor.trips.status', $activeTrip) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completado">
                            <button type="submit" class="btn btn-navy" style="width: 100%; justify-content: center; padding: 0.68rem; background: #047857;">
                                <i class="bi bi-check2-all"></i> Finalizar Carrera (Completar)
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <div style="text-align: center; padding: 2rem 1rem;">
                    <i class="bi bi-broadcast" style="font-size: 2rem; color: #94a3b8;"></i>
                    <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 800; color: #0f172a; margin-top: 0.5rem;">
                        0 Despachos Activos en este Momento
                    </h3>
                    <p style="font-size: 0.78rem; color: #64748b; margin-top: 0.25rem; max-width: 420px; margin-left: auto; margin-right: auto;">
                        No hay servicios activos ni solicitados. Cuando un pasajero seleccione y solicite una ruta en la plataforma, aparecerá aquí inmediatamente.
                    </p>
                </div>
            @endif
        </div>

        <!-- Cola de Despacho en Cuadrantes (100% Real desde $availableTrips) -->
        <div class="card" id="cola-cuadrantes" style="margin-bottom: 1.25rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.9rem;">
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 0.96rem; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 0.45rem;">
                    <i class="bi bi-list-ul"></i> Solicitudes de Pasajeros en Cola
                </h3>
                <span style="background: #eff6ff; color: #1d4ed8; font-size: 0.68rem; font-weight: 700; padding: 0.18rem 0.55rem; border-radius: 6px;">
                    {{ $availableTrips->count() }} en espera
                </span>
            </div>

            @forelse($availableTrips as $idx => $trip)
                <div class="contiguous-item">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <span class="contiguous-num">0{{ $idx + 1 }}</span>
                        <div>
                            <div style="display: flex; align-items: center; gap: 0.45rem; flex-wrap: wrap;">
                                <strong style="font-size: 0.8rem; color: #0f172a;">{{ $trip->origin_address }}</strong>
                                <span style="background: #eff6ff; color: #1d4ed8; font-size: 0.64rem; font-weight: 700; padding: 0.1rem 0.4rem; border-radius: 4px;">
                                    Dist. {{ $trip->distance_km }} km
                                </span>
                            </div>
                            <div style="font-size: 0.72rem; color: #64748b; margin-top: 0.15rem;">
                                Pasajero: <strong>{{ $trip->passenger ? $trip->passenger->name : 'Pasajero' }}</strong> •
                                Destino: {{ $trip->destination_address }} • Tarifa: <strong>${{ number_format($trip->estimated_fare, 0, ',', '.') }} COP</strong>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; gap: 0.6rem; flex-shrink: 0;">
                        <form action="{{ route('conductor.trips.accept', $trip) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-primary btn-sm" style="font-weight: 700;">
                                Aceptar Servicio
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 1.5rem; color: #64748b; font-size: 0.8rem; background: #f8fafc; border-radius: 10px; border: 1px dashed #cbd5e1;">
                    0 solicitudes en espera en cola.
                </div>
            @endforelse
        </div>

        <!-- Historial de Mis Viajes Asignados ($trips de BD) -->
        <div class="card" id="mis-viajes-conductor" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <h4 style="font-family: 'Outfit', sans-serif; font-size: 0.92rem; font-weight: 700; color: #0f172a;">
                    Mis Servicios Asignados e Historial
                </h4>
                <span class="status-badge status-info">{{ $trips->total() }} servicios</span>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID / Fecha</th>
                            <th>Pasajero</th>
                            <th>Trayecto</th>
                            <th>Tarifa</th>
                            <th style="text-align: right;">Estado / Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trips as $myTrip)
                            <tr>
                                <td style="font-size: 0.75rem; color: #64748b;">
                                    <strong>#TX-{{ $myTrip->id }}</strong><br>
                                    {{ $myTrip->created_at ? $myTrip->created_at->format('d/m H:i') : '' }}
                                </td>
                                <td style="font-weight: 600;">{{ $myTrip->passenger ? $myTrip->passenger->name : 'Pasajero' }}</td>
                                <td style="font-size: 0.76rem;">
                                    <strong>{{ $myTrip->origin_address }}</strong><br>
                                    → {{ $myTrip->destination_address }} ({{ $myTrip->distance_km }} km)
                                </td>
                                <td style="font-weight: 700; color: #047857;">${{ number_format($myTrip->estimated_fare, 0, ',', '.') }}</td>
                                <td style="text-align: right;">
                                    @if($myTrip->status === 'en_camino' || $myTrip->status === 'aceptado')
                                        <form action="{{ route('conductor.trips.status', $myTrip) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completado">
                                            <button type="submit" class="btn btn-navy btn-sm">Finalizar</button>
                                        </form>
                                    @elseif($myTrip->status === 'solicitado')
                                        <form action="{{ route('conductor.trips.accept', $myTrip) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-primary btn-sm">Aceptar</button>
                                        </form>
                                    @else
                                        <span class="status-badge {{ $myTrip->status === 'completado' ? 'status-success' : 'status-danger' }}">
                                            {{ ucfirst($myTrip->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 1.5rem; color: #64748b;">
                                    0 servicios registrados en tu historial.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Columna Derecha: Liquidación Real de Turno + Datos del Vehículo -->
    <div>
        <!-- Liquidación de Turno (100% Calculado de BD) -->
        <div class="card" id="liquidacion-conductor" style="margin-bottom: 1.25rem;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 0.98rem; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 0.45rem;">
                    <i class="bi bi-cash-coin" style="color: #b45309;"></i> Liquidación Real de Servicios
                </h3>
                <span style="font-size: 0.7rem; color: #64748b; text-align: right;">Datos Reales BD</span>
            </div>

            <div class="earnings-pair">
                <div class="earning-box">
                    <div style="font-size: 0.6rem; font-weight: 800; color: #64748b; text-transform: uppercase;">INGRESOS ACUMULADOS</div>
                    <div style="font-family: 'Outfit', sans-serif; font-size: 1.55rem; font-weight: 800; color: #0f172a; margin: 0.25rem 0;">
                        ${{ number_format($driverStats['total_earnings'], 0, ',', '.') }}
                    </div>
                    <div style="font-size: 0.66rem; color: #047857; font-weight: 700;">
                        {{ $driverStats['completed_trips'] }} carreras completadas
                    </div>
                </div>

                <div class="earning-box">
                    <div style="font-size: 0.6rem; font-weight: 800; color: #64748b; text-transform: uppercase;">COMISIONES COBRADAS</div>
                    <div style="font-family: 'Outfit', sans-serif; font-size: 1.55rem; font-weight: 800; color: #b45309; margin: 0.25rem 0;">
                        $0 COP
                    </div>
                    <div style="font-size: 0.66rem; color: #64748b;">100% ingreso directo al conductor</div>
                </div>
            </div>

            <div style="background: #f1f5f9; border-radius: 9px; padding: 0.55rem 0.85rem; display: flex; justify-content: space-between; align-items: center; font-size: 0.74rem; color: #475569; margin-bottom: 0.85rem;">
                <span><i class="bi bi-speedometer2"></i> Recorrido Completado: <strong style="color: #0f172a;">{{ number_format($driverStats['total_km'], 1) }} km</strong></span>
                <span><i class="bi bi-taxi-front"></i> En Curso: <strong style="color: #0f172a;">{{ $driverStats['active_count'] }}</strong></span>
            </div>

            <button type="button" class="btn btn-outline" style="width: 100%; justify-content: center; background: #f1f5f9; font-weight: 700;" onclick="window.print()">
                <i class="bi bi-receipt"></i> Imprimir Planilla de Servicios
            </button>
        </div>

        <!-- Datos Reales de Vehículo y Licencia -->
        <div class="card" id="documentos-conductor" style="margin-bottom: 0;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <h3 style="font-family: 'Outfit', sans-serif; font-size: 0.98rem; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 0.45rem;">
                        <i class="bi bi-shield-check" style="color: #047857;"></i> Expediente del Conductor y Vehículo
                    </h3>
                    <p style="font-size: 0.7rem; color: #64748b; margin-top: 0.2rem;">
                        Información registrada en la base de datos para tu cuenta.
                    </p>
                </div>
            </div>

            <div class="runt-grid">
                <div class="runt-item">
                    <div style="display: flex; justify-content: space-between; font-size: 0.66rem; color: #64748b; font-weight: 700;">
                        <span>Licencia Conducción</span>
                        <span style="color: {{ $driver->license_number ? '#10b981' : '#f59e0b' }};">●</span>
                    </div>
                    <div style="font-weight: 800; font-size: 0.82rem; color: #0f172a; margin: 0.2rem 0;">
                        {{ $driver->license_number ?? 'Sin registrar' }}
                    </div>
                    <div style="font-size: 0.65rem; color: #64748b;">Conductor {{ $driver->name }}</div>
                </div>

                <div class="runt-item">
                    <div style="display: flex; justify-content: space-between; font-size: 0.66rem; color: #64748b; font-weight: 700;">
                        <span>Placa Asignada</span>
                        <span style="color: {{ $driver->vehicle ? '#10b981' : '#ef4444' }};">●</span>
                    </div>
                    <div style="font-weight: 800; font-size: 0.82rem; color: #0f172a; margin: 0.2rem 0;">
                        {{ $driver->vehicle ? $driver->vehicle->license_plate : 'Sin vehículo' }}
                    </div>
                    <div style="font-size: 0.65rem; color: #64748b;">
                        {{ $driver->vehicle ? $driver->vehicle->brand . ' ' . $driver->vehicle->model : 'Pendiente vinculación' }}
                    </div>
                </div>

                <div class="runt-item">
                    <div style="display: flex; justify-content: space-between; font-size: 0.66rem; color: #64748b; font-weight: 700;">
                        <span>Estado Vehículo</span>
                        <span style="color: #10b981;">●</span>
                    </div>
                    <div style="font-weight: 800; font-size: 0.82rem; color: #0f172a; margin: 0.2rem 0;">
                        {{ $driver->vehicle ? ucfirst($driver->vehicle->status) : 'N/A' }}
                    </div>
                    <div style="font-size: 0.65rem; color: #64748b;">
                        {{ $driver->vehicle ? 'Modelo ' . $driver->vehicle->year . ' (' . $driver->vehicle->color . ')' : 'N/A' }}
                    </div>
                </div>

                <div class="runt-item">
                    <div style="display: flex; justify-content: space-between; font-size: 0.66rem; color: #64748b; font-weight: 700;">
                        <span>Coordenadas GPS</span>
                        <span style="color: #10b981;">●</span>
                    </div>
                    <div style="font-weight: 800; font-size: 0.78rem; color: #0f172a; margin: 0.2rem 0;">
                        {{ $driver->latitude ? number_format($driver->latitude, 4) . ', ' . number_format($driver->longitude, 4) : '5.3114, -73.8182' }}
                    </div>
                    <div style="font-size: 0.65rem; color: #64748b;">Valle de Ubaté</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const driverInitialLat = {{ $driver->latitude ? (float) $driver->latitude : 5.3114 }};
    const driverInitialLng = {{ $driver->longitude ? (float) $driver->longitude : -73.8182 }};

    const conductorMap = L.map('conductorMap').setView([driverInitialLat, driverInitialLng], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap - Ubaté'
    }).addTo(conductorMap);

    const taxiIcon = L.divIcon({
        className: '',
        html: `<div style="background:#f59e0b;color:#0f172a;width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:3px solid #fff;box-shadow:0 3px 8px rgba(0,0,0,0.4);font-size:16px;">
                <i class="bi bi-taxi-front-fill"></i>
               </div>`,
        iconSize: [34, 34],
        iconAnchor: [17, 17]
    });

    let driverMarker = L.marker([driverInitialLat, driverInitialLng], { icon: taxiIcon }).addTo(conductorMap);
    driverMarker.bindPopup(`<b>{{ $driver->name }}</b><br>Placa: {{ $driver->vehicle ? $driver->vehicle->license_plate : 'Sin placa' }}<br>Tu taxi`).openPopup();

    @if($activeTrip)
        const pickupIcon = L.divIcon({
            className: '',
            html: '<div style="background:#10b981;color:#fff;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;font-weight:800;font-size:12px;box-shadow:0 2px 6px rgba(0,0,0,0.35);">A</div>',
            iconSize: [28, 28],
            iconAnchor: [14, 14]
        });

        const dropoffIcon = L.divIcon({
            className: '',
            html: '<div style="background:#ef4444;color:#fff;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;font-weight:800;font-size:12px;box-shadow:0 2px 6px rgba(0,0,0,0.35);">B</div>',
            iconSize: [28, 28],
            iconAnchor: [14, 14]
        });

        const pickupLat = {{ (float) ($activeTrip->origin_latitude ?: 5.3080) }};
        const pickupLng = {{ (float) ($activeTrip->origin_longitude ?: -73.8150) }};
        const dropLat = {{ (float) ($activeTrip->destination_latitude ?: 5.3165) }};
        const dropLng = {{ (float) ($activeTrip->destination_longitude ?: -73.8210) }};

        const markerA = L.marker([pickupLat, pickupLng], { icon: pickupIcon }).addTo(conductorMap);
        markerA.bindPopup(`<b>Recogida (Pasajero):</b><br>{{ $activeTrip->origin_address }}`);

        const markerB = L.marker([dropLat, dropLng], { icon: dropoffIcon }).addTo(conductorMap);
        markerB.bindPopup(`<b>Destino:</b><br>{{ $activeTrip->destination_address }}`);

        const tripRoute = L.polyline([[pickupLat, pickupLng], [dropLat, dropLng]], {
            color: '#ea580c',
            weight: 4.5,
            dashArray: '6, 6'
        }).addTo(conductorMap);

        const group = L.featureGroup([driverMarker, markerA, markerB]);
        conductorMap.fitBounds(group.getBounds().pad(0.15));
    @endif

    let isBroadcastingGps = false;
    let gpsWatchId = null;

    function centerConductorMap() {
        conductorMap.panTo(driverMarker.getLatLng());
        conductorMap.setZoom(15);
    }

    function showConductorNotice(text, bg, color, border) {
        const el = document.getElementById('conductorGpsAlert');
        if (!el) return;
        el.style.display = 'block';
        el.style.background = bg;
        el.style.color = color;
        el.style.border = `1px solid ${border}`;
        el.textContent = text;
        setTimeout(() => { el.style.display = 'none'; }, 6000);
    }

    async function sendGpsToServer(lat, lng) {
        try {
            const res = await fetch('{{ route("conductor.location") }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    latitude: lat,
                    longitude: lng
                })
            });
            if (res.ok) {
                const data = await res.json();
                document.getElementById('gpsCoordDisplay').textContent = `GPS Actual: ${lat.toFixed(4)}, ${lng.toFixed(4)}`;
            }
        } catch (e) {}
    }

    function toggleGpsBroadcast() {
        const btn = document.getElementById('btnToggleGpsBroadcast');
        const label = document.getElementById('gpsBroadcastLabel');
        const badge = document.getElementById('gpsLiveBadge');

        if (!isBroadcastingGps) {
            if (!navigator.geolocation) {
                showConductorNotice('Tu navegador no soporta geolocalización satelital.', '#fef2f2', '#b91c1c', '#fecaca');
                return;
            }

            label.textContent = 'Iniciando GPS...';

            gpsWatchId = navigator.geolocation.watchPosition(
                function(pos) {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    const acc = Math.round(pos.coords.accuracy || 0);

                    driverMarker.setLatLng([lat, lng]);
                    conductorMap.panTo([lat, lng]);
                    sendGpsToServer(lat, lng);

                    isBroadcastingGps = true;
                    btn.style.background = '#ef4444';
                    label.textContent = 'Detener Transmisión GPS';
                    badge.style.display = 'inline-block';
                    showConductorNotice(`✓ GPS transmitiendo satelitalmente (Precisión: ±${acc}m)`, '#ecfdf5', '#047857', '#a7f3d0');
                },
                function(err) {
                    isBroadcastingGps = false;
                    btn.style.background = '#10b981';
                    label.textContent = 'Activar Transmisión GPS';
                    badge.style.display = 'none';
                    let msg = 'Error al capturar GPS.';
                    if (err.code === 1) msg = 'Permiso GPS denegado. Permite la ubicación en el navegador.';
                    else if (err.code === 2) msg = 'Señal satelital GPS no disponible.';
                    else if (err.code === 3) msg = 'Tiempo de espera GPS agotado.';
                    showConductorNotice(msg, '#fffbeb', '#b45309', '#fde68a');
                },
                {
                    enableHighAccuracy: true,
                    timeout: 12000,
                    maximumAge: 0
                }
            );
        } else {
            if (gpsWatchId !== null) {
                navigator.geolocation.clearWatch(gpsWatchId);
                gpsWatchId = null;
            }
            isBroadcastingGps = false;
            btn.style.background = '#10b981';
            label.textContent = 'Activar Transmisión GPS';
            badge.style.display = 'none';
            showConductorNotice('Transmisión GPS pausada.', '#f1f5f9', '#334155', '#cbd5e1');
        }
    }
</script>
@endsection
