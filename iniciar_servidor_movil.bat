@echo off
title Servidor Movil y API - Ubate Taxi (AYD_TAXI)
echo ============================================================
echo   INICIANDO SERVIDOR API Y APP MOVIL EN RED LOCAL (WI-FI)
echo ============================================================
echo.
echo Direcciones IPv4 de tu equipo (usa la de tu Wi-Fi en el celular):
ipconfig | findstr /i "IPv4"
echo.
echo En tu celular conectado al mismo Wi-Fi, abre el navegador en:
echo   http://TU_IP_IPV4:8000/movil
echo.
echo Endpoints API JSON para clientes moviles:
echo   http://TU_IP_IPV4:8000/api/status
echo   http://TU_IP_IPV4:8000/api/login
echo   http://TU_IP_IPV4:8000/api/trips
echo ============================================================
php artisan serve --host=0.0.0.0 --port=8000
pause
