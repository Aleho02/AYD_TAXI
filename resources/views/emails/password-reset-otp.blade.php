<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperación de Contraseña - TaxiUbaté</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f6f9; font-family: 'Segoe UI', Arial, sans-serif; color: #0f172a;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f6f9; padding: 32px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 520px; background-color: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);">
                    <!-- Header -->
                    <tr>
                        <td style="background-color: #0f172a; padding: 22px 28px; color: #ffffff;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <span style="display: inline-block; background-color: #f59e0b; color: #0f172a; font-weight: 800; font-size: 13px; padding: 4px 10px; border-radius: 6px; margin-bottom: 6px;">
                                            TAXIUBATÉ • AYD TAXI
                                        </span>
                                        <div style="font-size: 19px; font-weight: 800; color: #ffffff;">
                                            Sistema Central de Despacho
                                        </div>
                                        <div style="font-size: 12px; color: #94a3b8; margin-top: 2px;">
                                            Valle de Ubaté, Cundinamarca • Canal Seguro SSL
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 28px;">
                            <p style="margin: 0 0 12px; font-size: 16px; font-weight: 700; color: #0f172a;">
                                Hola, {{ $user->name }}:
                            </p>
                            <p style="margin: 0 0 20px; font-size: 14px; line-height: 1.55; color: #475569;">
                                Recibimos una solicitud para restablecer la contraseña de tu cuenta registrada con el correo <strong>{{ $user->email }}</strong> en la plataforma oficial <strong>TaxiUbaté (AYD TAXI)</strong>.
                            </p>

                            <div style="background-color: #eef3f9; border: 1px solid #cbd5e1; border-radius: 12px; padding: 20px; text-align: center; margin-bottom: 22px;">
                                <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; color: #475569; margin-bottom: 10px;">
                                    TU CÓDIGO OTP DE 6 DÍGITOS ES:
                                </div>
                                <div style="font-size: 32px; font-weight: 800; letter-spacing: 10px; color: #0f172a; background: #ffffff; display: inline-block; padding: 12px 24px; border-radius: 10px; border: 2px solid #f59e0b;">
                                    {{ $otpCode }}
                                </div>
                                <div style="font-size: 12px; color: #b45309; font-weight: 600; margin-top: 10px;">
                                    ⏱ Este código es válido por 15 minutos.
                                </div>
                            </div>

                            <p style="margin: 0 0 16px; font-size: 13px; line-height: 1.5; color: #64748b;">
                                Ingresa estos 6 dígitos en la pantalla de <strong>Recuperar Acceso a tu Cuenta</strong> y escribe tu nueva contraseña para completar el cambio.
                            </p>

                            <div style="background-color: #f8fafc; border-left: 4px solid #0f172a; padding: 12px 14px; font-size: 12px; color: #475569; line-height: 1.45;">
                                <strong>¿No solicitaste este cambio?</strong> Si no fuiste tú, puedes ignorar este correo de forma segura; tu contraseña actual seguirá protegida.
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 28px; text-align: center; font-size: 11px; color: #64748b;">
                            TaxiUbaté — Sistema de Información Geoespacial Distribuido para Taxis en Valle de Ubaté.<br>
                            Central de Despacho 24/7 • Todos los derechos reservados.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
