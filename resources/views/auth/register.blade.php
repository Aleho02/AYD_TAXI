@extends('layouts.app')

@section('title', 'Crear Cuenta en TaxiUbaté')

@section('content')
<style>
    .reg-card-wrap {
        width: 100%;
        max-width: 485px;
        margin: 0 auto;
    }

    .reg-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.85rem 1.95rem;
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.06);
    }

    .reg-role-grid {
        background: #e8eef5;
        border-radius: 11px;
        padding: 0.3rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.35rem;
        margin-bottom: 1.25rem;
    }

    .reg-role-card {
        padding: 0.65rem 0.85rem;
        border-radius: 8px;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.15s;
    }

    .reg-role-card.active {
        background: #ffffff;
        border-color: #e2e8f0;
        box-shadow: 0 2px 5px rgba(15, 23, 42, 0.06);
    }

    .reg-section-box {
        background: #f4f7fb;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.05rem 1.15rem;
        margin-bottom: 1rem;
    }

    .reg-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.85rem;
    }

    .step-circle-black {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #0f172a;
        color: #ffffff;
        font-size: 0.68rem;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .reg-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .reg-input-icon {
        position: absolute;
        left: 0.75rem;
        color: #64748b;
        font-size: 0.85rem;
        pointer-events: none;
    }

    .reg-input {
        width: 100%;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.6rem 0.8rem 0.6rem 2.25rem;
        font-size: 0.8rem;
        color: #0f172a;
        outline: none;
    }

    .reg-input:focus {
        border-color: #0f172a;
    }

    .reg-label {
        display: block;
        font-size: 0.7rem;
        font-weight: 700;
        color: #334155;
        margin-bottom: 0.3rem;
    }

    .guarantees-box {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem 1.15rem;
        margin-top: 1.25rem;
    }
</style>

<div class="reg-card-wrap">
    <div class="reg-card">
        <!-- Badge Superior (Imagen 5) -->
        <div style="display: inline-flex; align-items: center; gap: 0.35rem; background: #f1f5f9; border: 1px solid #e2e8f0; padding: 0.22rem 0.65rem; border-radius: 99px; font-size: 0.62rem; font-weight: 800; color: #334155; letter-spacing: 0.4px; margin-bottom: 0.65rem;">
            <i class="bi bi-patch-check" style="color: #b45309;"></i> SISTEMA OFICIAL DE MOVILIDAD
        </div>

        <h1 style="font-family: 'Outfit', sans-serif; font-size: 1.55rem; font-weight: 800; color: #0f172a; letter-spacing: -0.4px; margin-bottom: 0.25rem;">
            Crear Cuenta en TaxiUbaté
        </h1>
        <p style="font-size: 0.78rem; color: #64748b; line-height: 1.4; margin-bottom: 1.15rem;">
            Únete a la red formal y segura de movilidad provincial de Ubaté.
        </p>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="hidden" name="role" id="roleInput" value="{{ old('role', 'pasajero') }}">

            <!-- Selector de Rol: Soy Pasajero | Conductor -->
            <div class="reg-role-grid">
                <div class="reg-role-card {{ old('role', 'pasajero') !== 'conductor' ? 'active' : '' }}" onclick="selectRegRole(this, 'pasajero')">
                    <div style="font-size: 0.8rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 0.35rem;">
                        <i class="bi bi-person" style="color: #b45309;"></i> Soy Pasajero
                    </div>
                    <div style="font-size: 0.68rem; color: #64748b; margin-top: 0.12rem;">
                        Viajes seguros y tarifas...
                    </div>
                </div>

                <div class="reg-role-card {{ old('role') === 'conductor' ? 'active' : '' }}" onclick="selectRegRole(this, 'conductor')">
                    <div style="font-size: 0.8rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 0.35rem;">
                        <i class="bi bi-taxi-front"></i> Conductor
                    </div>
                    <div style="font-size: 0.68rem; color: #64748b; margin-top: 0.12rem;">
                        Vehículo afiliado y 0%...
                    </div>
                </div>
            </div>
            @error('role')
                <div class="invalid-feedback" style="margin-bottom: 0.75rem;">{{ $message }}</div>
            @enderror

            <!-- 1. Datos Personales -->
            <div class="reg-section-box">
                <div class="reg-section-head">
                    <div style="display: flex; align-items: center; gap: 0.45rem; font-size: 0.82rem; font-weight: 800; color: #0f172a;">
                        <span class="step-circle-black">1</span>
                        <span>Datos Personales</span>
                    </div>
                    <span style="font-size: 0.65rem; font-weight: 600; color: #64748b;">Obligatorio</span>
                </div>

                <div style="margin-bottom: 0.75rem;">
                    <label for="name" class="reg-label">Nombre Completo</label>
                    <div class="reg-input-wrap">
                        <i class="bi bi-person-vcard reg-input-icon"></i>
                        <input type="text" id="name" name="name" class="reg-input" value="{{ old('name') }}" placeholder="Ej. Carlos Andrés Cárdenas">
                    </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: grid; grid-template-columns: 110px 1fr; gap: 0.65rem; margin-bottom: 0.75rem;">
                    <div>
                        <label class="reg-label">Documento</label>
                        <select class="reg-input" style="padding-left: 0.65rem;">
                            <option>C.C.</option>
                            <option>C.E.</option>
                            <option>T.I.</option>
                        </select>
                    </div>
                    <div>
                        <label class="reg-label">Número</label>
                        <input type="text" class="reg-input" style="padding-left: 0.75rem;" placeholder="1075689XXX">
                    </div>
                </div>

                <div style="margin-bottom: 0.75rem;">
                    <label for="phone" class="reg-label">Celular (Validación SMS)</label>
                    <div style="display: grid; grid-template-columns: 72px 1fr; gap: 0.5rem;">
                        <div style="background: #e2e8f0; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 0.68rem; font-weight: 800; color: #0f172a; line-height: 1.1;">
                            <span>🇨🇴</span>
                            <span>+57</span>
                        </div>
                        <input type="text" id="phone" name="phone" class="reg-input" style="padding-left: 0.8rem;" value="{{ old('phone') }}" placeholder="310 123 4567">
                    </div>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="email" class="reg-label">Correo Electrónico</label>
                    <div class="reg-input-wrap">
                        <i class="bi bi-envelope reg-input-icon"></i>
                        <input type="email" id="email" name="email" class="reg-input" value="{{ old('email') }}" placeholder="usuario@ejemplo.com">
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- 2. Ubicación Habitual -->
            <div class="reg-section-box">
                <div class="reg-section-head" style="margin-bottom: 0.65rem;">
                    <div style="display: flex; align-items: center; gap: 0.45rem; font-size: 0.82rem; font-weight: 800; color: #0f172a;">
                        <span class="step-circle-black">2</span>
                        <span>Ubicación Habitual</span>
                    </div>
                </div>

                <label class="reg-label">Sector o Barrio en Ubaté</label>
                <div class="reg-input-wrap">
                    <i class="bi bi-geo-alt reg-input-icon"></i>
                    <select class="reg-input">
                        <option>Centro - Plaza Central</option>
                        <option>Barrio Santa Bárbara</option>
                        <option>Barrio San José</option>
                        <option>Vereda Sucunchoque</option>
                        <option>Vereda Palogordo</option>
                        <option>Vereda Soagá</option>
                    </select>
                </div>
            </div>

            <!-- 3. Credenciales de Acceso -->
            <div class="reg-section-box">
                <div class="reg-section-head" style="margin-bottom: 0.65rem;">
                    <div style="display: flex; align-items: center; gap: 0.45rem; font-size: 0.82rem; font-weight: 800; color: #0f172a;">
                        <span class="step-circle-black">3</span>
                        <span>Credenciales de Acceso</span>
                    </div>
                </div>

                <div style="margin-bottom: 0.65rem;">
                    <label for="password" class="reg-label">Contraseña</label>
                    <div class="reg-input-wrap">
                        <i class="bi bi-lock reg-input-icon"></i>
                        <input type="password" id="password" name="password" class="reg-input" placeholder="Mínimo 8 caracteres" onkeyup="checkRegStrength(this.value)">
                    </div>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.35rem; margin-top: 0.4rem;">
                        <div id="strBar1" style="height: 3px; background: #cbd5e1; border-radius: 99px;"></div>
                        <div id="strBar2" style="height: 3px; background: #cbd5e1; border-radius: 99px;"></div>
                        <div id="strBar3" style="height: 3px; background: #cbd5e1; border-radius: 99px;"></div>
                        <div id="strBar4" style="height: 3px; background: #cbd5e1; border-radius: 99px;"></div>
                    </div>
                    <div style="text-align: right; font-size: 0.62rem; color: #64748b; margin-top: 0.15rem;" id="strLabel">Insegura</div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="reg-label">Confirmar Contraseña</label>
                    <div class="reg-input-wrap">
                        <i class="bi bi-shield-check reg-input-icon"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="reg-input" placeholder="Repite la contraseña">
                    </div>
                </div>
            </div>

            <!-- Checkboxes Legales -->
            <div style="display: flex; flex-direction: column; gap: 0.55rem; margin: 0.95rem 0 1.15rem; font-size: 0.7rem; color: #475569; line-height: 1.35;">
                <label style="display: flex; align-items: flex-start; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" checked style="margin-top: 2px; accent-color: #0f172a;">
                    <span>Acepto los <u style="color: #92400e; font-weight: 600;">Términos de Servicio</u> y la Política de Tratamiento de Datos (Ley 1581 de 2012).</span>
                </label>
                <label style="display: flex; align-items: flex-start; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" checked style="margin-top: 2px; accent-color: #0f172a;">
                    <span>Declaro que los datos suministrados son fidedignos y comprobables ante la Secretaría de Tránsito y Transporte de Ubaté.</span>
                </label>
            </div>

            <button type="submit" style="width: 100%; background: #050505; color: #ffffff; border: none; border-radius: 9px; padding: 0.82rem 1rem; font-size: 0.84rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <span>Continuar y Validar por SMS (OTP)</span>
                <i class="bi bi-arrow-right"></i>
            </button>
        </form>

        <!-- Garantías Oficiales TaxiUbaté -->
        <div class="guarantees-box">
            <div style="font-size: 0.74rem; font-weight: 800; color: #92400e; display: flex; align-items: center; gap: 0.4rem; margin-bottom: 0.65rem;">
                <i class="bi bi-shield-plus"></i> Garantías Oficiales TaxiUbaté
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.7rem; color: #334155; line-height: 1.35;">
                <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                    <i class="bi bi-123" style="color: #10b981;"></i>
                    <span><strong>Código PIN Único:</strong> Validación visual antes de abordar para verificar conductor legal.</span>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                    <i class="bi bi-search" style="color: #10b981;"></i>
                    <span><strong>Recuperación de Objetos:</strong> Rastreabilidad en segundos en la central provincial.</span>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 0.5rem;">
                    <i class="bi bi-receipt" style="color: #10b981;"></i>
                    <span><strong>Comercio Local:</strong> Facturación electrónica disponible para fincas y sector lechero.</span>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin-top: 1.15rem; font-size: 0.74rem; color: #475569;">
            ¿Ya tienes una cuenta registrada?
            <a href="{{ route('login') }}" style="color: #92400e; font-weight: 800; text-decoration: none;">Inicia sesión aquí</a>
        </div>
    </div>
</div>

<script>
    function selectRegRole(card, role) {
        document.querySelectorAll('.reg-role-grid .reg-role-card').forEach(c => c.classList.remove('active'));
        card.classList.add('active');
        document.getElementById('roleInput').value = role;
    }

    function checkRegStrength(val) {
        const len = val.length;
        const bars = ['strBar1', 'strBar2', 'strBar3', 'strBar4'].map(id => document.getElementById(id));
        const label = document.getElementById('strLabel');
        bars.forEach(b => b.style.background = '#cbd5e1');
        if (len >= 2) bars[0].style.background = '#f59e0b';
        if (len >= 5) bars[1].style.background = '#f59e0b';
        if (len >= 6) {
            bars[2].style.background = '#10b981';
            label.textContent = 'Aceptable';
            label.style.color = '#047857';
        }
        if (len >= 8) {
            bars[3].style.background = '#10b981';
            label.textContent = 'Fuerte';
        }
    }
</script>
@endsection
