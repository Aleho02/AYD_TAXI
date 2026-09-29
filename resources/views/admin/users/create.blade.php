@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Crear Nuevo Usuario</h2>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">Volver</a>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Nombre Completo * (Máx. 100 caracteres)</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ej: Diana Prince">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico *</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="correo@ejemplo.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="role" class="form-label">Rol del Usuario *</label>
                    <select id="role" name="role" class="form-control">
                        <option value="pasajero" {{ old('role') == 'pasajero' ? 'selected' : '' }}>Pasajero</option>
                        <option value="conductor" {{ old('role') == 'conductor' ? 'selected' : '' }}>Conductor</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Teléfono (Solo números, máx 20)</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="3101234567">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña * (Mín. 6 caracteres)</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Registrar Usuario</button>
            </div>
        </form>
    </div>
</div>
@endsection
