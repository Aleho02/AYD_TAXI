@extends('layouts.app')

@section('title', 'Recuperar Acceso a tu Cuenta - TaxiUbaté')

@section('content')
<style>
    .otp-card-wrap {
        width: 100%;
        max-width: 470px;
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
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.7rem 0.85rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.55rem;
        cursor: pointer;
        transition: all 0.15s;
    }

    .method-option.active {
        background: #ffffff;
        border-color: #cbd5e1;
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
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        text-align: center;
        font-family: 'Outfit', sans-serif;
        font-size: 1.2rem;
        font-weight: 800;
        color: #0f172a;
        outline: none;
    }

    .otp-digit-input:focus {
        border-color: #d97706;
        box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
    }
</style>

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
                <span style="width: 20px; height: 20px; border-radius: 50%; background: #d97706; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 0.65rem; font-weight: 800;">
                    2
                </span>
                <span style="font-size: 0.66rem; font-weight: 800; color: #92400e; line-height: 1.15;">2. Validación<br>OTP</span>
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
            Ingresa tu documento o número de celular registrado para restablecer tu clave con verificación segura de 2 factores.
        </p>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <div style="font-size: 0.62rem; font-weight: 800; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.5rem;">
                MÉTODO DE AUTENTICACIÓN
            </div>

            <!-- Opción 1: SMS -->
            <div class="method-option active" onclick="selectOtpMethod(this)">
                <div style="display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #eef2f6; display: flex; align-items: center; justify-content: center; color: #0f172a;">
                        <i class="bi bi-chat-dots"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.76rem; font-weight: 700; color: #0f172a;">
                            Mensaje de Texto SMS
                            <span style="background: #e2e8f0; color: #334155; font-size: 0.6rem; font-weight: 700; padding: 0.1rem 0.4rem; border-radius: 4px; margin-left: 0.25rem;">Recomendado</span>
                        </div>
                        <div style="font-size: 0.7rem; color: #64748b;">+57 310 ••• ••42</div>
                    </div>
                </div>
                <input type="radio" name="auth_method" checked style="accent-color: #92400e; width: 16px; height: 16px;">
            </div>

            <!-- Opción 2: WhatsApp -->
            <div class="method-option" onclick="selectOtpMethod(this)">
                <div style="display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #eef2f6; display: flex; align-items: center; justify-content: center; color: #047857;">
                        <i class="bi bi-whatsapp"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.76rem; font-weight: 700; color: #0f172a;">
                            WhatsApp Oficial TaxiUbaté
                            <span style="background: #bbf7d0; color: #065f46; font-size: 0.6rem; font-weight: 700; padding: 0.1rem 0.4rem; border-radius: 4px; margin-left: 0.25rem;">Inmediato</span>
                        </div>
                        <div style="font-size: 0.7rem; color: #64748b;">+57 310 ••• ••42</div>
                    </div>
                </div>
                <input type="radio" name="auth_method" style="accent-color: #92400e; width: 16px; height: 16px;">
            </div>

            <!-- Opción 3: Correo -->
            <div class="method-option" onclick="selectOtpMethod(this)">
                <div style="display: flex; align-items: center; gap: 0.65rem;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #eef2f6; display: flex; align-items: center; justify-content: center; color: #334155;">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.76rem; font-weight: 700; color: #0f172a;">Correo Electrónico Verificado</div>
                        <div style="font-size: 0.7rem; color: #64748b;">m••••••@gmail.com</div>
                    </div>
                </div>
                <input type="radio" name="auth_method" style="accent-color: #92400e; width: 16px; height: 16px;">
            </div>

            <!-- Código OTP de 6 dígitos -->
            <div class="otp-section-box">
                <div style="font-size: 0.82rem; font-weight: 800; color: #0f172a; display: flex; align-items: center; gap: 0.4rem;">
                    <i class="bi bi-123" style="color: #b45309;"></i> Ingresa el código OTP de 6 dígitos
                </div>
                <div style="font-size: 0.7rem; color: #475569; margin-top: 0.15rem;">
                    Hemos enviado un código numérico a tu número <strong>+57 310 ••• ••42</strong>
                </div>

                <div class="otp-boxes-grid">
                    <input type="text" maxlength="1" class="otp-digit-input" value="5">
                    <input type="text" maxlength="1" class="otp-digit-input" value="8">
                    <input type="text" maxlength="1" class="otp-digit-input" value="2">
                    <input type="text" maxlength="1" class="otp-digit-input" value="1">
                    <input type="text" maxlength="1" class="otp-digit-input" value="•" style="color: #f97316;">
                    <input type="text" maxlength="1" class="otp-digit-input" value="•" style="color: #cbd5e1;">
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.68rem;">
                    <span style="color: #475569; font-weight: 600;">
                        <i class="bi bi-stopwatch"></i> Reenviar código en <strong>00:42s</strong>
                    </span>
                    <span style="color: #92400e; font-weight: 700; cursor: pointer;">
                        <i class="bi bi-telephone"></i> Llamarme con dictado por voz
                    </span>
                </div>
            </div>

            <!-- Crear Nueva Credencial -->
            <div style="background: #f4f7fb; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1rem 1.15rem; margin-bottom: 1.15rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.55rem;">
                    <span style="font-size: 0.64rem; font-weight: 800; color: #0f172a; text-transform: uppercase;">CREAR NUEVA CREDENCIAL</span>
                    <span style="background: #e2e8f0; color: #334155; font-size: 0.6rem; font-weight: 700; padding: 0.12rem 0.45rem; border-radius: 4px;">Paso final</span>
                </div>

                <label for="new_password" style="display: block; font-size: 0.7rem; font-weight: 700; color: #334155; margin-bottom: 0.3rem;">Nueva Contraseña</label>
                <div style="position: relative; margin-bottom: 0.55rem;">
                    <input type="password" id="new_password" name="password" value="TaxiUbate2025*" style="width: 100%; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 0.6rem 2.25rem 0.6rem 0.85rem; font-size: 0.85rem; color: #0f172a; outline: none;" required>
                    <button type="button" onclick="const p=document.getElementById('new_password'); p.type=p.type==='password'?'text':'password';" style="position: absolute; right: 0.65rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; cursor: pointer;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 0.66rem; font-weight: 700; margin-bottom: 0.25rem;">
                    <span style="color: #475569;">Nivel de seguridad:</span>
                    <span style="color: #047857;">Fuerte (85%)</span>
                </div>
                <div style="height: 4px; background: #e2e8f0; border-radius: 99px; overflow: hidden; margin-bottom: 0.6rem;">
                    <div style="width: 85%; height: 100%; background: #10b981;"></div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 0.22rem; font-size: 0.68rem; color: #047857; font-weight: 600;">
                    <span><i class="bi bi-check-circle"></i> Mínimo 8 caracteres</span>
                    <span><i class="bi bi-check-circle"></i> Al menos una mayúscula</span>
                    <span><i class="bi bi-check-circle"></i> Al menos un número o símbolo</span>
                </div>
            </div>

            <button type="submit" style="width: 100%; background: #050505; color: #ffffff; border: none; border-radius: 9px; padding: 0.82rem 1rem; font-size: 0.84rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <i class="bi bi-arrow-counterclockwise"></i> Verificar Código y Restablecer Contraseña
            </button>
        </form>

        <!-- Caja de Ayuda Cooperativa -->
        <div style="background: #eef3f9; border-radius: 10px; padding: 0.85rem; margin-top: 1.1rem; font-size: 0.68rem; color: #334155; line-height: 1.4;">
            <div style="font-weight: 700; color: #0f172a; margin-bottom: 0.2rem;">
                <i class="bi bi-headset" style="color: #b45309;"></i> ¿Cambiaste de número de teléfono o extraviaste tu móvil?
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
    function selectOtpMethod(el) {
        document.querySelectorAll('.method-option').forEach(m => m.classList.remove('active'));
        el.classList.add('active');
        const radio = el.querySelector('input[type="radio"]');
        if (radio) radio.checked = true;
    }
</script>
@endsection
