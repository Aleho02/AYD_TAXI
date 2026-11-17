@extends('layouts.app')

@section('title', 'Recuperar Acceso a tu Cuenta - TaxiUbaté')

@section('content')
<style>
    .otp-card-wrap {
        width: 100%;
        max-width: 475px;
        margin: 0 auto;
    }

    .otp-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.85rem 1.95rem;
        box-shadow: 0 10px 30px -5px rgba(15, 23, 42, 0.06);
    }

    .stepper-bar {
        background: #f1f5f9;
        border-radius: 10px;
        padding: 0.65rem 0.9rem;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        margin-bottom: 1.35rem;
        align-items: center;
    }

    .method-option {
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        padding: 0.75rem 0.85rem;
        margin-bottom: 0.75rem;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
    }

    .otp-section-box {
        background: #eef3f9;
        border: 1px solid #dbe4f0;
        border-radius: 12px;
        padding: 1.05rem 1.15rem;
        margin: 1rem 0;
    }

    .otp-boxes-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 0.45rem;
        margin: 0.85rem 0;
    }

    .otp-digit-input {
        width: 100%;
        height: 48px;
        background: #ffffff;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        text-align: center;
        font-family: 'Outfit', sans-serif;
        font-size: 1.25rem;
        font-weight: 800;
        color: #0f172a;
        outline: none;
    }

    .otp-digit-input:focus {
        border-color: #d97706;
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
    }
</style>

@php
    $activeEmail = session('otp_email', old('email', ''));
@endphp

<div class="otp-card-wrap">
    <div class="otp-card">
        <!-- Cabecera Superior (Imagen 6) -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.15rem;">
            <div style="display: flex; align-items: center; gap: 0.65rem;">
                <a href="{{ route('inicio') }}" style="width: 36px; height: 36px; border-radius: 8px; background: #0f172a; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.05rem; text-decoration: none;">
                    <i class="bi bi-taxi-front-fill"></i>
                </a>
                <div>
                    <div style="font-family: 'Outfit', sans-serif; font-size: 1.05rem; font-weight: 800; color: #0f172a; line-height: 1.1;">
                        TaxiUbaté
                    </div>
                    <div style="font-size: 0.56rem; font-weight: 800; color: #64748b; letter-spacing: 0.5px;">
                        SISTEMA CENTRAL DE DESPACHO
                    </div>
                </div>
            </div>

            <span style="background: #eef6ff; color: #047857; border: 1px solid #bfdbfe; font-size: 0.65rem; font-weight: 700; padding: 0.24rem 0.65rem; border-radius: 99px;">
                <i class="bi bi-shield-check"></i> Canal Seguro SSL
            </span>
        </div>

        <!-- Stepper 1 - 2 - 3 -->
        <div class="stepper-bar">
            <div style="display: flex; align-items: center; gap: 0.4rem;">
                <span style="width: 20px; height: 20px; border-radius: 50%; background: #0f172a; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 0.65rem;">
                    <i class="bi bi-check"></i>
                </span>
                <span style="font-size: 0.66rem; font-weight: 700; color: #0f172a; line-height: 1.15;">1.<br>Identificación</span>
            </div>

            <div style="display: flex; align-items: center; gap: 0.4rem;">
                <span style="width: 20px; height: 20px; border-radius: 50%; background: {{ $activeEmail ? '#10b981' : '#d97706' }}; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 800;">
                    2
                </span>
                <span style="font-size: 0.66rem; font-weight: 800; color: #92400e; line-height: 1.15;">2. Validación<br>OTP Correo</span>
            </div>

            <div style="display: flex; align-items: center; gap: 0.4rem;">
                <span style="width: 20px; height: 20px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: inline-flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 700;">
                    3
                </span>
                <span style="font-size: 0.66rem; font-weight: 600; color: #64748b; line-height: 1.15;">3. Nueva<br>Clave</span>
            </div>
        </div>

        <h1 style="font-family: 'Outfit', sans-serif; font-size: 1.38rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">
            Recuperar Acceso a tu Cuenta
        </h1>
        <p style="font-size: 0.76rem; color: #64748b; line-height: 1.4; margin-bottom: 1rem;">
            Ingresa el correo electrónico válido con el que te registraste en <strong>AYD TAXI</strong> para recibir tu código de verificación de 6 dígitos.
        </p>

        <!-- PASO 1: FORMULARIO PARA ENVIAR EL CÓDIGO OTP AL CORREO REGISTRADO -->
        <form action="{{ route('password.send.code') }}" method="POST" style="margin-bottom: 0.85rem;">
            @csrf

            <div style="font-size: 0.62rem; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.45rem;">
                1. CORREO ELECTRÓNICO REGISTRADO EN AYD TAXI
            </div>

            <div class="method-option">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                    <div style="display: flex; align-items: center; gap: 0.55rem;">
                        <div style="width: 30px; height: 30px; border-radius: 8px; background: #eef2f6; display: flex; align-items: center; justify-content: center; color: #0f172a;">
                            <i class="bi bi-envelope-check-fill" style="color: #d97706;"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.76rem; font-weight: 700; color: #0f172a;">
                                Correo Electrónico Verificado
                                <span style="background: #dcfce7; color: #065f46; font-size: 0.6rem; font-weight: 700; padding: 0.1rem 0.4rem; border-radius: 4px; margin-left: 0.25rem;">Oficial SMTP</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 0.5rem;">
                    <input type="email" id="senderEmailInput" name="email" value="{{ $activeEmail }}" placeholder="ejemplo@gmail.com" oninput="document.getElementById('resetEmailHidden').value = this.value" style="flex: 1; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 0.58rem 0.75rem; font-size: 0.82rem; color: #0f172a; outline: none;" required>
                    <button type="submit" style="background: #0f172a; color: #ffffff; border: none; border-radius: 8px; padding: 0.58rem 0.85rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; white-space: nowrap;">
                        <i class="bi bi-send-fill" style="color: #fbbf24;"></i> Enviar Código
                    </button>
                </div>

                @error('email')
                    <div class="invalid-feedback" style="display: block; margin-top: 0.35rem;">{{ $message }}</div>
                @enderror
            </div>
        </form>

        <!-- PASO 2 Y 3: FORMULARIO PARA VERIFICAR EL CÓDIGO OTP Y GUARDAR LA NUEVA CONTRASEÑA -->
        <form action="{{ route('password.update') }}" method="POST" id="resetPasswordForm" onsubmit="syncOtpBeforeSubmit()">
            @csrf
            <input type="hidden" name="email" id="resetEmailHidden" value="{{ $activeEmail }}">
            <input type="hidden" name="otp_code" id="otpCodeHidden" value="{{ old('otp_code') }}">

            <!-- Código OTP de 6 dígitos -->
            <div class="otp-section-box">
                <div style="font-size: 0.82rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 0.4rem;">
                    <i class="bi bi-123" style="color: #b45309;"></i> 2. Ingresa el código OTP de 6 dígitos
                </div>
                <div style="font-size: 0.7rem; color: #475569; margin-top: 0.15rem;">
                    @if($activeEmail)
                        Hemos enviado el código numérico a tu correo <strong>{{ $activeEmail }}</strong>
                    @else
                        Solicita el código arriba y escribe aquí los 6 dígitos que lleguen a tu correo.
                    @endif
                </div>

                <div class="otp-boxes-grid">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit-input" id="otp1" oninput="handleOtpDigit(this, 'otp2')" onpaste="handleOtpPaste(event)">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit-input" id="otp2" oninput="handleOtpDigit(this, 'otp3')">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit-input" id="otp3" oninput="handleOtpDigit(this, 'otp4')">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit-input" id="otp4" oninput="handleOtpDigit(this, 'otp5')">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit-input" id="otp5" oninput="handleOtpDigit(this, 'otp6')">
                    <input type="text" maxlength="1" inputmode="numeric" class="otp-digit-input" id="otp6" oninput="handleOtpDigit(this, null)">
                </div>

                @error('otp_code')
                    <div class="invalid-feedback" style="display: block; margin-bottom: 0.4rem;">{{ $message }}</div>
                @enderror

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.68rem;">
                    <span style="color: #475569; font-weight: 600;">
                        <i class="bi bi-stopwatch"></i> Validez del código: <strong>15 minutos</strong>
                    </span>
                    <span style="color: #92400e; font-weight: 700;">
                        Puedes pegar los 6 dígitos directamente
                    </span>
                </div>
            </div>

            <!-- Crear Nueva Credencial -->
            <div style="background: #f4f7fb; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem 1.15rem; margin-bottom: 1.15rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.55rem;">
                    <span style="font-size: 0.64rem; font-weight: 800; color: #0f172a; text-transform: uppercase;">3. CREAR NUEVA CREDENCIAL</span>
                    <span style="background: #e2e8f0; color: #334155; font-size: 0.6rem; font-weight: 700; padding: 0.12rem 0.45rem; border-radius: 4px;">Paso final</span>
                </div>

                <label for="new_password" style="display: block; font-size: 0.7rem; font-weight: 700; color: #334155; margin-bottom: 0.3rem;">Nueva Contraseña *</label>
                <div style="position: relative; margin-bottom: 0.55rem;">
                    <input type="password" id="new_password" name="password" placeholder="Mínimo 6 caracteres" oninput="checkResetStrength(this.value)" style="width: 100%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 0.6rem 2.25rem 0.6rem 0.85rem; font-size: 0.85rem; color: #0f172a; outline: none;" required>
                    <button type="button" onclick="const p=document.getElementById('new_password'); p.type=p.type==='password'?'text':'password';" style="position: absolute; right: 0.65rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; cursor: pointer;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                <label for="password_confirmation" style="display: block; font-size: 0.7rem; font-weight: 700; color: #334155; margin-bottom: 0.3rem;">Confirmar Nueva Contraseña *</label>
                <div style="position: relative; margin-bottom: 0.65rem;">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite tu nueva contraseña" style="width: 100%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 0.6rem 0.85rem; font-size: 0.85rem; color: #0f172a; outline: none;" required>
                </div>

                @error('password')
                    <div class="invalid-feedback" style="display: block; margin-bottom: 0.5rem;">{{ $message }}</div>
                @enderror

                <div style="display: flex; justify-content: space-between; font-size: 0.66rem; font-weight: 700; margin-bottom: 0.25rem;">
                    <span style="color: #475569;">Nivel de seguridad:</span>
                    <span id="resetStrText" style="color: #047857;">Listo para actualizar</span>
                </div>
                <div style="height: 4px; background: #e2e8f0; border-radius: 99px; overflow: hidden; margin-bottom: 0.6rem;">
                    <div id="resetStrBar" style="width: 85%; height: 100%; background: #10b981; transition: width 0.2s;"></div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.22rem; font-size: 0.68rem; color: #047857; font-weight: 600;">
                    <span><i class="bi bi-check-circle"></i> Mínimo 6 caracteres</span>
                    <span><i class="bi bi-check-circle"></i> Cifrado seguro Bcrypt en base de datos</span>
                </div>
            </div>

            <button type="submit" style="width: 100%; background: #050505; color: #ffffff; border: none; border-radius: 9px; padding: 0.82rem 1rem; font-size: 0.84rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <i class="bi bi-arrow-counterclockwise"></i> Verificar Código y Restablecer Contraseña
            </button>
        </form>

        <!-- Caja de Ayuda Cooperativa -->
        <div style="background: #eef3f9; border-radius: 10px; padding: 0.85rem; margin-top: 1.1rem; font-size: 0.68rem; color: #334155; line-height: 1.4;">
            <div style="font-weight: 700; color: #0f172a; margin-bottom: 0.2rem;">
                <i class="bi bi-headset" style="color: #b45309;"></i> ¿Cambiaste de correo o tienes inconvenientes?
            </div>
            Si eres conductor acércate a la oficina de tu cooperativa (<strong>Cootransubaté / TaxUbaté</strong>) con tu documento original o comunícate con la Central de Despacho 24/7 al <strong>(601) 855-3000</strong>.
        </div>

        <div style="text-align: center; margin-top: 1.15rem;">
            <a href="{{ route('login') }}" style="font-size: 0.76rem; font-weight: 700; color: #0f172a; text-decoration: none;">
                <i class="bi bi-arrow-left"></i> Regresar al Inicio de Sesión
            </a>
        </div>
    </div>
</div>

<script>
    function handleOtpDigit(input, nextId) {
        input.value = input.value.replace(/[^0-9]/g, '');
        syncOtpBeforeSubmit();
        if (input.value.length === 1 && nextId) {
            document.getElementById(nextId).focus();
        }
    }

    function handleOtpPaste(e) {
        const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '').slice(0, 6);
        if (pasted.length > 0) {
            e.preventDefault();
            for (let i = 0; i < 6; i++) {
                const box = document.getElementById('otp' + (i + 1));
                if (box) box.value = pasted[i] || '';
            }
            syncOtpBeforeSubmit();
        }
    }

    function syncOtpBeforeSubmit() {
        let code = '';
        for (let i = 1; i <= 6; i++) {
            const box = document.getElementById('otp' + i);
            if (box) code += box.value.trim();
        }
        document.getElementById('otpCodeHidden').value = code;
        const senderEmail = document.getElementById('senderEmailInput');
        if (senderEmail && senderEmail.value) {
            document.getElementById('resetEmailHidden').value = senderEmail.value;
        }
    }

    function checkResetStrength(val) {
        const bar = document.getElementById('resetStrBar');
        const txt = document.getElementById('resetStrText');
        if (val.length < 6) {
            bar.style.width = '30%';
            bar.style.background = '#f59e0b';
            txt.textContent = 'Mínimo 6 caracteres';
            txt.style.color = '#b45309';
        } else {
            bar.style.width = '100%';
            bar.style.background = '#10b981';
            txt.textContent = 'Fuerte (100%)';
            txt.style.color = '#047857';
        }
    }
</script>
@endsection
