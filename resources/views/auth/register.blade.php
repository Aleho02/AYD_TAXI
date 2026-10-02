@extends('layouts.app')

@section('title', 'Registro de Usuario')

@section('content')
<div style="max-width: 480px; margin: 2rem auto;">
    <div class="card" style="padding: 2.25rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="font-size: 2.5rem; margin-bottom: 0.5rem;"><i class="bi bi-person-plus-fill" style="color: var(--primary);"></i></div>
            <h2 style="font-size: 1.65rem; font-weight: 700;">Registro en AYD TAXII</h2>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-top: 0.35rem;">Crea tu cuenta para la plataforma del Valle de Ubaté</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Nombre Completo *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Ej: Juan Pérez">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico *</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="juan@ejemplo.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="role" class="form-label">Tipo de Usuario (Rol) *</label>
                <select id="role" name="role" class="form-control">
                    <option value="pasajero" {{ old('role') == 'pasajero' ? 'selected' : '' }}>Pasajero (Cliente)</option>
                    <option value="conductor" {{ old('role') == 'conductor' ? 'selected' : '' }}>Conductor de Taxi</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador / Operador</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">Teléfono Móvil</label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="Ej: 3101234567">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña *</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Mínimo 6 caracteres">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña *</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Repite tu contraseña">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.75rem; margin-top: 0.5rem;">
                Registrarse en AYD TAXII
            </button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center; font-size: 0.85rem; color: var(--text-muted);">
            ¿Ya tienes una cuenta? <a href="{{ route('login') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Inicia Sesión</a>
        </div>
    </div>
</div>
@endsection
