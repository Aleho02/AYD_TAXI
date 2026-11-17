@extends('layouts.app')

@section('title', 'Gestión de Flota, Empresas Afiliadas y Conductores')

@section('content')
<style>
    .module-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .module-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.45rem;
    }

    .module-tag-orange {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #b45309;
        line-height: 1.2;
    }

    .module-tag-res {
        font-size: 0.7rem;
        font-weight: 600;
        color: #475569;
        padding-left: 0.75rem;
        border-left: 2px solid #cbd5e1;
        line-height: 1.25;
    }

    .module-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.95rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.12;
        letter-spacing: -0.6px;
        max-width: 540px;
        margin-bottom: 0.55rem;
    }

    .module-desc {
        font-size: 0.84rem;
        color: #64748b;
        line-height: 1.5;
        max-width: 580px;
    }

    .module-actions {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        flex-wrap: wrap;
    }

    .fleet-kpi-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.2rem;
        margin-bottom: 1.35rem;
    }

    .fleet-kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem 1.35rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
    }

    .fleet-kpi-card.card-amber-border {
        border-color: #fde68a;
        background: linear-gradient(180deg, #ffffff 0%, #fffdf9 100%);
    }

    .fleet-kpi-card.card-red-border {
        border-color: #fecaca;
        background: linear-gradient(180deg, #ffffff 0%, #fffafa 100%);
    }

    .fleet-kpi-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 0.5rem;
    }

    .fleet-kpi-title {
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #475569;
        line-height: 1.35;
    }

    .fleet-kpi-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
    }

    .fleet-kpi-num-row {
        display: flex;
        align-items: baseline;
        gap: 0.55rem;
        margin-bottom: 0.55rem;
    }

    .fleet-kpi-num {
        font-family: 'Outfit', sans-serif;
        font-size: 2.3rem;
        font-weight: 800;
        color: #0f172a;
        line-height: 1;
    }

    .fleet-kpi-desc {
        font-size: 0.76rem;
        color: #64748b;
        line-height: 1.45;
        margin-bottom: 1rem;
    }

    .fleet-kpi-footer {
        padding-top: 0.7rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.7rem;
        color: #64748b;
    }

    .filter-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
    }

    .filter-search {
        flex: 1;
        min-width: 210px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.45rem 0.75rem;
    }

    .filter-search input {
        border: none;
        background: transparent;
        outline: none;
        width: 100%;
        font-size: 0.8rem;
        color: #0f172a;
    }

    .filter-select {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.46rem 0.8rem;
        font-size: 0.78rem;
        font-weight: 600;
        color: #334155;
        outline: none;
        cursor: pointer;
    }

    .padron-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.03);
    }

    .padron-header {
        padding: 1rem 1.35rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .padron-count-pill {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.2rem 0.55rem;
        border-radius: 6px;
    }

    .cat-badge {
        display: inline-block;
        background: #064e3b;
        color: #6ee7b7;
        font-size: 0.62rem;
        font-weight: 800;
        padding: 0.15rem 0.38rem;
        border-radius: 4px;
        line-height: 1.1;
        text-align: center;
    }

    .legal-pills {
        display: flex;
        flex-direction: column;
        gap: 0.28rem;
        align-items: flex-start;
    }

    .legal-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.66rem;
        font-weight: 700;
        padding: 0.16rem 0.5rem;
        border-radius: 5px;
    }

    .legal-ok { background: #dcfce7; color: #15803d; }
    .legal-warn { background: #fef3c7; color: #b45309; }

    .switch-btn {
        background: transparent;
        border: none;
        cursor: pointer;
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        gap: 0.22rem;
    }

    .switch-track {
        width: 40px;
        height: 22px;
        border-radius: 999px;
        position: relative;
        transition: background 0.2s;
    }

    .switch-track.on { background: #10b981; }
    .switch-track.off { background: #e2e8f0; }

    .switch-thumb {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: #ffffff;
        position: absolute;
        top: 3px;
        transition: left 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }

    .switch-track.on .switch-thumb { left: 21px; }
    .switch-track.off .switch-thumb { left: 3px; }

    .switch-label {
        font-size: 0.58rem;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .action-icon-btn {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #334155;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 0.8rem;
        cursor: pointer;
    }

    .action-icon-btn:hover {
        background: #eff6ff;
        color: #1d4ed8;
        border-color: #bfdbfe;
    }

    .action-icon-btn.danger:hover {
        background: #fef2f2;
        color: #dc2626;
        border-color: #fecaca;
    }

    .padron-footer {
        padding: 0.9rem 1.35rem;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.74rem;
        color: #475569;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    @media (max-width: 1100px) {
        .fleet-kpi-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- CABECERA DEL MÓDULO -->
<div class="module-header">
    <div>
        <div class="module-meta">
            <span class="module-tag-orange">MÓDULO<br>REGULADOR<br>PROVINCIAL</span>
            <span class="module-tag-res">Resolución MinTransporte<br>No. 1080 / Vigencia 2025</span>
        </div>
        <h1 class="module-title">Gestión de Flota, Empresas Afiliadas y Conductores</h1>
        <p class="module-desc">
            Supervisión integral del padrón municipal del Valle de Ubaté con datos reales de la base de datos.
        </p>
    </div>

    <div class="module-actions">
        <a href="{{ route('admin.fleet.index') }}" class="btn btn-outline">
            <i class="bi bi-car-front"></i> Parque Automotor / Flota
        </a>
        <button type="button" class="btn btn-outline" onclick="window.print()">
            <i class="bi bi-download"></i> Exportar Padrón
        </button>
        <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> + Vincular Conductor / Móvil
        </a>
    </div>
</div>

<!-- 3 TARJETAS DE RESUMEN (100% REALES DESDE BD) -->
<div class="fleet-kpi-grid">
    <div class="fleet-kpi-card">
        <div>
            <div class="fleet-kpi-top">
                <span class="fleet-kpi-title">CONDUCTORES HABILITADOS</span>
                <div class="fleet-kpi-icon" style="background: #ecfdf5; color: #10b981;">
                    <i class="bi bi-patch-check"></i>
                </div>
            </div>
            <div class="fleet-kpi-num-row">
                <span class="fleet-kpi-num">{{ $driverStats['total_drivers'] ?? $drivers->total() }}</span>
                <span class="status-badge status-success" style="font-size: 0.7rem;">{{ $driverStats['active_drivers'] ?? 0 }} Activos</span>
            </div>
            <p class="fleet-kpi-desc">
                Conductores registrados en la base de datos del sistema AYD TAXI.
            </p>
        </div>
        <div class="fleet-kpi-footer">
            <span>Con vehículo asignado: {{ $driverStats['with_vehicle'] ?? 0 }}</span>
            <a href="{{ route('admin.fleet.index') }}" style="color: #0f172a; font-weight: 700; text-decoration: underline;">Ver Flota</a>
        </div>
    </div>

    <div class="fleet-kpi-card card-amber-border">
        <div>
            <div class="fleet-kpi-top">
                <span class="fleet-kpi-title">PENDIENTES DE VEHÍCULO</span>
                <div class="fleet-kpi-icon" style="background: #fffbeb; color: #d97706;">
                    <i class="bi bi-clipboard2-check"></i>
                </div>
            </div>
            <div class="fleet-kpi-num-row">
                <span class="fleet-kpi-num">{{ $driverStats['without_vehicle'] ?? 0 }}</span>
                <span class="status-badge status-warning" style="font-size: 0.7rem;">Sin Taxi</span>
            </div>
            <p class="fleet-kpi-desc">
                Conductores registrados que aún no tienen un vehículo vinculado en la tabla de flota.
            </p>
        </div>
        <div class="fleet-kpi-footer">
            <span>Asignación directa</span>
            <a href="{{ route('admin.fleet.create') }}" style="color: #b45309; font-weight: 700; text-decoration: none;">+ Vincular Vehículo</a>
        </div>
    </div>

    <div class="fleet-kpi-card card-red-border">
        <div>
            <div class="fleet-kpi-top">
                <span class="fleet-kpi-title" style="color: #dc2626;">CONDUCTORES INACTIVOS / OFF</span>
                <div class="fleet-kpi-icon" style="background: #fef2f2; color: #ef4444;">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
            <div class="fleet-kpi-num-row">
                <span class="fleet-kpi-num">{{ $driverStats['inactive_drivers'] ?? 0 }}</span>
                <span class="status-badge status-danger" style="font-size: 0.7rem;">Fuera de Turno</span>
            </div>
            <p class="fleet-kpi-desc">
                Conductores con disponibilidad desactivada temporalmente para despacho.
            </p>
        </div>
        <div class="fleet-kpi-footer">
            <span>Control en tiempo real</span>
            <a href="{{ route('admin.drivers.create') }}" style="color: #dc2626; font-weight: 700; text-decoration: none;">+ Nuevo Conductor</a>
        </div>
    </div>
</div>

<!-- BARRA DE FILTROS -->
<div class="filter-bar">
    <div class="filter-search">
        <i class="bi bi-search" style="color: #94a3b8; font-size: 0.82rem;"></i>
        <input type="text" id="driverFilterInput" placeholder="Filtrar por nombre, licencia, correo o placa..." onkeyup="filterDriversTable()">
    </div>

    <select class="filter-select" id="statusFilterSelect" onchange="filterDriversTable()">
        <option value="">Operatividad: Todos</option>
        <option value="ACTIVO">Activo</option>
        <option value="INACTIVO">Inactivo</option>
    </select>

    <button type="button" class="btn btn-outline btn-sm" onclick="resetDriversFilter()">
        <i class="bi bi-arrow-counterclockwise"></i> Limpiar
    </button>
</div>

<!-- TABLA PADRÓN DE CONDUCTORES (100% REAL DE BD) -->
<div class="padron-card">
    <div class="padron-header">
        <div style="display: flex; align-items: center; gap: 0.65rem;">
            <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 700; color: #0f172a;">
                Padrón de Conductores y Unidades Habilitadas
            </h3>
            <span class="padron-count-pill">{{ $drivers->total() }} Registros Reales en BD</span>
        </div>

        <div style="display: flex; align-items: center; gap: 0.65rem; font-size: 0.76rem; color: #64748b;">
            <a href="{{ route('admin.fleet.create') }}" class="btn btn-outline btn-sm">+ Registrar Vehículo</a>
        </div>
    </div>

    <div class="table-responsive">
        <table id="padronTable">
            <thead>
                <tr>
                    <th>CONDUCTOR &<br>IDENTIFICACIÓN</th>
                    <th>VEHÍCULO /<br>PLACA OFICIAL</th>
                    <th>CONTACTO &<br>EMAIL</th>
                    <th>ESTADO<br>DOCUMENTAL</th>
                    <th>VIAJES<br>REALIZADOS</th>
                    <th style="text-align: center;">ESTADO<br>OPERATIVO</th>
                    <th style="text-align: right;">ACCIONES<br>RÁPIDAS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($drivers as $driver)
                    <tr class="driver-row">
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                @if($driver->photo_path)
                                    <img src="{{ asset('storage/' . $driver->photo_path) }}" alt="{{ $driver->name }}" class="avatar">
                                @else
                                    <div class="avatar" style="background: linear-gradient(135deg, #0f172a, #334155);">
                                        {{ strtoupper(substr($driver->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight: 700; font-size: 0.88rem; color: #0f172a; line-height: 1.25;">
                                        {{ $driver->name }}
                                    </div>
                                    <div style="font-size: 0.72rem; color: #64748b; margin-top: 0.15rem; display: flex; align-items: center; gap: 0.4rem;">
                                        <span>Lic: {{ $driver->license_number ?? 'Pendiente' }}</span>
                                        <span class="cat-badge">C2</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($driver->vehicle)
                                <div class="plate-badge" style="margin-bottom: 0.3rem;">
                                    <span class="plate-col">COL</span>
                                    <span>{{ $driver->vehicle->license_plate }}</span>
                                </div>
                                <div style="font-size: 0.73rem; color: #475569;">
                                    {{ $driver->vehicle->brand }} {{ $driver->vehicle->model }} ({{ $driver->vehicle->year }})
                                </div>
                            @else
                                <span style="font-size: 0.76rem; color: #94a3b8; display: block; margin-bottom: 0.25rem;">Sin vehículo vinculado</span>
                                <a href="{{ route('admin.fleet.create') }}" style="font-size: 0.72rem; color: #ea580c; font-weight: 600; text-decoration: none;">+ Asignar Taxi</a>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight: 600; font-size: 0.8rem; color: #0f172a;">{{ $driver->email }}</div>
                            <div style="font-size: 0.72rem; color: #64748b;">Tel: {{ $driver->phone ?? 'Sin teléfono' }}</div>
                        </td>
                        <td>
                            <div class="legal-pills">
                                <span class="legal-pill {{ $driver->license_number ? 'legal-ok' : 'legal-warn' }}">
                                    ● Lic: {{ $driver->license_number ? 'Vigente' : 'Pendiente' }}
                                </span>
                                <span class="legal-pill {{ $driver->vehicle ? 'legal-ok' : 'legal-warn' }}">
                                    ● T.O.: {{ $driver->vehicle ? ucfirst($driver->vehicle->status) : 'Sin Móvil' }}
                                </span>
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 800; font-size: 0.86rem; color: #0f172a;">
                                {{ $driver->driver_trips_count ?? 0 }} carreras
                            </div>
                            <div style="font-size: 0.7rem; color: #64748b; margin-top: 0.15rem;">
                                GPS: {{ $driver->latitude ? number_format($driver->latitude, 4) . ', ' . number_format($driver->longitude, 4) : 'Sin señal' }}
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <form action="{{ route('admin.drivers.toggle', $driver) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="switch-btn" title="Cambiar disponibilidad">
                                    <div class="switch-track {{ $driver->is_available ? 'on' : 'off' }}">
                                        <div class="switch-thumb"></div>
                                    </div>
                                    <span class="switch-label" style="color: {{ $driver->is_available ? '#047857' : '#94a3b8' }};">
                                        {{ $driver->is_available ? 'ACTIVO' : 'INACTIVO' }}
                                    </span>
                                </button>
                            </form>
                        </td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 0.35rem;">
                                <a href="{{ route('admin.drivers.edit', $driver) }}" class="action-icon-btn" title="Editar Conductor / Fotografía">
                                    <i class="bi bi-person-vcard"></i>
                                </a>
                                @if($driver->vehicle)
                                    <a href="{{ route('admin.fleet.edit', $driver->vehicle) }}" class="action-icon-btn" title="Editar Vehículo">
                                        <i class="bi bi-car-front"></i>
                                    </a>
                                @endif
                                <form action="{{ route('admin.drivers.destroy', $driver) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar conductor y su fotografía?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-icon-btn danger" title="Eliminar Conductor">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2.5rem; color: #64748b;">
                            No hay conductores registrados en la base de datos (0 conductores). Haz clic en <strong>"+ Vincular Conductor / Móvil"</strong> para registrar el primero.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="padron-footer">
        <div style="display: flex; align-items: center; gap: 0.45rem;">
            <i class="bi bi-check-circle" style="color: #047857;"></i>
            <span>Datos sincronizados en tiempo real con la base de datos del sistema.</span>
        </div>
        <div>
            {{ $drivers->links() }}
        </div>
    </div>
</div>

<script>
    function filterDriversTable() {
        const search = document.getElementById('driverFilterInput').value.toLowerCase();
        const status = document.getElementById('statusFilterSelect').value.toUpperCase();
        const rows = document.querySelectorAll('#padronTable tbody tr.driver-row');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            const matchesSearch = !search || text.includes(search);
            const matchesStatus = !status || row.innerText.toUpperCase().includes(status);
            row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
        });
    }

    function resetDriversFilter() {
        document.getElementById('driverFilterInput').value = '';
        document.getElementById('statusFilterSelect').value = '';
        filterDriversTable();
    }
</script>
@endsection
