@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div style="max-width: 440px; margin: 3rem auto;">
    <div class="card" style="padding: 2.25rem;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="font-size: 2.8rem; margin-bottom: 0.5rem;">🚖</div>
            <h2 style="font-size: 1.65rem; font-weight: 700;">Ingreso al Sistema</h2>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-top: 0.35rem;">AYD TAXII - Valle de Ubaté</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="ejemplo@aydtaxi.com" autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; font-size: 0.85rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); cursor: pointer;">
                    <input type="checkbox" name="remember" style="accent-color: var(--primary);"> Recordarme
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 0.75rem;">
                Iniciar Sesión
            </button>
        </form>

        <div style="margin-top: 1.75rem; text-align: center; font-size: 0.85rem; color: var(--text-muted);">
            ¿No tienes una cuenta? <a href="{{ route('register') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Regístrate</a>
        </div>

        <div style="margin-top: 2rem; padding-top: 1.25rem; border-top: 1px dashed var(--border-color); font-size: 0.8rem; color: var(--text-muted);">
            <strong>Credenciales de prueba:</strong><br>
            • Admin: <code>admin@aydtaxi.com</code> | <code>password123</code><br>
            • Conductor: <code>conductor@aydtaxi.com</code> | <code>password123</code><br>
            • Pasajero: <code>pasajero@aydtaxi.com</code> | <code>password123</code>
        </div>
    </div>
</div>
@endsection
