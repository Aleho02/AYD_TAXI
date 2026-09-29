@extends('layouts.app')

@section('title', 'Editar Conductor')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Editar Conductor: {{ $driver->name }}</h2>
            <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>

        <!-- Vista previa de fotografía actual y opción de eliminación (Punto 5) -->
        <div style="display: flex; align-items: center; justify-content: space-between; background: rgba(15, 23, 42, 0.4); padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; border: 1px solid var(--border-color);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                @if($driver->photo_path)
                    <img src="{{ asset('storage/' . $driver->photo_path) }}" alt="{{ $driver->name }}" style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover; border: 2px solid var(--primary);">
                    <div>
                        <div style="font-weight: 600; font-size: 0.95rem;">Fotografía actual almacenada</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted);">Ruta en storage: <code>{{ $driver->photo_path }}</code></div>
                    </div>
                @else
                    <div style="width: 64px; height: 64px; border-radius: 50%; background-color: #334155; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #94a3b8;">
                        👤
                    </div>
                    <div>
                        <div style="font-weight: 600; font-size: 0.95rem;">Sin fotografía cargada</div>
                        <div style="font-size: 0.78rem; color: var(--text-muted);">Puede adjuntar un archivo JPG, PNG o WEBP abajo</div>
                    </div>
                @endif
            </div>

            @if($driver->photo_path)
                <form action="{{ route('admin.drivers.photo.delete', $driver) }}" method="POST" onsubmit="return confirm('¿Seguro de eliminar la fotografía del conductor del almacenamiento?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar Foto</button>
                </form>
            @endif
        </div>

        <form action="{{ route('admin.drivers.update', $driver) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="name" class="form-label">Nombre del Conductor *</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $driver->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico *</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $driver->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="license_number" class="form-label">Número de Licencia *</label>
                    <input type="text" id="license_number" name="license_number" class="form-control" value="{{ old('license_number', $driver->license_number) }}">
                    @error('license_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Teléfono Móvil</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $driver->phone) }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Nueva Contraseña (Opcional - dejar en blanco para conservar actual)</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Reemplazo de Foto (Punto 5) -->
            <div class="form-group" style="background: rgba(15, 23, 42, 0.4); padding: 1.25rem; border-radius: 10px; border: 1px dashed var(--border-color);">
                <label for="photo" class="form-label" style="display: flex; align-items: center; justify-content: space-between;">
                    <span>📸 Reemplazar Fotografía</span>
                    <span style="font-size: 0.75rem; color: var(--text-muted);">JPG, PNG o WEBP (Máx. 2MB)</span>
                </label>
                <input type="file" id="photo" name="photo" class="form-control" accept="image/jpeg,image/png,image/webp">
                @error('photo')
                    <div class="invalid-feedback" style="display: block; font-weight: 600;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #cbd5e1;">
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', $driver->is_available) ? 'checked' : '' }} style="accent-color: var(--primary);">
                    Conductor disponible para recibir servicios
                </label>
            </div>

            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
