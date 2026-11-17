@extends('layouts.app')

@section('title', 'Tarifas y Zonas Veredales - TaxiUbaté')

@section('content')
<div style="display: flex; align-items: flex-end; justify-content: space-between; gap: 1.5rem; margin-bottom: 1.4rem; flex-wrap: wrap;">
    <div>
        <div style="font-size: 0.66rem; font-weight: 800; color: #ea580c; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 0.3rem;">
            DECRETO MUNICIPAL No. 084 DE 2025 • ALCALDÍA DE UBATÉ
        </div>
        <h1 style="font-family: 'Outfit', sans-serif; font-size: 1.85rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px;">
            Matriz Oficial de Tarifas y Zonificación Veredal
        </h1>
        <p style="font-size: 0.82rem; color: #64748b; margin-top: 0.25rem; max-width: 620px;">
            Parámetros de liquidación de taxímetro GPS, banderazo urbano, recargos nocturnos/festivos y tarifas reguladas hacia las 18 veredas del Valle de Ubaté.
        </p>
    </div>

    <div style="display: flex; gap: 0.6rem;">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
            <i class="bi bi-broadcast-pin"></i> Volver a Despacho
        </a>
        <button type="button" class="btn btn-primary" onclick="window.print()">
            <i class="bi bi-file-earmark-spreadsheet"></i> Exportar Tabla Oficial
        </button>
    </div>
</div>

<!-- Parámetros Base de Liquidación -->
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.15rem; margin-bottom: 1.35rem;">
    <div class="card" style="margin-bottom: 0;">
        <div style="font-size: 0.66rem; font-weight: 800; color: #64748b; text-transform: uppercase;">TARIFA MÍNIMA URBANA</div>
        <div style="font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0.4rem 0;">$6.000 <span style="font-size: 0.75rem; color: #64748b;">COP</span></div>
        <div style="font-size: 0.72rem; color: #047857; font-weight: 600;">● Casco Urbano Ubaté</div>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <div style="font-size: 0.66rem; font-weight: 800; color: #64748b; text-transform: uppercase;">ARRANQUE / BANDERAZO</div>
        <div style="font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0.4rem 0;">$3.800 <span style="font-size: 0.75rem; color: #64748b;">COP</span></div>
        <div style="font-size: 0.72rem; color: #64748b;">Caída cada 100m: $120 COP</div>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <div style="font-size: 0.66rem; font-weight: 800; color: #64748b; text-transform: uppercase;">RECARGO VEREDAL BASE</div>
        <div style="font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #ea580c; margin: 0.4rem 0;">+$4.500 <span style="font-size: 0.75rem; color: #64748b;">COP</span></div>
        <div style="font-size: 0.72rem; color: #b45309; font-weight: 600;">Homologado para 18 veredas</div>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <div style="font-size: 0.66rem; font-weight: 800; color: #64748b; text-transform: uppercase;">RECARGO NOCTURNO / FESTIVO</div>
        <div style="font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #0f172a; margin: 0.4rem 0;">+$1.500 <span style="font-size: 0.75rem; color: #64748b;">COP</span></div>
        <div style="font-size: 0.72rem; color: #64748b;">20:00 PM a 05:00 AM</div>
    </div>
</div>

<!-- Tabla de Tarifas por Sector Veredal y Provincial -->
<div class="card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1rem 1.35rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #0f172a;">
            Zonificación Tarifaria Homologada — Provincia del Valle de Ubaté
        </h3>
        <span class="status-badge status-success">Vigente 2025 - 2026</span>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>ZONA / VEREDA</th>
                    <th>COBERTURA TERRITORIAL</th>
                    <th>DISTANCIA PROMEDIO</th>
                    <th>TARIFA REGULADA DIURNA</th>
                    <th>TARIFA NOCTURNA / DOMINICAL</th>
                    <th>ESTADO GPS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong style="color: #0f172a;">Zona 1 • Casco Urbano</strong></td>
                    <td>Centro, Parque Principal, Hospital El Salvador, Terminal</td>
                    <td>1.2 - 3.0 km</td>
                    <td><strong style="color: #047857;">$6.000 - $7.500 COP</strong></td>
                    <td>$7.500 - $9.000 COP</td>
                    <td><span class="status-badge status-success">● Geo-Cerca Activa</span></td>
                </tr>
                <tr>
                    <td><strong style="color: #0f172a;">Zona 2 • Veredas Cercanas</strong></td>
                    <td>San Cayetano, Palogordo, La Patera, Centro Acopio</td>
                    <td>3.5 - 6.0 km</td>
                    <td><strong style="color: #047857;">$12.000 - $14.500 COP</strong></td>
                    <td>$14.000 - $16.500 COP</td>
                    <td><span class="status-badge status-success">● Geo-Cerca Activa</span></td>
                </tr>
                <tr>
                    <td><strong style="color: #0f172a;">Zona 3 • Veredas Altas</strong></td>
                    <td>El Volcán, Las Peñas, Sucunchoque, Guatanfur, Tausavita</td>
                    <td>6.0 - 11.5 km</td>
                    <td><strong style="color: #047857;">$16.000 - $22.000 COP</strong></td>
                    <td>$18.500 - $24.500 COP</td>
                    <td><span class="status-badge status-success">● Respaldo Satelital</span></td>
                </tr>
                <tr>
                    <td><strong style="color: #0f172a;">Zona 4 • Intermunicipal</strong></td>
                    <td>Sutatausa, Carmen de Carupa, Guachetá, Fúquene, Lenguazaque</td>
                    <td>12.0 - 24.0 km</td>
                    <td><strong style="color: #047857;">$25.000 - $42.000 COP</strong></td>
                    <td>$28.000 - $46.000 COP</td>
                    <td><span class="status-badge status-info">● Planilla Ocasional</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
