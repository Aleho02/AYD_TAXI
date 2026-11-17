@extends('layouts.app')

@section('title', 'Iniciar Sesión - TaxiUbaté')

@section('content')
<style>
    .auth-card-wrap {
        width: 100%;
        max-width: 455px;
        margin: 0 auto;
    }

    .auth-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.75rem 1.85rem;
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.06);
    }

    .telematic-top-bar {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.55rem 0.8rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        margin-bottom: 1.35rem;
    }

    .role-tabs-box {
        background: #e8eef5;
        border-radius: 10px;
        padding: 0.25rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.25rem;
        margin-bottom: 0.85rem;
    }

    .role-tab-btn {
        border: none;
        background: transparent;
        padding: 0.48rem 0.5rem;
        border-radius: 7px;
        font-size: 0.76rem;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
        transition: all 0.15s;
    }

    .role-tab-btn.active {
        background: #ffffff;
        color: #0f172a;
        font-weight: 700;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.08);
    }

    .role-info-strip {
        background: #f1f5f9;
        border-radius: 8px;
        padding: 0.55rem 0.8rem;
        display: flex;
        align-items: center;
        gap: 0.55rem;
        font-size: 0.72rem;
        font-weight: 600;
        color: #334155;
        line-height: 1.35;
        margin-bottom: 1.15rem;
    }

    .input-icon-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon-left {
        position: absolute;
        left: 0.85rem;
        color: #64748b;
        font-size: 0.9rem;
        pointer-events: none;
    }

    .auth-input {
        width: 100%;
        background: #eef2f6;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        padding: 0.7rem 0.9rem 0.7rem 2.45rem;
        font-size: 0.84rem;
        color: #0f172a;
        outline: none;
        transition: all 0.18s;
    }

    .auth-input:focus {
        background: #ffffff;
        border-color: #0f172a;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
    }

    .btn-submit-black {
        width: 100%;
        background: #050505;
        color: #ffffff;
        border: none;
        border-radius: 9px;
        padding: 0.8rem 1rem;
        font-size: 0.86rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: opacity 0.18s;
    }

    .btn-submit-black:hover {
        opacity: 0.92;
    }

    .divider-or {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0.95rem 0;
        font-size: 0.64rem;
        font-weight: 800;
        color: #64748b;
        letter-spacing: 0.5px;
    }

    .divider-or::before, .divider-or::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .legal-footer-box {
        background: #f1f5f9;
        border-radius: 11px;
        padding: 0.9rem;
        margin-top: 1.25rem;
    }
</style>

<div class="auth-card-wrap">
    <div class="auth-card">
        <!-- Barra Superior Sistema Telemático Oficial (Imagen 4) -->
        <div class="telematic-top-bar">
            <div style="display: flex; align-items: center; gap: 0.45rem;">
                <i class="bi bi-shield-check" style="color: #10b981; font-size: 0.95rem;"></i>
                <span style="font-size: 0.62rem; font-weight: 800; color: #334155; letter-spacing: 0.3px; line-height: 1.2;">
                    SISTEMA TELEMÁTICO OFICIAL<br>UBATÉ
                </span>
            </div>
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; padding: 0.22rem 0.6rem; font-size: 0.6rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 0.35rem; line-height: 1.15;">
                <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981;"></span>
                <span>DESPACHO<br>ACTIVO</span>
            </div>
        </div>

        <!-- Marca TaxiUbaté -->
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.65rem;">
            <a href="{{ route('inicio') }}" style="width: 40px; height: 40px; border-radius: 9px; background: linear-gradient(135deg, #f97316, #ea580c); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; text-decoration: none; box-shadow: 0 3px 8px rgba(234, 88, 12, 0.25);">
                <i class="bi bi-taxi-front-fill"></i>
            </a>
            <div>
                <div style="font-family: 'Outfit', sans-serif; font-size: 1.25rem; font-weight: 800; color: #0f172a; line-height: 1.1;">
                    TaxiUbaté
                </div>
                <div style="font-size: 0.6rem; font-weight: 800; color: #64748b; letter-spacing: 0.5px; text-transform: uppercase; margin-top: 2px;">
                    ALCALDÍA MUNICIPAL • VALLE DE UBATÉ
                </div>
            </div>
        </div>

        <p style="font-size: 0.8rem; color: #475569; line-height: 1.4; margin-bottom: 1rem;">
            Iniciar Sesión en el Portal Unificado de Movilidad y Telemetría.
        </p>

        <!-- Selector de Rol Visual (Pasajero | Conductor | Despacho) -->
        <div class="role-tabs-box">
            <button type="button" class="role-tab-btn {{ request('role') !== 'conductor' && request('role') !== 'admin' ? 'active' : '' }}" onclick="switchLoginRole(this, 'pasajero', 'Acceso a reservas urbanas, historial tarifario y soporte en ruta.', 'pasajero@aydtaxi.com')">
                <i class="bi bi-person"></i> Pasajero
            </button>
            <button type="button" class="role-tab-btn {{ request('role') === 'conductor' ? 'active' : '' }}" onclick="switchLoginRole(this, 'conductor', 'Recepción de despacho GPS, liquidación de turno y vigencias RUNT.', 'conductor@aydtaxi.com')">
                <i class="bi bi-person-vcard"></i> Conductor
            </button>
            <button type="button" class="role-tab-btn {{ request('role') === 'admin' ? 'active' : '' }}" onclick="switchLoginRole(this, 'admin', 'Central de Control STT: Monitoreo satelital, flota y auditoría forense.', 'admin@aydtaxi.com')">
                <i class="bi bi-sliders"></i> Despacho
            </button>
        </div>

        <div class="role-info-strip" id="loginRoleInfo">
            <i class="bi bi-taxi-front" style="color: #b45309; font-size: 0.95rem;"></i>
            <span id="loginRoleText">Acceso a reservas urbanas, historial tarifario y soporte en ruta.</span>
        </div>

        <!-- Formulario de Inicio de Sesión -->
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label" style="font-size: 0.74rem; color: #0f172a;">Número de Celular o Correo</label>
                <div class="input-icon-group">
                    <i class="bi bi-person-Vcard input-icon-left bi-person-badge"></i>
                    <input type="email" id="email" name="email" class="auth-input" value="{{ old('email') }}" placeholder="310 123 4567 o usuario@gmail.com" autofocus>
                </div>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label" style="font-size: 0.74rem; color: #0f172a;">Contraseña Personal</label>
                <div class="input-icon-group">
                    <i class="bi bi-lock input-icon-left"></i>
                    <input type="password" id="password" name="password" class="auth-input" placeholder="••••••••••••" style="padding-right: 2.5rem;">
                    <button type="button" id="togglePassword" style="position: absolute; right: 0.75rem; background: none; border: none; color: #64748b; cursor: pointer; font-size: 0.95rem;">
                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.15rem; font-size: 0.74rem;">
                <label style="display: flex; align-items: center; gap: 0.45rem; color: #0f172a; font-weight: 600; cursor: pointer;">
                    <input type="checkbox" name="remember" checked style="accent-color: #0f172a; width: 15px; height: 15px;">
                    Recordar por 30 días
                </label>
                <a href="{{ route('password.request') }}" style="color: #92400e; font-weight: 700; text-decoration: none;">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <button type="submit" class="btn-submit-black">
                <i class="bi bi-box-arrow-in-right"></i> Ingresar a mi Cuenta
            </button>
        </form>

        <div style="text-align: center; margin-top: 0.75rem; font-size: 0.68rem; font-weight: 600; color: #0f172a;">
            <i class="bi bi-lock" style="color: #10b981;"></i> Conexión cifrada TLS 1.3 • SHA-256 Certificada
        </div>

        <div class="divider-or">O INGRESA CON</div>

        <a href="{{ route('password.request') }}" style="width: 100%; background: #eef2f6; border: 1px solid #e2e8f0; border-radius: 9px; padding: 0.65rem; font-size: 0.76rem; font-weight: 700; color: #0f172a; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.45rem;">
            <i class="bi bi-chat-square-dots" style="color: #10b981;"></i> Código SMS inmediato al celular registrado
        </a>

        <div style="text-align: center; margin-top: 1rem; font-size: 0.74rem; color: #475569;">
            ¿Aún no tienes cuenta?
            <a href="{{ route('register') }}" style="color: #92400e; font-weight: 700; text-decoration: underline;">
                Regístrate como Pasajero o Conductor
            </a>
        </div>

        <!-- Pie Legal y Radio Central -->
        <div class="legal-footer-box">
            <div style="display: flex; align-items: flex-start; gap: 0.5rem; font-size: 0.68rem; color: #475569; line-height: 1.4; margin-bottom: 0.7rem;">
                <i class="bi bi-hammer" style="color: #0f172a; margin-top: 2px;"></i>
                <span>
                    Acceso regulado por la <strong style="color: #0f172a;">Secretaría de Tránsito y Transporte de Ubaté</strong> (Decreto STT-2024). Tus datos están protegidos bajo la Ley Estatutaria 1581 de Habeas Data.
                </span>
            </div>

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 7px; padding: 0.42rem 0.65rem; display: flex; align-items: center; justify-content: space-between; font-size: 0.68rem;">
                <span style="font-weight: 700; color: #0f172a;">
                    <i class="bi bi-headset" style="color: #b45309;"></i> Central 24/7: (601) 855-3000
                </span>
                <span style="background: #dbeafe; color: #1e40af; font-size: 0.62rem; font-weight: 800; padding: 0.14rem 0.45rem; border-radius: 4px;">
                    Canal Radial #1
                </span>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const icon = document.getElementById('togglePasswordIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });

    function switchLoginRole(btn, role, text, demoEmail) {
        document.querySelectorAll('.role-tabs-box .role-tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('loginRoleText').textContent = text;
        const emailInput = document.getElementById('email');
        if (!emailInput.value || emailInput.value.endsWith('@aydtaxi.com')) {
            emailInput.value = demoEmail;
        }
    }
</script>
@endsection
