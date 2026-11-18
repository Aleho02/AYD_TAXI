@extends('layouts.app')

@section('title', 'Portal Pasajero - TaxiUbaté Veredal & Urbano')

@section('content')
<style>
    .pasajero-subbar {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.9rem 2rem;
    }

    .pasajero-subbar-inner {
        max-width: 1220px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .pasajero-container {
        max-width: 1220px;
        margin: 0 auto;
        padding: 1.5rem 1.5rem 3rem;
    }

    .decree-banner {
        background: #fffcf5;
        border: 1px solid #fde68a;
        border-radius: 11px;
        padding: 0.75rem 1.15rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1.4rem;
        flex-wrap: wrap;
    }

    .pasajero-split {
        display: grid;
        grid-template-columns: 1.3fr 1fr;
        gap: 1.35rem;
        margin-bottom: 2.25rem;
        align-items: start;
    }

    .input-route-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.58rem 0.85rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.6rem;
    }

    .input-route-box input {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        font-size: 0.82rem;
        font-weight: 600;
        color: #0f172a;
    }

    .freq-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-size: 0.68rem;
        font-weight: 600;
        padding: 0.24rem 0.6rem;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.15s;
    }

    .freq-pill:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #1d4ed8;
    }

    .modality-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.65rem;
        margin: 0.6rem 0 1.15rem;
    }

    .modality-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem;
        cursor: pointer;
        transition: all 0.15s;
    }

    .modality-card.active {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    .tariff-box-official {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.15rem;
        margin-bottom: 1.15rem;
    }

    .tariff-line {
        display: flex;
        justify-content: space-between;
        font-size: 0.76rem;
        color: #475569;
        padding: 0.25rem 0;
    }

    .assigned-unit-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-top: 3px solid #d97706;
        border-radius: 14px;
        padding: 1.25rem 1.35rem;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }

    .pin-dark-card {
        background: #0f172a;
        color: #ffffff;
        border-radius: 12px;
        padding: 1.15rem;
        text-align: center;
        margin: 0.95rem 0;
    }

    .pin-digits {
        display: flex;
        justify-content: center;
        gap: 0.55rem;
        margin: 0.65rem 0;
    }

    .pin-digit-box {
        width: 44px;
        height: 48px;
        background: #ffffff;
        color: #0f172a;
        border-radius: 8px;
        font-family: 'Outfit', sans-serif;
        font-size: 1.5rem;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 1024px) {
        .pasajero-split, .modality-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- SUB-HEADER PERFIL DEL PASAJERO (DATOS REALES) -->
<div class="pasajero-subbar">
    <div class="pasajero-subbar-inner">
        <div style="display: flex; align-items: center; gap: 0.85rem;">
            <div class="avatar" style="width: 46px; height: 46px; background: #0f766e;">
                {{ strtoupper(substr($passenger->name, 0, 2)) }}
            </div>
            <div>
                <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                    <strong style="font-family: 'Outfit', sans-serif; font-size: 1.05rem; color: #0f172a;">
                        {{ $passenger->name }}
                    </strong>
                    <span style="background: #064e3b; color: #6ee7b7; font-size: 0.62rem; font-weight: 700; padding: 0.14rem 0.5rem; border-radius: 99px;">
                        <i class="bi bi-check-circle"></i> Cuenta Verificada
                    </span>
                </div>
                <div style="font-size: 0.72rem; color: #64748b; margin-top: 0.18rem;">
                    <span>{{ $passenger->email }}</span> •
                    <span>Viajes registrados: <strong>{{ $trips->total() }}</strong></span>
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 0.55rem;">
            <a href="#cotizador-pasajero" class="btn btn-navy btn-sm" style="padding: 0.45rem 0.9rem;">
                <i class="bi bi-lightning-charge-fill" style="color: #fbbf24;"></i> Solicitar Ruta
            </a>
            <a href="#historial-pasajero" class="btn btn-outline btn-sm" style="padding: 0.45rem 0.9rem;">
                <i class="bi bi-clock-history"></i> Mis Viajes ({{ $trips->total() }})
            </a>
        </div>
    </div>
</div>

<div class="pasajero-container">
    <!-- BANNER DECRETO MUNICIPAL -->
    <div class="decree-banner">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 34px; height: 34px; border-radius: 8px; background: #fef3c7; color: #b45309; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                <i class="bi bi-hammer"></i>
            </div>
            <div>
                <div style="font-size: 0.68rem; font-weight: 800; color: #92400e; text-transform: uppercase; letter-spacing: 0.4px;">
                    DECRETO MUNICIPAL STT #014 - REGISTRO EN TIEMPO REAL <span style="color: #f59e0b;">●</span>
                </div>
                <div style="font-size: 0.75rem; color: #475569;">
                    Al seleccionar y confirmar tu ruta, se registra automáticamente en la base de datos para el Conductor y el Administrador.
                </div>
            </div>
        </div>

        <span style="font-size: 0.72rem; font-weight: 700; color: #047857;">
            Conductores disponibles: {{ $availableDrivers->count() }}
        </span>
    </div>

    <!-- SECCIÓN PRINCIPAL DIVIDIDA: COTIZADOR (IZQUIERDA) Y SERVICIO ACTIVO (DERECHA) -->
    <div class="pasajero-split" id="cotizador-pasajero">
        <!-- Columna Izquierda: Terminal de Reserva Oficial -->
        <div>
            <div class="card" style="margin-bottom: 0.85rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.85rem;">
                    <div>
                        <div style="font-size: 0.62rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                            TERMINAL DE RESERVA OFICIAL
                        </div>
                        <h2 style="font-family: 'Outfit', sans-serif; font-size: 1.25rem; font-weight: 800; color: #0f172a; margin-top: 0.1rem;">
                            Cotizador y Solicitud Directa de Ruta
                        </h2>
                    </div>
                    <span style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.68rem; font-weight: 700; padding: 0.22rem 0.6rem; border-radius: 99px;">
                        ● {{ $availableDrivers->count() }} Conductores Activos
                    </span>
                </div>

                <!-- Mapa Interactivo Leaflet para elegir Origen y Destino en Ubaté -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.45rem; flex-wrap: wrap; gap: 0.4rem;">
                    <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
                        <button type="button" id="btnModeOrigin" class="freq-pill" style="background: #0f172a; color: #fff;" onclick="setMapMode('origin')">
                            <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#10b981;margin-right:4px;"></span> 1. Origen (A)
                        </button>
                        <button type="button" id="btnModeDest" class="freq-pill" onclick="setMapMode('destination')">
                            <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#ef4444;margin-right:4px;"></span> 2. Destino (B)
                        </button>
                        <button type="button" class="freq-pill" onclick="centerMapOnUbate()" title="Centrar mapa en el Parque Principal">
                            <i class="bi bi-geo-alt"></i> Centrar Ubaté
                        </button>
                    </div>
                    <button type="button" id="btnUseGps" class="freq-pill" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-weight: 700;" onclick="useMyGPSLocation()">
                        <i class="bi bi-crosshair"></i> <span id="btnGpsText">Mi ubicación GPS</span>
                    </button>
                </div>

                <div id="gpsStatusNotice" style="display: none; padding: 0.45rem 0.75rem; border-radius: 8px; font-size: 0.72rem; margin-bottom: 0.55rem; font-weight: 600;"></div>

                <div id="ubateMap" style="width: 100%; height: 260px; border-radius: 10px; border: 1px solid #cbd5e1; margin-bottom: 0.9rem; z-index: 1;"></div>

                <!-- Formulario que Registra el Viaje en la Base de Datos para Conductor y Administrador -->
                <form action="{{ route('pasajero.trips.store') }}" method="POST" id="pasajeroTripForm">
                    @csrf
                    <input type="hidden" name="origin_latitude" id="origin_latitude" value="{{ old('origin_latitude', '5.3080000') }}">
                    <input type="hidden" name="origin_longitude" id="origin_longitude" value="{{ old('origin_longitude', '-73.8150000') }}">
                    <input type="hidden" name="destination_latitude" id="destination_latitude" value="{{ old('destination_latitude', '5.3165000') }}">
                    <input type="hidden" name="destination_longitude" id="destination_longitude" value="{{ old('destination_longitude', '-73.8210000') }}">
                    <input type="hidden" name="estimated_fare" id="estimated_fare_input" value="8600">

                    <!-- Origen -->
                    <label style="font-size: 0.7rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.25rem;">
                        Punto de Recogida (Origen) *
                    </label>
                    <div class="input-route-box" style="margin-bottom: 0.55rem;">
                        <div style="display: flex; align-items: center; gap: 0.6rem; flex: 1;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; border: 2.5px solid #10b981; flex-shrink: 0;"></span>
                            <input type="text" name="origin_address" id="origin_address" value="{{ old('origin_address', 'Parque Principal de Ubaté, Cra. 7') }}" placeholder="Selecciona en el mapa o escribe el origen" required>
                        </div>
                        <span id="originCoordsText" style="font-size: 0.62rem; color: #64748b; font-family: monospace;">5.3080, -73.8150</span>
                    </div>
                    @error('origin_address')
                        <div class="invalid-feedback" style="margin-bottom: 0.4rem;">{{ $message }}</div>
                    @enderror

                    <!-- Destino -->
                    <label style="font-size: 0.7rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.25rem;">
                        Punto de Destino *
                    </label>
                    <div class="input-route-box" style="margin-bottom: 0.65rem;">
                        <div style="display: flex; align-items: center; gap: 0.6rem; flex: 1;">
                            <i class="bi bi-geo-alt-fill" style="color: #ef4444; font-size: 0.9rem;"></i>
                            <input type="text" name="destination_address" id="destination_address" value="{{ old('destination_address', 'Hospital El Salvador de Ubaté, Cl. 10') }}" placeholder="Selecciona en el mapa o escribe el destino" required>
                        </div>
                        <span id="sectorBadge" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; font-size: 0.64rem; font-weight: 800; padding: 0.16rem 0.45rem; border-radius: 4px; white-space: nowrap;">
                            Ruta Activa
                        </span>
                    </div>
                    @error('destination_address')
                        <div class="invalid-feedback" style="margin-bottom: 0.4rem;">{{ $message }}</div>
                    @enderror

                    <!-- Rutas rápidas de Ubaté -->
                    <div style="display: flex; align-items: center; gap: 0.4rem; flex-wrap: wrap; margin-bottom: 0.9rem;">
                        <span style="font-size: 0.7rem; color: #64748b; font-weight: 600;">Seleccionar destino rápido:</span>
                        <button type="button" class="freq-pill" onclick="selectPresetDestination(5.3165, -73.8210, 'Hospital El Salvador de Ubaté, Cl. 10', 2.4, 'Urbano')">Hospital El Salvador</button>
                        <button type="button" class="freq-pill" onclick="selectPresetDestination(5.3042, -73.8178, 'Terminal de Transportes de Ubaté', 1.8, 'Urbano')">Terminal de Transportes</button>
                        <button type="button" class="freq-pill" onclick="selectPresetDestination(5.3086, -73.8142, 'Basílica del Santo Cristo de Ubaté', 1.5, 'Urbano')">Basílica Santo Cristo</button>
                        <button type="button" class="freq-pill" onclick="selectPresetDestination(5.3060, -73.8130, 'Plaza de Mercado San José de Ubaté', 2.1, 'Urbano')">Plaza de Mercado</button>
                        <button type="button" class="freq-pill" onclick="selectPresetDestination(5.3290, -73.8020, 'Vereda Sucunchoque - Sector El Molino', 4.2, 'Veredal')">Vereda Sucunchoque</button>
                        <button type="button" class="freq-pill" onclick="selectPresetDestination(5.2910, -73.8290, 'Vereda Palogordo - Sector Rural', 5.5, 'Veredal')">Vereda Palogordo</button>
                    </div>

                    <!-- Distancia y Conductor Asignado (Reales de BD) -->
                    <div style="display: grid; grid-template-columns: 140px 1fr; gap: 0.75rem; margin-bottom: 0.95rem;">
                        <div>
                            <label for="distance_km" style="font-size: 0.7rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.25rem;">Distancia (km) *</label>
                            <input type="number" step="0.01" min="0.1" max="150" name="distance_km" id="distance_km" class="form-control" value="{{ old('distance_km', '2.4') }}" oninput="recalculateRealFare()" required>
                        </div>
                        <div>
                            <label for="driver_id" style="font-size: 0.7rem; font-weight: 700; color: #334155; display: block; margin-bottom: 0.25rem;">Conductor (Opcional)</label>
                            <select name="driver_id" id="driver_id" class="form-control">
                                <option value="">-- Enviar a todos los conductores y Central Admin --</option>
                                @foreach($availableDrivers as $drv)
                                    <option value="{{ $drv->id }}" {{ old('driver_id') == $drv->id ? 'selected' : '' }}>
                                        {{ $drv->name }} {{ $drv->vehicle ? '(' . $drv->vehicle->license_plate . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Desglose Tarifario Oficial (Calculado en vivo según distancia) -->
                    <div class="tariff-box-official">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                            <span style="font-size: 0.65rem; font-weight: 800; color: #475569; text-transform: uppercase;">
                                DESGLOSE TARIFARIO OFICIAL (COP)
                            </span>
                            <span style="font-size: 0.66rem; font-weight: 700; color: #047857;">
                                <i class="bi bi-lock-fill"></i> Tarifa Regulada ($5.000 + $1.500/km)
                            </span>
                        </div>

                        <div class="tariff-line">
                            <span>Banderazo / Tarifa base reglamentaria</span>
                            <strong id="rowBase" style="color: #0f172a;">$5.000</strong>
                        </div>
                        <div class="tariff-line">
                            <span id="rowDistLabel">Recorrido calculado (2.4 km × $1.500)</span>
                            <strong id="rowDistVal" style="color: #0f172a;">$3.600</strong>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 0.65rem; padding-top: 0.65rem; border-top: 1px solid #e2e8f0;">
                            <div>
                                <div style="font-weight: 800; font-size: 0.9rem; color: #0f172a;">Total Liquidado a Registrar</div>
                                <div style="font-size: 0.66rem; color: #64748b;">Visible al instante en Panel Conductor y Admin</div>
                            </div>
                            <div style="text-align: right;">
                                <div id="totalFareDisplay" style="font-family: 'Outfit', sans-serif; font-size: 1.85rem; font-weight: 800; color: #0f172a; line-height: 1;">
                                    $8.600
                                </div>
                                <div style="font-size: 0.62rem; color: #64748b; font-weight: 700;">COP</div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-navy" style="width: 100%; justify-content: center; padding: 0.8rem; font-size: 0.88rem; font-weight: 700;">
                        <i class="bi bi-123"></i> Confirmar y Registrar Ruta con Código PIN
                    </button>
                </form>
            </div>
        </div>

        <!-- Columna Derecha: Estado Real de tu Solicitud Actual ($activeTrip de BD) -->
        <div id="pin-seguridad">
            @php
                $activeTrip = $trips->firstWhere('status', 'solicitado')
                    ?? $trips->firstWhere('status', 'aceptado')
                    ?? $trips->firstWhere('status', 'en_camino');
            @endphp

            <div class="assigned-unit-card">
                @if($activeTrip)
                    @php
                        $pinCode = str_pad(($activeTrip->id * 137) % 10000, 4, '0', STR_PAD_LEFT);
                    @endphp
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.85rem;">
                        <span style="font-size: 0.66rem; font-weight: 800; color: #0f172a; letter-spacing: 0.4px;">
                            <span style="color: #10b981;">●</span> SERVICIO ACTIVO #TX-{{ $activeTrip->id }}
                        </span>
                        <span class="status-badge {{ $activeTrip->status === 'en_camino' ? 'status-success' : 'status-warning' }}">
                            {{ strtoupper(str_replace('_', ' ', $activeTrip->status)) }}
                        </span>
                    </div>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 0.75rem; display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div class="avatar" style="width: 44px; height: 44px; border-radius: 10px; background: #1e293b;">
                                <i class="bi bi-taxi-front-fill" style="color: #fbbf24;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 800; font-size: 0.88rem; color: #0f172a;">
                                    {{ $activeTrip->driver ? $activeTrip->driver->name : 'Esperando aceptación de conductor...' }}
                                </div>
                                <div style="font-size: 0.72rem; color: #64748b; margin-top: 0.1rem;">
                                    Origen: <strong>{{ $activeTrip->origin_address }}</strong>
                                </div>
                                <div style="font-size: 0.72rem; color: #64748b;">
                                    Destino: <strong>{{ $activeTrip->destination_address }}</strong> ({{ $activeTrip->distance_km }} km)
                                </div>
                                @if($activeTrip->driver && $activeTrip->driver->vehicle)
                                    <div style="margin-top: 0.25rem;">
                                        <span style="background: #fef3c7; border: 1px solid #f59e0b; font-size: 0.65rem; font-weight: 800; padding: 0.08rem 0.35rem; border-radius: 4px; color: #0f172a;">
                                            PLACA: {{ $activeTrip->driver->vehicle->license_plate }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <strong style="color: #047857; font-size: 0.88rem;">
                            ${{ number_format($activeTrip->estimated_fare, 0, ',', '.') }}
                        </strong>
                    </div>

                    <!-- PIN Obligatorio de Abordaje Seguro -->
                    <div class="pin-dark-card">
                        <div style="font-size: 0.62rem; font-weight: 800; color: #94a3b8; letter-spacing: 0.6px; text-transform: uppercase;">
                            <i class="bi bi-lock-fill" style="color: #fbbf24;"></i> PIN OBLIGATORIO DE ABORDAJE SEGURO
                        </div>

                        <div class="pin-digits">
                            <div class="pin-digit-box">{{ $pinCode[0] }}</div>
                            <div class="pin-digit-box">{{ $pinCode[1] }}</div>
                            <div class="pin-digit-box">{{ $pinCode[2] }}</div>
                            <div class="pin-digit-box">{{ $pinCode[3] }}</div>
                        </div>

                        <p style="font-size: 0.68rem; color: #94a3b8; line-height: 1.35; max-width: 290px; margin: 0 auto;">
                            Este código PIN corresponde a tu solicitud <strong>#TX-{{ $activeTrip->id }}</strong> ya registrada para el Conductor y el Administrador.
                        </p>
                    </div>

                    <form action="{{ route('pasajero.trips.cancel', $activeTrip) }}" method="POST" onsubmit="return confirm('¿Deseas cancelar este servicio de taxi?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center;">
                            <i class="bi bi-x-circle"></i> Cancelar Solicitud Actual
                        </button>
                    </form>
                @else
                    <div style="text-align: center; padding: 2.25rem 1rem;">
                        <div style="width: 52px; height: 52px; border-radius: 50%; background: #f1f5f9; color: #64748b; display: inline-flex; align-items: center; justify-content: center; font-size: 1.4rem; margin-bottom: 0.75rem;">
                            <i class="bi bi-taxi-front"></i>
                        </div>
                        <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                            0 Servicios Activos en Curso
                        </h3>
                        <p style="font-size: 0.76rem; color: #64748b; margin-top: 0.35rem; line-height: 1.45;">
                            No tienes ninguna solicitud activa en este momento. Selecciona tu ruta en el mapa o en el cotizador de la izquierda y presiona <strong>"Confirmar y Registrar Ruta"</strong> para enviarla al Conductor y Administrador.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- REGISTRO PERSONAL DE MOVILIDAD: ÚLTIMOS VIAJES REGISTRADOS (100% REAL DE BD) -->
    <div id="historial-pasajero">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 0.85rem; flex-wrap: wrap; gap: 0.75rem;">
            <div>
                <div style="font-size: 0.62rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                    REGISTRO PERSONAL DE MOVILIDAD (DATOS REALES BD)
                </div>
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.2rem; font-weight: 800; color: #0f172a;">
                    Mis Viajes Registrados ({{ $trips->total() }})
                </h3>
            </div>
        </div>

        <div class="card" style="padding: 0; overflow: hidden;">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>FECHA Y RADICADO</th>
                            <th>ORIGEN • DESTINO</th>
                            <th>CONDUCTOR Y UNIDAD</th>
                            <th>ESTADO</th>
                            <th>TARIFA</th>
                            <th style="text-align: right;">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trips as $trip)
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a; font-size: 0.8rem;">
                                        {{ $trip->created_at ? $trip->created_at->format('d/m/Y H:i') : 'Reciente' }}
                                    </div>
                                    <div style="font-size: 0.68rem; color: #64748b;">#TX-{{ $trip->id }}</div>
                                </td>
                                <td>
                                    <div style="font-size: 0.78rem; font-weight: 600; color: #0f172a;">● {{ $trip->origin_address }}</div>
                                    <div style="font-size: 0.74rem; color: #64748b;"><span style="color: #d97706;">●</span> {{ $trip->destination_address }} ({{ $trip->distance_km }} km)</div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; font-size: 0.78rem; color: #0f172a;">
                                        {{ $trip->driver ? $trip->driver->name : 'Sin conductor asignado aún' }}
                                        @if($trip->driver && $trip->driver->vehicle)
                                            <span style="background: #eff6ff; color: #1d4ed8; font-size: 0.64rem; padding: 0.08rem 0.35rem; border-radius: 4px; margin-left: 0.25rem;">
                                                {{ $trip->driver->vehicle->license_plate }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge {{ $trip->status === 'completado' ? 'status-success' : ($trip->status === 'cancelado' ? 'status-danger' : 'status-warning') }}">
                                        {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-weight: 800; color: #0f172a; font-size: 0.85rem;">${{ number_format($trip->estimated_fare, 0, ',', '.') }} COP</div>
                                </td>
                                <td style="text-align: right;">
                                    @if(in_array($trip->status, ['solicitado', 'aceptado', 'en_camino']))
                                        <form action="{{ route('pasajero.trips.cancel', $trip) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Seguro de cancelar este viaje?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-x-circle"></i> Cancelar
                                            </button>
                                        </form>
                                    @else
                                        <span style="font-size: 0.72rem; color: #64748b;">Cerrado</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 2.25rem; color: #64748b;">
                                    0 viajes registrados en tu historial. Selecciona una ruta arriba para registrar tu primer servicio.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($trips->hasPages())
                <div style="padding: 0.85rem 1.25rem; border-top: 1px solid #f1f5f9;">
                    {{ $trips->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    let currentMapMode = 'destination';

    // Inicializar mapa centrado en el Parque Principal de Ubaté
    const map = L.map('ubateMap').setView([5.3110, -73.8165], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap - Valle de Ubaté'
    }).addTo(map);

    const originIcon = L.divIcon({
        className: '',
        html: '<div style="background:#10b981;color:#fff;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;font-weight:800;font-size:13px;box-shadow:0 2px 6px rgba(0,0,0,0.4);">A</div>',
        iconSize: [28, 28],
        iconAnchor: [14, 14]
    });

    const destIcon = L.divIcon({
        className: '',
        html: '<div style="background:#ef4444;color:#fff;width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;font-weight:800;font-size:13px;box-shadow:0 2px 6px rgba(0,0,0,0.4);">B</div>',
        iconSize: [28, 28],
        iconAnchor: [14, 14]
    });

    let originMarker = L.marker([5.3080, -73.8150], { draggable: true, icon: originIcon }).addTo(map);
    let destMarker = L.marker([5.3165, -73.8210], { draggable: true, icon: destIcon }).addTo(map);
    let routeLine = L.polyline([[5.3080, -73.8150], [5.3165, -73.8210]], { color: '#0f172a', weight: 4.5, opacity: 0.85 }).addTo(map);

    // Capa de taxis disponibles en tiempo real
    const driversLayer = L.layerGroup().addTo(map);
    const availableDriversData = @json($availableDrivers);

    function renderDriversOnMap(drivers) {
        driversLayer.clearLayers();
        if (!drivers || !drivers.length) return;

        drivers.forEach(drv => {
            if (!drv.latitude || !drv.longitude) return;
            const taxiIcon = L.divIcon({
                className: '',
                html: `<div style="background:#f59e0b;color:#0f172a;width:30px;height:30px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2.5px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,0.35);font-size:14px;cursor:pointer;" title="${drv.name}">
                        <i class="bi bi-taxi-front-fill"></i>
                       </div>`,
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            const marker = L.marker([parseFloat(drv.latitude), parseFloat(drv.longitude)], { icon: taxiIcon });
            const plate = drv.vehicle ? drv.vehicle.license_plate : 'En servicio';
            marker.bindPopup(`
                <div style="font-family:'Inter',sans-serif;font-size:0.75rem;line-height:1.4;">
                    <strong style="color:#0f172a;font-size:0.82rem;">🚖 ${drv.name}</strong><br>
                    <span style="color:#047857;font-weight:700;">● Conductor Disponible</span><br>
                    Placa: <strong>${plate}</strong><br>
                    ${drv.phone ? 'Tel: ' + drv.phone : ''}
                </div>
            `);
            driversLayer.addLayer(marker);
        });
    }

    renderDriversOnMap(availableDriversData);

    // Refrescar posiciones de conductores cada 15 segundos
    setInterval(async () => {
        try {
            const res = await fetch('/geo/drivers');
            if (res.ok) {
                const data = await res.json();
                if (data && data.drivers) renderDriversOnMap(data.drivers);
            }
        } catch (e) {}
    }, 15000);

    function setMapMode(mode) {
        currentMapMode = mode;
        document.getElementById('btnModeOrigin').style.background = mode === 'origin' ? '#0f172a' : '#f8fafc';
        document.getElementById('btnModeOrigin').style.color = mode === 'origin' ? '#fff' : '#334155';
        document.getElementById('btnModeDest').style.background = mode === 'destination' ? '#0f172a' : '#f8fafc';
        document.getElementById('btnModeDest').style.color = mode === 'destination' ? '#fff' : '#334155';
    }

    function centerMapOnUbate() {
        map.setView([5.3110, -73.8165], 14);
    }

    function haversineKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
    }

    async function reverseGeocode(lat, lng, inputId) {
        try {
            const res = await fetch(`/geo/reverse?latitude=${lat}&longitude=${lng}`);
            if (res.ok) {
                const data = await res.json();
                if (data && data.address) {
                    document.getElementById(inputId).value = data.address;
                    return;
                }
            }
        } catch (e) {}
        document.getElementById(inputId).value = `Ubicación (${lat.toFixed(4)}, ${lng.toFixed(4)})`;
    }

    async function syncMarkersAndDistance() {
        const o = originMarker.getLatLng();
        const d = destMarker.getLatLng();
        document.getElementById('origin_latitude').value = o.lat.toFixed(7);
        document.getElementById('origin_longitude').value = o.lng.toFixed(7);
        document.getElementById('destination_latitude').value = d.lat.toFixed(7);
        document.getElementById('destination_longitude').value = d.lng.toFixed(7);
        document.getElementById('originCoordsText').textContent = `${o.lat.toFixed(4)}, ${o.lng.toFixed(4)}`;

        // Trazar ruta real por calles con OSRM o Haversine como respaldo
        try {
            const res = await fetch(`https://router.project-osrm.org/route/v1/driving/${o.lng},${o.lat};${d.lng},${d.lat}?overview=full&geometries=geojson`);
            if (res.ok) {
                const data = await res.json();
                if (data.routes && data.routes[0]) {
                    const r = data.routes[0];
                    const coords = r.geometry.coordinates.map(c => [c[1], c[0]]);
                    routeLine.setLatLngs(coords);
                    const km = Math.max(0.5, (r.distance / 1000));
                    document.getElementById('distance_km').value = km.toFixed(2);
                    recalculateRealFare();
                    return;
                }
            }
        } catch (e) {}

        routeLine.setLatLngs([o, d]);
        const dist = Math.max(0.5, haversineKm(o.lat, o.lng, d.lat, d.lng) * 1.25);
        document.getElementById('distance_km').value = dist.toFixed(2);
        recalculateRealFare();
    }

    map.on('click', function(e) {
        if (currentMapMode === 'origin') {
            originMarker.setLatLng(e.latlng);
            reverseGeocode(e.latlng.lat, e.latlng.lng, 'origin_address');
            setMapMode('destination');
        } else {
            destMarker.setLatLng(e.latlng);
            reverseGeocode(e.latlng.lat, e.latlng.lng, 'destination_address');
        }
        syncMarkersAndDistance();
    });

    originMarker.on('dragend', function() {
        const p = originMarker.getLatLng();
        reverseGeocode(p.lat, p.lng, 'origin_address');
        syncMarkersAndDistance();
    });

    destMarker.on('dragend', function() {
        const p = destMarker.getLatLng();
        reverseGeocode(p.lat, p.lng, 'destination_address');
        syncMarkersAndDistance();
    });

    function selectPresetDestination(lat, lng, address, km, sector) {
        destMarker.setLatLng([lat, lng]);
        document.getElementById('destination_address').value = address;
        document.getElementById('destination_latitude').value = lat.toFixed(7);
        document.getElementById('destination_longitude').value = lng.toFixed(7);
        document.getElementById('distance_km').value = km;
        document.getElementById('sectorBadge').textContent = sector;
        map.panTo([lat, lng]);
        syncMarkersAndDistance();
    }

    function showGpsNotice(text, bg, color, border) {
        const notice = document.getElementById('gpsStatusNotice');
        if (!notice) return;
        notice.style.display = 'block';
        notice.style.background = bg;
        notice.style.color = color;
        notice.style.border = `1px solid ${border}`;
        notice.textContent = text;
        setTimeout(() => { notice.style.display = 'none'; }, 7000);
    }

    function useMyGPSLocation() {
        const btn = document.getElementById('btnUseGps');
        const txt = document.getElementById('btnGpsText');

        if (!navigator.geolocation) {
            showGpsNotice('Tu navegador no cuenta con soporte para GPS. Puedes hacer clic en el mapa para fijar tu origen.', '#fef2f2', '#b91c1c', '#fecaca');
            return;
        }

        txt.textContent = 'Obteniendo GPS...';
        btn.disabled = true;

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                btn.disabled = false;
                txt.textContent = 'GPS Actualizado';
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                const accuracy = Math.round(pos.coords.accuracy || 0);

                originMarker.setLatLng([lat, lng]);
                map.setView([lat, lng], 15);
                reverseGeocode(lat, lng, 'origin_address');
                syncMarkersAndDistance();

                showGpsNotice(`✓ Ubicación GPS detectada (Precisión: ±${accuracy}m). Marcador A actualizado.`, '#ecfdf5', '#047857', '#a7f3d0');
                setTimeout(() => { txt.textContent = 'Mi ubicación GPS'; }, 4000);
            },
            function(err) {
                btn.disabled = false;
                txt.textContent = 'Mi ubicación GPS';
                let msg = 'No se pudo obtener la posición GPS.';
                if (err.code === 1) {
                    msg = 'Permiso GPS no concedido en el navegador. Haz clic en "1. Origen (A)" y selecciona tu ubicación en el mapa de Ubaté.';
                } else if (err.code === 2) {
                    msg = 'Señal satelital no disponible actualmente. Puedes arrastrar el marcador verde en el mapa.';
                } else if (err.code === 3) {
                    msg = 'Tiempo de espera GPS agotado. Puedes marcar tu ubicación manualmente en el mapa.';
                }
                showGpsNotice(msg, '#fffbeb', '#b45309', '#fde68a');
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    function recalculateRealFare() {
        const dist = parseFloat(document.getElementById('distance_km').value) || 0;
        const base = 5000;
        const distCost = Math.round((dist * 1500) / 100) * 100;
        const total = Math.max(6000, base + distCost);

        document.getElementById('rowDistLabel').textContent = `Recorrido calculado (${dist.toFixed(2)} km × $1.500)`;
        document.getElementById('rowDistVal').textContent = '$' + distCost.toLocaleString('es-CO');
        document.getElementById('totalFareDisplay').textContent = '$' + total.toLocaleString('es-CO');
        document.getElementById('estimated_fare_input').value = total;
    }

    recalculateRealFare();
</script>
@endsection
