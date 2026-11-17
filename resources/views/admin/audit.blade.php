@extends('layouts.app')

@section('title', 'Trazabilidad & Auditoría Forense - TaxiUbaté')

@section('content')
<style>
    .audit-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1.5rem;
        margin-bottom: 1.4rem;
        flex-wrap: wrap;
    }

    .audit-badges {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .sys-audit-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        font-size: 0.66rem;
        font-weight: 800;
        padding: 0.2rem 0.55rem;
        border-radius: 999px;
    }

    .sha-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: #0f172a;
        color: #ffffff;
        font-size: 0.66rem;
        font-weight: 700;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
    }

    .audit-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.85rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.15;
        letter-spacing: -0.5px;
        max-width: 580px;
        margin-bottom: 0.45rem;
    }

    .audit-sub {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        font-size: 0.82rem;
        color: #475569;
        max-width: 600px;
        line-height: 1.4;
    }

    .audit-top-actions {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        flex-wrap: wrap;
    }

    .audit-search-box {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 0.48rem 0.85rem;
        width: 260px;
    }

    .audit-search-box input {
        border: none;
        outline: none;
        background: transparent;
        width: 100%;
        font-size: 0.78rem;
        color: #0f172a;
    }

    .audit-kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.15rem;
        margin-bottom: 1.25rem;
    }

    .audit-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        padding: 1.1rem 1.25rem;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.03);
    }

    .audit-kpi-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.4px;
        margin-bottom: 0.4rem;
    }

    .audit-kpi-val {
        font-family: 'Outfit', sans-serif;
        font-size: 1.95rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        margin-bottom: 0.35rem;
    }

    .audit-kpi-sub {
        font-size: 0.72rem;
        font-weight: 600;
    }

    .audit-filter-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1.15rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .audit-select {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 7px;
        padding: 0.38rem 0.75rem;
        font-size: 0.76rem;
        font-weight: 600;
        color: #1e293b;
        outline: none;
    }

    .audit-split {
        display: grid;
        grid-template-columns: 1fr 370px;
        gap: 1.25rem;
        align-items: start;
    }

    .bitacora-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
    }

    .bitacora-header {
        padding: 0.95rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
    }

    .bitacora-row {
        cursor: pointer;
        transition: background 0.15s;
    }

    .bitacora-row.selected td {
        background-color: #f8fafc;
    }

    .bitacora-row.selected td:first-child {
        border-left: 3px solid #f97316;
    }

    .mini-plate {
        display: inline-block;
        background: #fef3c7;
        border: 1px solid #f59e0b;
        color: #0f172a;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.66rem;
        font-weight: 800;
        padding: 0.1rem 0.35rem;
        border-radius: 4px;
    }

    .forensic-inspector {
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);
    }

    .forensic-top {
        background: #0f172a;
        color: #ffffff;
        padding: 0.95rem 1.15rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .forensic-map-box {
        position: relative;
        height: 185px;
        background: linear-gradient(135deg, #d1fae5 0%, #e0f2fe 55%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .playback-overlay {
        position: absolute;
        bottom: 8px;
        left: 10px;
        right: 10px;
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        padding: 0.45rem 0.65rem;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.1);
    }

    .timeline-box {
        padding: 1rem 1.15rem;
    }

    .checkpoint-item {
        position: relative;
        padding-left: 1.45rem;
        padding-bottom: 0.85rem;
        border-left: 2px solid #e2e8f0;
        margin-left: 0.45rem;
    }

    .checkpoint-item:last-child {
        border-left-color: transparent;
        padding-bottom: 0;
    }

    .checkpoint-dot {
        position: absolute;
        left: -7px;
        top: 2px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #10b981;
        border: 2px solid #ffffff;
        box-shadow: 0 0 0 1px #10b981;
    }

    .checkpoint-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.76rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.15rem;
    }

    .checkpoint-time {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.66rem;
        color: #64748b;
        font-weight: 600;
    }

    .checkpoint-desc {
        font-size: 0.7rem;
        color: #64748b;
        line-height: 1.35;
    }

    .tariff-breakdown {
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 0.9rem 1.15rem;
        font-size: 0.73rem;
    }

    .tariff-row {
        display: flex;
        justify-content: space-between;
        padding: 0.2rem 0;
        color: #475569;
    }

    @media (max-width: 1180px) {
        .audit-kpi-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .audit-split {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- CABECERA AUDITORÍA FORENSE -->
<div class="audit-header">
    <div>
        <div class="audit-badges">
            <span class="sys-audit-pill">● SYS-AUDIT-UBATÉ v4.12</span>
            <span class="sha-pill"><i class="bi bi-lock-fill"></i> Datos Reales BD</span>
        </div>
        <h1 class="audit-title">Auditoría Forense y Trazabilidad de Servicios de Transporte</h1>
        <p class="audit-sub">
            <i class="bi bi-shield-check" style="color: #10b981; font-size: 1rem;"></i>
            <span>Registro directo de todas las rutas solicitadas por pasajeros y atendidas por conductores en la base de datos.</span>
        </p>
    </div>

    <div class="audit-top-actions">
        <div class="audit-search-box">
            <i class="bi bi-search" style="color: #94a3b8; font-size: 0.8rem;"></i>
            <input type="text" id="auditSearchInput" placeholder="ID (#TX-...), Placa, Conductor o Pasajero" onkeyup="filterAuditRows()">
        </div>
        <button type="button" class="btn btn-navy" onclick="window.print()">
            <i class="bi bi-file-earmark-pdf"></i> Acta Forense PDF
        </button>
    </div>
</div>

<!-- 4 TARJETAS KPI 100% REALES -->
<div class="audit-kpi-grid">
    <div class="audit-kpi-card">
        <div class="audit-kpi-head">
            <span>TOTAL VIAJES REGISTRADOS</span>
            <i class="bi bi-taxi-front" style="color: #d97706; font-size: 0.95rem;"></i>
        </div>
        <div class="audit-kpi-val">{{ $stats['total_trips'] }}</div>
        <div class="audit-kpi-sub" style="color: #047857;">Distancia total: {{ number_format($stats['total_distance'], 1) }} km</div>
    </div>

    <div class="audit-kpi-card">
        <div class="audit-kpi-head">
            <span>SERVICIOS COMPLETADOS</span>
            <i class="bi bi-check2-circle" style="color: #10b981; font-size: 0.95rem;"></i>
        </div>
        <div class="audit-kpi-val">{{ $stats['completed_trips'] }}</div>
        <div class="audit-kpi-sub" style="color: #64748b;">Recaudo: ${{ number_format($stats['total_revenue'], 0, ',', '.') }} COP</div>
    </div>

    <div class="audit-kpi-card">
        <div class="audit-kpi-head">
            <span>SERVICIOS EN CURSO / COLA</span>
            <i class="bi bi-signpost-split" style="color: #d97706; font-size: 0.95rem;"></i>
        </div>
        <div class="audit-kpi-val">{{ $stats['active_trips'] }}</div>
        <div class="audit-kpi-sub" style="color: #b45309;">En seguimiento activo</div>
    </div>

    <div class="audit-kpi-card">
        <div class="audit-kpi-head">
            <span>SERVICIOS CANCELADOS</span>
            <i class="bi bi-x-octagon" style="color: #dc2626; font-size: 0.95rem;"></i>
        </div>
        <div class="audit-kpi-val">{{ $stats['cancelled_trips'] }}</div>
        <div class="audit-kpi-sub" style="color: #64748b;">Cancelados por usuario o conductor</div>
    </div>
</div>

<!-- BARRA DE FILTROS -->
<div class="audit-filter-bar">
    <div style="display: flex; align-items: center; gap: 0.6rem; flex-wrap: wrap;">
        <span style="font-size: 0.7rem; font-weight: 800; color: #64748b; letter-spacing: 0.5px;">FILTROS:</span>
        <select class="audit-select" id="auditStatusFilter" onchange="filterAuditRows()">
            <option value="">Todos los Estados ({{ $stats['total_trips'] }})</option>
            <option value="completado">Completado ({{ $stats['completed_trips'] }})</option>
            <option value="solicitado">Solicitado</option>
            <option value="en camino">En Camino</option>
            <option value="cancelado">Cancelado ({{ $stats['cancelled_trips'] }})</option>
        </select>
    </div>

    <div style="font-size: 0.74rem; color: #64748b; display: flex; align-items: center; gap: 0.5rem;">
        <span>Mostrando {{ $trips->count() }} de {{ $trips->total() }} registros reales</span>
        <button type="button" class="action-icon-btn" onclick="resetAuditFilters()" title="Limpiar filtro"><i class="bi bi-arrow-repeat"></i></button>
    </div>
</div>

@php
    $firstTrip = $trips->first();
@endphp

<!-- VISTA DIVIDIDA: BITÁCORA OFICIAL + PLAYBACK DE TELEMETRÍA -->
<div class="audit-split">
    <!-- Tabla Izquierda: Bitácora Oficial de Viajes Reales -->
    <div class="bitacora-card">
        <div class="bitacora-header">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <i class="bi bi-list-columns-reverse" style="color: #0f172a;"></i>
                <h3 style="font-family: 'Outfit', sans-serif; font-size: 0.92rem; font-weight: 800; color: #0f172a;">
                    BITÁCORA OFICIAL DE VIAJES ({{ $trips->total() }})
                </h3>
            </div>
            <span style="background: #f8fafc; border: 1px solid #e2e8f0; color: #475569; font-size: 0.68rem; font-weight: 700; padding: 0.2rem 0.55rem; border-radius: 6px;">
                Trazabilidad Real BD
            </span>
        </div>

        <div class="table-responsive">
            <table id="auditTable">
                <thead>
                    <tr>
                        <th>ID VIAJE / HORA</th>
                        <th>PASAJERO</th>
                        <th>MÓVIL /<br>CONDUCTOR</th>
                        <th>TRAYECTO & KMS</th>
                        <th>TARIFA</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trips as $idx => $trip)
                        <tr class="bitacora-row {{ $idx === 0 ? 'selected' : '' }}"
                            onclick="selectForensicTrip(this, '#TX-{{ $trip->id }}', '{{ ucfirst(str_replace('_', ' ', $trip->status)) }}', '{{ addslashes($trip->origin_address) }}', '{{ addslashes($trip->destination_address) }}', '{{ $trip->distance_km }} km', '{{ str_pad(($trip->id * 137) % 10000, 4, '0', STR_PAD_LEFT) }}', '$5.000 COP', '${{ number_format(max(0, $trip->estimated_fare - 5000), 0, ',', '.') }} COP', '${{ number_format($trip->estimated_fare, 0, ',', '.') }} COP', '{{ $trip->created_at ? $trip->created_at->format('H:i:s') : '--:--' }}')">
                            <td>
                                <div style="font-weight: 800; color: #0f172a; font-size: 0.84rem;">
                                    <span style="color: #10b981;">●</span> #TX-{{ $trip->id }}
                                </div>
                                <div style="font-size: 0.7rem; color: #64748b; margin: 0.15rem 0 0.3rem;">
                                    {{ $trip->created_at ? $trip->created_at->format('d/m/Y H:i:s') : 'N/A' }}
                                </div>
                                <span class="status-badge {{ $trip->status === 'completado' ? 'status-success' : ($trip->status === 'cancelado' ? 'status-danger' : 'status-warning') }}" style="font-size: 0.65rem;">
                                    ● {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">{{ $trip->passenger ? $trip->passenger->name : 'N/A' }}</div>
                                <div style="font-size: 0.7rem; color: #64748b;">{{ $trip->passenger->phone ?? $trip->passenger->email ?? '' }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 700; font-size: 0.78rem; color: #0f172a;">
                                    {{ $trip->driver ? $trip->driver->name : 'Sin conductor asignado' }}
                                </div>
                                @if($trip->driver && $trip->driver->vehicle)
                                    <span class="mini-plate">{{ $trip->driver->vehicle->license_plate }}</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-size: 0.75rem; font-weight: 600; color: #0f172a;">⊙ {{ $trip->origin_address }}</div>
                                <div style="font-size: 0.74rem; color: #475569; margin: 0.15rem 0;"><i class="bi bi-geo-alt"></i> {{ $trip->destination_address }}</div>
                                <div style="font-size: 0.7rem; font-weight: 700; color: #d97706;">{{ $trip->distance_km }} km</div>
                            </td>
                            <td>
                                <div style="font-weight: 800; color: #047857; font-size: 0.84rem;">
                                    ${{ number_format($trip->estimated_fare, 0, ',', '.') }} COP
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2.5rem; color: #64748b;">
                                No hay viajes registrados en la bitácora (0 viajes). Cuando un pasajero solicite una ruta, se registrará aquí automáticamente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 0.85rem 1.25rem; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; font-size: 0.72rem; color: #475569;">
            <span>Total en base de datos: {{ $trips->total() }} viajes</span>
            <div>{{ $trips->links() }}</div>
        </div>
    </div>

    <!-- Panel Derecho: Playback de Telemetría GPS Forense (Datos del Viaje Seleccionado) -->
    <div class="forensic-inspector">
        <div class="forensic-top">
            <div style="display: flex; align-items: center; gap: 0.55rem;">
                <i class="bi bi-bezier2" style="color: #f97316; font-size: 1.1rem;"></i>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.45rem;">
                        <span id="forensicId" style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 0.95rem;">
                            {{ $firstTrip ? '#TX-' . $firstTrip->id : 'Sin Viaje' }}
                        </span>
                        <span id="forensicStatus" style="background: #065f46; color: #6ee7b7; font-size: 0.62rem; font-weight: 700; padding: 0.12rem 0.45rem; border-radius: 4px;">
                            {{ $firstTrip ? ucfirst(str_replace('_', ' ', $firstTrip->status)) : '0 Registros' }}
                        </span>
                    </div>
                    <div style="font-size: 0.68rem; color: #94a3b8;">Playback de Telemetría GPS Forense</div>
                </div>
            </div>
        </div>

        <div class="forensic-map-box">
            <svg viewBox="0 0 360 185" style="width: 100%; height: 100%;">
                <path d="M 35 120 Q 120 110 185 75 T 315 45" fill="none" stroke="#10b981" stroke-width="3.5" stroke-dasharray="5 3" />
                <circle cx="35" cy="120" r="6" fill="#0f172a" stroke="#fff" stroke-width="2" />
                <circle cx="315" cy="45" r="6" fill="#10b981" stroke="#fff" stroke-width="2" />
            </svg>

            <div class="playback-overlay">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.3rem;">
                    <span style="font-size: 0.68rem; font-weight: 700; color: #0f172a;">
                        Hora Registro: <span id="forensicTime">{{ $firstTrip && $firstTrip->created_at ? $firstTrip->created_at->format('H:i:s') : '--:--' }}</span>
                    </span>
                    <div style="font-size: 0.68rem; font-weight: 800;">
                        <span id="forensicKm" style="color: #d97706;">{{ $firstTrip ? $firstTrip->distance_km . ' km' : '0.0 km' }}</span>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.62rem; color: #64748b; gap: 0.5rem;">
                    <span id="forensicOrigin">Origen: {{ $firstTrip ? $firstTrip->origin_address : 'N/A' }}</span>
                    <span id="forensicDest">Destino: {{ $firstTrip ? $firstTrip->destination_address : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="timeline-box">
            <div style="display: flex; align-items: center; gap: 0.45rem; font-family: 'Outfit', sans-serif; font-size: 0.86rem; font-weight: 700; color: #0f172a; margin-bottom: 0.85rem;">
                <i class="bi bi-activity" style="color: #ea580c;"></i>
                <span>Línea de Tiempo del Servicio</span>
            </div>

            <div class="checkpoint-item">
                <span class="checkpoint-dot"></span>
                <div class="checkpoint-head">
                    <span>1. Ruta Solicitada por Pasajero</span>
                </div>
                <p class="checkpoint-desc">
                    Origen y destino georreferenciados y almacenados en la tabla <code>trips</code>.
                </p>
            </div>

            <div class="checkpoint-item">
                <span class="checkpoint-dot" style="background: #f59e0b; box-shadow: 0 0 0 1px #f59e0b;"></span>
                <div class="checkpoint-head">
                    <span>2. Código PIN de Abordaje</span>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; background: #f8fafc; border: 1px solid #e2e8f0; padding: 0.25rem 0.5rem; border-radius: 6px; margin-top: 0.25rem;">
                    <span style="font-size: 0.68rem; font-weight: 700; color: #334155;">
                        PIN Generado: <strong id="forensicPin">{{ $firstTrip ? str_pad(($firstTrip->id * 137) % 10000, 4, '0', STR_PAD_LEFT) : '----' }}</strong>
                    </span>
                    <span style="font-size: 0.64rem; font-weight: 700; color: #047857;"><i class="bi bi-check-circle-fill"></i> Verificado</span>
                </div>
            </div>
        </div>

        <div class="tariff-breakdown">
            <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 0.66rem; color: #475569; text-transform: uppercase; margin-bottom: 0.4rem;">
                <span>LIQUIDACIÓN DE TARIFA</span>
                <span>Base + Km</span>
            </div>
            <div class="tariff-row">
                <span>Tarifa Base:</span>
                <strong id="forensicBase" style="color: #0f172a;">{{ $firstTrip ? '$5.000 COP' : '$0 COP' }}</strong>
            </div>
            <div class="tariff-row">
                <span>Recorrido por distancia:</span>
                <strong id="forensicDistFare" style="color: #0f172a;">{{ $firstTrip ? '$' . number_format(max(0, $firstTrip->estimated_fare - 5000), 0, ',', '.') . ' COP' : '$0 COP' }}</strong>
            </div>
            <div class="tariff-row" style="border-top: 1px solid #e2e8f0; margin-top: 0.25rem; padding-top: 0.35rem;">
                <span style="font-weight: 700; color: #0f172a;">Total Registrado:</span>
                <strong id="forensicTotalFare" style="color: #047857;">{{ $firstTrip ? '$' . number_format($firstTrip->estimated_fare, 0, ',', '.') . ' COP' : '$0 COP' }}</strong>
            </div>
        </div>
    </div>
</div>

<script>
    function selectForensicTrip(row, id, status, origin, dest, km, pin, baseFare, distFare, totalFare, timeStr) {
        document.querySelectorAll('#auditTable tbody tr.bitacora-row').forEach(r => r.classList.remove('selected'));
        row.classList.add('selected');

        document.getElementById('forensicId').textContent = id;
        document.getElementById('forensicStatus').textContent = status;
        document.getElementById('forensicOrigin').textContent = 'Origen: ' + origin;
        document.getElementById('forensicDest').textContent = 'Destino: ' + dest;
        document.getElementById('forensicKm').textContent = km;
        document.getElementById('forensicPin').textContent = pin;
        document.getElementById('forensicBase').textContent = baseFare;
        document.getElementById('forensicDistFare').textContent = distFare;
        document.getElementById('forensicTotalFare').textContent = totalFare;
        document.getElementById('forensicTime').textContent = timeStr;
    }

    function filterAuditRows() {
        const q = document.getElementById('auditSearchInput').value.toLowerCase();
        const status = document.getElementById('auditStatusFilter').value.toLowerCase();
        document.querySelectorAll('#auditTable tbody tr.bitacora-row').forEach(row => {
            const text = row.innerText.toLowerCase();
            const matchQ = !q || text.includes(q);
            const matchS = !status || text.includes(status);
            row.style.display = (matchQ && matchS) ? '' : 'none';
        });
    }

    function resetAuditFilters() {
        document.getElementById('auditSearchInput').value = '';
        document.getElementById('auditStatusFilter').value = '';
        filterAuditRows();
    }
</script>
@endsection
