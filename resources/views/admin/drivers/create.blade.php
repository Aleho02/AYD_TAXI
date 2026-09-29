@extends('layouts.app')

@section('title', 'Registrar Conductor')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Registrar Nuevo Conductor de Taxi</h2>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>

        <form action="{{ route('admin.drivers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="name" class="form-label">Nombre del Conductor * (Máx. 100 caracteres)</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ej: Pedro Pablo Martínez">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico *</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="conductor@aydtaxi.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="license_number" class="form-label">Número de Licencia de Conducción *</label>
                    <input type="text" id="license_number" name="license_number" class="form-control" value="{{ old('license_number') }}" placeholder="LIC-UBT-12345">
                    @error('license_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Teléfono Móvil (Solo dígitos)</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="3119876543">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña de Acceso * (Mín. 6 caracteres)</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Sección de Carga de Fotografía del Conductor (Requerimiento Punto 5) -->
            <div class="form-group" style="background: rgba(15, 23, 42, 0.4); padding: 1.25rem; border-radius: 10px; border: 1px dashed var(--border-color);">
                <label for="photo" class="form-label" style="display: flex; align-items: center; justify-content: space-between;">
                    <span>📸 Fotografía del Conductor</span>
                    <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: normal;">Formatos: JPG, PNG, WEBP (Máx. 2MB)</span>
                </label>
                <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg,image/png,image/webp">
                <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.4rem;">
                    * Archivos como .pdf o .php serán rechazados estrictamente por las reglas de validación del sistema.
                </p>
                @error('photo')
                    <div class="invalid-feedback" style="display: block; font-weight: 600;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #cbd5e1;">
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', '1') ? 'checked' : '' }} style="accent-color: var(--primary);">
                    Habilitar disponibilidad inmediata para despacho de servicios
                </label>
            </div>

            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Registrar Conductor</button>
            </div>
        </form>
    </div>
</div>
@endsection
