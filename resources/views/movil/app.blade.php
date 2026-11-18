<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta name="theme-color" content="#0f172a">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Ubaté Taxi">
    <link rel="manifest" href="/manifest.json">
    <title>Ubaté Taxi — App Móvil Oficial</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">
    <!-- Leaflet Maps CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha384-sHL9NAb7lN7rfvG5lfHpm643Xkcjzp4jFvuavGOndn6pjVqS6ny56CAt3nsEVT4H" crossorigin="anonymous" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha384-cxOPjt7s7Iz04uaHJceBmS+qpjv2JkIHNVcuOrM+YHwZOmJGBXI00mdUXEq65HTH" crossorigin="anonymous"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #0f172a;
            color: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1, h2, h3, h4, .outfit {
            font-family: 'Outfit', sans-serif;
        }

        /* Contenedor Móvil (En celular ocupa 100% de la pantalla; en PC se ve como un teléfono centrado) */
        .mobile-shell {
            width: 100%;
            max-width: 430px;
            min-height: 100vh;
            background-color: #f4f6f9;
            display: flex;
            flex-direction: column;
            position: relative;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
            overflow-x: hidden;
        }

        @media (min-width: 640px) {
            body {
                padding: 1.25rem;
            }
            .mobile-shell {
                min-height: 860px;
                max-height: 92vh;
                border-radius: 34px;
                border: 6px solid #1e293b;
                overflow-y: auto;
            }
        }

        /* Top App Bar */
        .mob-topbar {
            background: #ffffff;
            padding: 0.7rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .mob-brand {
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        .mob-logo {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: #0f172a;
            color: #f59e0b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
        }

        .gps-active-pill {
            background: #86efac;
            color: #064e3b;
            font-size: 0.68rem;
            font-weight: 800;
            padding: 0.22rem 0.6rem;
            border-radius: 99px;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .mob-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #0f172a;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
            border: 2px solid #e2e8f0;
        }

        /* Contenido de Pestañas */
        .mob-tab-pane {
            display: none;
            flex: 1;
            padding-bottom: 84px;
        }

        .mob-tab-pane.active {
            display: block;
        }

        /* Tarjetas Móviles */
        .mob-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1rem 1.1rem;
            margin: 0.75rem 0.85rem;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
            border: 1px solid #eef2f6;
        }

        /* Opciones de Servicio (Imagen 1) */
        .service-option-card {
            background: #ffffff;
            border: 1.5px solid #eef2f6;
            border-radius: 16px;
            padding: 0.85rem 0.95rem;
            margin-bottom: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.15s;
        }

        .service-option-card.selected {
            border-color: #f59e0b;
            background: #fffdf9;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.1);
        }

        .srv-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #f1f5f9;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .service-option-card.selected .srv-icon {
            background: #f59e0b;
            color: #0f172a;
        }

        /* Métodos de Pago Grid */
        .pay-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.45rem;
            margin-top: 0.55rem;
        }

        .pay-item {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.55rem 0.25rem;
            text-align: center;
            font-size: 0.7rem;
            font-weight: 700;
            color: #334155;
            cursor: pointer;
        }

        .pay-item.selected {
            background: #fffbeb;
            border-color: #fde68a;
            color: #0f172a;
        }

        /* Botón Principal Dorado */
        .btn-gold-cta {
            width: calc(100% - 1.7rem);
            margin: 0.5rem 0.85rem;
            background: linear-gradient(135deg, #f59e0b, #ea580c);
            color: #0f172a;
            border: none;
            border-radius: 14px;
            padding: 0.95rem 1.15rem;
            font-family: 'Outfit', sans-serif;
            font-size: 1rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(234, 88, 12, 0.28);
        }

        /* Placa Colombiana Amarilla (Imagen 3) */
        .col-plate-box {
            background: #f59e0b;
            color: #0f172a;
            border-radius: 12px;
            padding: 0.4rem 0.75rem;
            text-align: center;
            border: 2px solid #d97706;
            line-height: 1.1;
        }

        /* Bottom Navigation Bar (4 Pestañas) */
        .mob-bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            max-width: 430px;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            padding: 0.45rem 0.25rem 0.6rem;
            z-index: 60;
        }

        @media (min-width: 640px) {
            .mob-bottom-nav {
                position: sticky;
                bottom: 0;
                max-width: 100%;
            }
        }

        .mob-nav-item {
            border: none;
            background: transparent;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.2rem;
            color: #64748b;
            font-size: 0.68rem;
            font-weight: 700;
            cursor: pointer;
            padding: 0.25rem 0;
        }

        .mob-nav-item i {
            font-size: 1.15rem;
        }

        .mob-nav-item.active {
            color: #b45309;
        }
    </style>
</head>
<body>

<div class="mobile-shell">
    <!-- TOPBAR MÓVIL COMÚN A LAS 4 PANTALLAS -->
    <header class="mob-topbar">
        <div class="mob-brand">
            <div class="mob-logo">
                <i class="bi bi-taxi-front-fill"></i>
            </div>
            <div>
                <div class="outfit" style="font-size: 0.98rem; font-weight: 800; color: #0f172a; line-height: 1.1;">
                    Ubaté Taxi
                </div>
                <div id="mobTopSubtitle" style="font-size: 0.7rem; color: #64748b; font-weight: 500;">
                    Pedir
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <span class="gps-active-pill">
                <span style="width: 6px; height: 6px; border-radius: 50%; background: #047857;"></span>
                GPS Activo
            </span>

            <a href="{{ $user->isAdmin() ? route('admin.dashboard') : ($user->isConductor() ? route('conductor.dashboard') : route('pasajero.dashboard')) }}" class="mob-avatar" title="Ir al Panel Web Completo" style="text-decoration: none;">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </a>
        </div>
    </header>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; margin: 0.6rem 0.85rem 0; padding: 0.65rem 0.85rem; border-radius: 12px; font-size: 0.76rem; font-weight: 600; display: flex; align-items: center; gap: 0.45rem;">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- =========================================================================
         PESTAÑA 1: PEDIR TAXI (IMAGEN 1)
         ========================================================================= -->
    <div id="tab-pedir" class="mob-tab-pane {{ $defaultTab === 'pedir' ? 'active' : '' }}">
        <!-- Mapa Superior Interactivo Leaflet con GPS -->
        <div style="position: relative; height: 235px; border-bottom: 1px solid #e2e8f0; overflow: hidden; background: #e2e8f0;">
            <div id="mobLeafletMap" style="width: 100%; height: 100%; z-index: 1;"></div>

            <!-- Píldora Taxis Activos en BD -->
            <div style="position: absolute; top: 10px; left: 10px; background: rgba(255,255,255,0.95); padding: 0.3rem 0.65rem; border-radius: 99px; font-size: 0.72rem; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 0.35rem; z-index: 1000;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #047857;"></span>
                <span>{{ $availableDrivers->count() }} taxis activos</span>
            </div>

            <!-- Botón Centrar GPS -->
            <button type="button" id="btnMobGps" onclick="useMobGPS()" style="position: absolute; top: 10px; right: 10px; width: 38px; height: 38px; border-radius: 10px; background: #ffffff; border: 1px solid #cbd5e1; box-shadow: 0 2px 8px rgba(0,0,0,0.18); cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; color: #047857; z-index: 1000;" title="Obtener mi GPS">
                <i class="bi bi-crosshair"></i>
            </button>

            <!-- Accesos Rápidos en la Base del Mapa -->
            <div style="position: absolute; bottom: 8px; left: 8px; right: 8px; display: flex; gap: 0.35rem; overflow-x: auto; z-index: 1000; padding-bottom: 2px;">
                <button type="button" onclick="setMobRoute('Plaza de Mercado San José', 5.3095, -73.8130, 2.1, 6500)" style="background: rgba(255,255,255,0.95); border: 1px solid #cbd5e1; border-radius: 99px; padding: 0.25rem 0.6rem; font-size: 0.66rem; font-weight: 700; white-space: nowrap; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    🏪 Plaza de Mercado
                </button>
                <button type="button" onclick="setMobRoute('Vereda Sucunchoque - El Molino', 5.3280, -73.8350, 4.2, 12000)" style="background: rgba(255,255,255,0.95); border: 1px solid #cbd5e1; border-radius: 99px; padding: 0.25rem 0.6rem; font-size: 0.66rem; font-weight: 700; white-space: nowrap; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    ⛰️ Sucunchoque
                </button>
                <button type="button" onclick="setMobRoute('Terminal de Transportes Ubaté', 5.3050, -73.8190, 1.8, 6500)" style="background: rgba(255,255,255,0.95); border: 1px solid #cbd5e1; border-radius: 99px; padding: 0.25rem 0.6rem; font-size: 0.66rem; font-weight: 700; white-space: nowrap; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    🏢 Terminal Ubaté
                </button>
            </div>
        </div>

        <div id="mobGpsToast" style="display: none; margin: 0.45rem 0.95rem 0; padding: 0.4rem 0.75rem; border-radius: 8px; font-size: 0.72rem; font-weight: 600;"></div>

        <!-- FORMULARIO REAL DE SOLICITUD DESDE CELULAR -->
        <form action="{{ route('movil.trips.store') }}" method="POST" id="mobRequestForm">
            @csrf
            <input type="hidden" name="origin_latitude" id="mob_origin_lat" value="5.3080000">
            <input type="hidden" name="origin_longitude" id="mob_origin_lng" value="-73.8150000">
            <input type="hidden" name="destination_latitude" id="mob_dest_lat" value="5.3165000">
            <input type="hidden" name="destination_longitude" id="mob_dest_lng" value="-73.8210000">
            <input type="hidden" name="distance_km" id="mobDistanceInput" value="2.4">
            <input type="hidden" name="estimated_fare" id="mobFareInput" value="6500">

            <!-- Tarjeta Origen y Destino -->
            <div class="mob-card" style="margin-top: 0.65rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.65rem; border-bottom: 1px solid #f1f5f9;">
                    <div style="display: flex; align-items: center; gap: 0.65rem; flex: 1;">
                        <span style="width: 10px; height: 10px; border-radius: 50%; background: #047857; flex-shrink: 0;"></span>
                        <div style="flex: 1;">
                            <div style="font-size: 0.65rem; color: #64748b; font-weight: 600;">Punto de Recogida</div>
                            <input type="text" name="origin_address" id="mobOriginInput" value="Parque Principal (Cl. 9 # 6-30)" style="width: 100%; border: none; outline: none; font-size: 0.85rem; font-weight: 700; color: #0f172a; background: transparent;" required>
                        </div>
                    </div>
                    <i class="bi bi-crosshair" style="color: #64748b;"></i>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.65rem;">
                    <div style="display: flex; align-items: center; gap: 0.65rem; flex: 1;">
                        <span style="width: 12px; height: 12px; border-radius: 4px; background: #f59e0b; flex-shrink: 0;"></span>
                        <div style="flex: 1;">
                            <div style="font-size: 0.65rem; color: #64748b; font-weight: 600;">Destino</div>
                            <input type="text" name="destination_address" id="mobDestInput" value="Hospital El Salvador (Cra. 5 # 12-40)" style="width: 100%; border: none; outline: none; font-size: 0.85rem; font-weight: 700; color: #0f172a; background: transparent;" required>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('mobDestInput').value=''; document.getElementById('mobDestInput').focus();" style="background: none; border: none; color: #64748b; cursor: pointer;">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>

            <!-- Franja de Distancia, Tiempo y Tarifa Legal -->
            <div class="mob-card" style="padding: 0.75rem 1rem; display: grid; grid-template-columns: repeat(3, 1fr); text-align: center; background: #f8fafc;">
                <div style="border-right: 1px solid #e2e8f0;">
                    <div style="font-size: 0.65rem; color: #64748b; font-weight: 600;"><i class="bi bi-signpost-split" style="color: #b45309;"></i> Distancia</div>
                    <div id="mobDistDisplay" class="outfit" style="font-size: 1.05rem; font-weight: 800; color: #0f172a; margin-top: 2px;">2.4 km</div>
                </div>
                <div style="border-right: 1px solid #e2e8f0;">
                    <div style="font-size: 0.65rem; color: #64748b; font-weight: 600;"><i class="bi bi-clock" style="color: #047857;"></i> Tiempo Est.</div>
                    <div id="mobTimeDisplay" class="outfit" style="font-size: 1.05rem; font-weight: 800; color: #047857; margin-top: 2px;">~7 min</div>
                </div>
                <div>
                    <div style="font-size: 0.65rem; color: #64748b; font-weight: 600;"><i class="bi bi-patch-check"></i> Tarifa Legal</div>
                    <div style="font-size: 0.75rem; font-weight: 700; color: #0f172a; margin-top: 4px;">Sin recargos</div>
                </div>
            </div>

            <!-- Selecciona el Servicio -->
            <div style="padding: 0.25rem 0.95rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.55rem;">
                    <strong style="font-size: 0.8rem; color: #0f172a;">Selecciona el Servicio</strong>
                    <span style="font-size: 0.68rem; font-weight: 700; color: #047857;">
                        <i class="bi bi-shield-check"></i> Flota Ubaté Certificada
                    </span>
                </div>

                <!-- Opción 1: Taxi Urbano -->
                <div class="service-option-card selected" onclick="selectMobService(this, 2.4, 6500)">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div class="srv-icon"><i class="bi bi-taxi-front-fill"></i></div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                <strong style="font-size: 0.9rem; color: #0f172a;">Taxi Urbano</strong>
                                <span style="background: #eff6ff; color: #1d4ed8; font-size: 0.62rem; font-weight: 700; padding: 0.1rem 0.4rem; border-radius: 4px;">4 cupos</span>
                            </div>
                            <div style="font-size: 0.7rem; color: #64748b; margin-top: 2px;">Centro, barrios y perímetro urbano</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div class="outfit" style="font-size: 1.1rem; font-weight: 800; color: #0f172a;">$6.500</div>
                        <div style="font-size: 0.64rem; font-weight: 700; color: #047857;">Tarifa fija</div>
                    </div>
                </div>

                <!-- Opción 2: Campero / Veredal -->
                <div class="service-option-card" onclick="selectMobService(this, 4.8, 12000)">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div class="srv-icon"><i class="bi bi-signpost-2"></i></div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                <strong style="font-size: 0.9rem; color: #0f172a;">Campero / Veredal</strong>
                                <span style="background: #86efac; color: #064e3b; font-size: 0.62rem; font-weight: 800; padding: 0.1rem 0.4rem; border-radius: 4px;">4x4</span>
                            </div>
                            <div style="font-size: 0.7rem; color: #64748b; margin-top: 2px;">Sucunchoque, Volcán, Tausa, Fincas</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div class="outfit" style="font-size: 1.1rem; font-weight: 800; color: #0f172a;">$12.000</div>
                        <div style="font-size: 0.64rem; color: #64748b;">Estimado zona</div>
                    </div>
                </div>

                <!-- Opción 3: Encomienda Express -->
                <div class="service-option-card" onclick="selectMobService(this, 2.8, 7000)">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <div class="srv-icon"><i class="bi bi-box-seam"></i></div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                <strong style="font-size: 0.9rem; color: #0f172a;">Encomienda Express</strong>
                                <span style="background: #eff6ff; color: #1d4ed8; font-size: 0.62rem; font-weight: 700; padding: 0.1rem 0.4rem; border-radius: 4px;">Entrega</span>
                            </div>
                            <div style="font-size: 0.7rem; color: #64748b; margin-top: 2px;">Lácteos, paquetes y documentos</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div class="outfit" style="font-size: 1.1rem; font-weight: 800; color: #0f172a;">$7.000</div>
                        <div style="font-size: 0.64rem; color: #64748b;">Punto a punto</div>
                    </div>
                </div>
            </div>

            <!-- Método de Pago -->
            <div class="mob-card" style="margin-top: 0.35rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.66rem; font-weight: 800; color: #64748b; text-transform: uppercase;">MÉTODO DE PAGO</span>
                    <span style="font-size: 0.68rem; font-weight: 700; color: #92400e;">⚡ Pago Inmediato</span>
                </div>

                <div class="pay-grid">
                    <div class="pay-item selected" onclick="selectMobPay(this)">
                        <div style="font-size: 1rem; margin-bottom: 2px; color: #b45309;"><i class="bi bi-cash-coin"></i></div>
                        Efectivo
                    </div>
                    <div class="pay-item" onclick="selectMobPay(this)">
                        <div style="font-size: 1rem; margin-bottom: 2px; font-weight: 900; color: #0f172a;">N</div>
                        Nequi
                    </div>
                    <div class="pay-item" onclick="selectMobPay(this)">
                        <div style="font-size: 1rem; margin-bottom: 2px; color: #dc2626;"><i class="bi bi-wallet2"></i></div>
                        Daviplata
                    </div>
                    <div class="pay-item" onclick="selectMobPay(this)">
                        <div style="font-size: 1rem; margin-bottom: 2px; color: #475569;"><i class="bi bi-credit-card"></i></div>
                        Tarjeta
                    </div>
                </div>
            </div>

            <!-- Botón Principal Pedir Taxi Ahora -->
            <button type="submit" class="btn-gold-cta">
                <span style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="bi bi-taxi-front-fill"></i> Pedir Taxi Ahora
                </span>
                <span id="mobCtaPrice" style="background: rgba(15, 23, 42, 0.12); padding: 0.25rem 0.65rem; border-radius: 8px;">
                    $6.500 →
                </span>
            </button>

            <div style="text-align: center; font-size: 0.68rem; color: #64748b; padding: 0.35rem 0 0.75rem;">
                <i class="bi bi-shield-check" style="color: #047857;"></i> Supervisado por Tránsito Municipal de Ubaté
            </div>
        </form>
    </div>

    <!-- =========================================================================
         PESTAÑA 2: EN RUTA (IMAGEN 3)
         ========================================================================= -->
    <div id="tab-en_ruta" class="mob-tab-pane {{ $defaultTab === 'en_ruta' ? 'active' : '' }}">
        @if($activePassengerTrip)
            <!-- Mapa de Seguimiento en Ruta -->
            <div style="position: relative; height: 220px; background: linear-gradient(135deg, #d1fae5 0%, #e0f2fe 100%); border-bottom: 1px solid #e2e8f0; overflow: hidden;">
                <svg viewBox="0 0 400 220" style="width: 100%; height: 100%;">
                    <path d="M 75 55 Q 190 115 335 168" fill="none" stroke="#f59e0b" stroke-width="4.5" stroke-linecap="round" />
                    <circle cx="75" cy="55" r="7" fill="#047857" stroke="#fff" stroke-width="2" />
                    <circle cx="335" cy="168" r="7" fill="#92400e" stroke="#fff" stroke-width="2" />
                </svg>

                <!-- Marcador del Taxi en Movimiento -->
                <div style="position: absolute; top: 38%; left: 36%; text-align: center;">
                    <div style="background: #0f172a; color: #fff; font-size: 0.65rem; font-weight: 700; padding: 0.18rem 0.55rem; border-radius: 99px; margin-bottom: 4px; white-space: nowrap;">
                        <span style="color: #f59e0b;">●</span> {{ $activePassengerTrip->driver ? $activePassengerTrip->driver->name : 'Asignando Conductor' }}
                    </div>
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: #f59e0b; color: #0f172a; display: inline-flex; align-items: center; justify-content: center; font-size: 1rem; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                        <i class="bi bi-taxi-front-fill"></i>
                    </div>
                </div>

                <!-- Barra Resumen de Trayecto en la Base del Mapa -->
                <div style="position: absolute; bottom: 10px; left: 10px; right: 10px; background: #ffffff; border-radius: 12px; padding: 0.45rem 0.75rem; display: flex; align-items: center; justify-content: space-between; font-size: 0.7rem; font-weight: 700; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                    <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                        <span style="color: #047857;">●</span> {{ Str::limit($activePassengerTrip->origin_address, 18) }} →
                        <span style="color: #f59e0b;">■</span> {{ Str::limit($activePassengerTrip->destination_address, 18) }}
                    </div>
                    <span style="background: #eff6ff; color: #1d4ed8; padding: 0.14rem 0.45rem; border-radius: 6px; white-space: nowrap;">
                        {{ $activePassengerTrip->distance_km }} km
                    </span>
                </div>
            </div>

            <!-- Tarjeta ETA: Tu taxi llega en 3 min -->
            <div class="mob-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                    <span style="font-size: 0.66rem; font-weight: 800; color: #047857; text-transform: uppercase;">
                        ● TAXI EN CAMINO A TU RECOGIDA
                    </span>
                    <span style="font-size: 0.68rem; color: #475569; font-weight: 600;">
                        Servicio #TX-{{ $activePassengerTrip->id }}
                    </span>
                </div>

                <div class="outfit" style="font-size: 1.45rem; font-weight: 800; color: #0f172a; margin-bottom: 0.55rem;">
                    Tu taxi llega en <span style="color: #92400e;">{{ max(2, ceil($activePassengerTrip->distance_km * 1.5)) }} min</span>
                    <span style="font-size: 1.1rem; color: #92400e;">650 m</span>
                </div>

                <div style="height: 6px; background: #e2e8f0; border-radius: 99px; overflow: hidden; margin-bottom: 0.5rem;">
                    <div style="width: {{ $activePassengerTrip->status === 'en_camino' ? '72%' : '38%' }}; height: 100%; background: #f59e0b; border-radius: 99px;"></div>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 0.68rem; font-weight: 700; color: #64748b;">
                    <span style="color: #047857;">⊙ Despachado</span>
                    <span style="color: #92400e;"><i class="bi bi-taxi-front"></i> {{ ucfirst(str_replace('_', ' ', $activePassengerTrip->status)) }}</span>
                    <span><i class="bi bi-flag"></i> Destino final</span>
                </div>
            </div>

            <!-- Tarjeta Conductor y Placa Oficial (Imagen 3) -->
            <div class="mob-card">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.65rem; margin-bottom: 0.85rem;">
                    <div style="display: flex; align-items: center; gap: 0.7rem;">
                        <div style="position: relative; width: 52px; height: 52px; border-radius: 50%; background: #0f172a; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                            {{ $activePassengerTrip->driver ? strtoupper(substr($activePassengerTrip->driver->name, 0, 2)) : 'TX' }}
                            <span style="position: absolute; bottom: 0; right: 0; width: 16px; height: 16px; border-radius: 50%; background: #047857; color: #fff; font-size: 0.55rem; display: flex; align-items: center; justify-content: center; border: 1.5px solid #fff;">
                                <i class="bi bi-check"></i>
                            </span>
                        </div>
                        <div>
                            <div class="outfit" style="font-size: 1rem; font-weight: 800; color: #0f172a;">
                                {{ $activePassengerTrip->driver ? $activePassengerTrip->driver->name : 'Asignando Conductor...' }}
                            </div>
                            <div style="font-size: 0.7rem; color: #64748b;">Flota Cootransubaté</div>
                            <div style="font-size: 0.7rem; color: #b45309; font-weight: 700; margin-top: 2px;">
                                ☆ 4.9 <span style="color: #64748b; font-weight: 500;">(Verificado)</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-plate-box">
                        <div style="font-size: 0.52rem; font-weight: 800; letter-spacing: 0.5px;">COLOMBIA</div>
                        <div class="outfit" style="font-size: 0.98rem; font-weight: 800; margin: 1px 0;">
                            {{ ($activePassengerTrip->driver && $activePassengerTrip->driver->vehicle) ? $activePassengerTrip->driver->vehicle->license_plate : 'UBT-345' }}
                        </div>
                        <div style="font-size: 0.52rem; font-weight: 700;">UBATÉ</div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 0.75rem;">
                    <div style="background: #f8fafc; border-radius: 10px; padding: 0.5rem 0.65rem; font-size: 0.7rem;">
                        <div style="color: #64748b;">Vehículo</div>
                        <strong style="color: #0f172a;">
                            {{ ($activePassengerTrip->driver && $activePassengerTrip->driver->vehicle) ? $activePassengerTrip->driver->vehicle->brand . ' ' . $activePassengerTrip->driver->vehicle->model : 'Taxi Oficial' }}
                        </strong>
                    </div>
                    <div style="background: #f8fafc; border-radius: 10px; padding: 0.5rem 0.65rem; font-size: 0.7rem;">
                        <div style="color: #64748b;">Seguridad Legal</div>
                        <strong style="color: #047857;">SOAT & RUNT Al Día</strong>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 0.55rem;">
                    <a href="tel:{{ $activePassengerTrip->driver->phone ?? '123' }}" style="background: #e8eef5; color: #0f172a; border-radius: 11px; padding: 0.65rem; font-size: 0.8rem; font-weight: 700; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                        <i class="bi bi-telephone"></i> Llamar
                    </a>
                    <button type="button" onclick="switchMobTab('conductor')" style="background: #f59e0b; color: #0f172a; border: none; border-radius: 11px; padding: 0.65rem; font-size: 0.8rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                        <i class="bi bi-chat-left-text"></i> Ver en Conductor
                    </button>
                </div>
            </div>

            <!-- Tarjeta Resumen de Tarifa -->
            <div class="mob-card" style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.7rem;">
                    <div style="width: 38px; height: 38px; border-radius: 10px; background: #eff6ff; color: #0f172a; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <strong class="outfit" style="font-size: 1.05rem; color: #0f172a;">
                                ${{ number_format($activePassengerTrip->estimated_fare, 0, ',', '.') }} COP
                            </strong>
                            <span style="background: #86efac; color: #064e3b; font-size: 0.6rem; font-weight: 800; padding: 0.12rem 0.45rem; border-radius: 5px;">
                                Tarifa Fijada
                            </span>
                        </div>
                        <div style="font-size: 0.7rem; color: #64748b;">
                            <span style="color: #f59e0b;">●</span> PIN de Abordaje: <strong>{{ str_pad(($activePassengerTrip->id * 137) % 10000, 4, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monitoreo & Seguridad Ciudadana -->
            <div class="mob-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.45rem;">
                    <div style="display: flex; align-items: center; gap: 0.45rem; font-weight: 800; font-size: 0.84rem; color: #0f172a;">
                        <i class="bi bi-shield-check" style="color: #047857;"></i>
                        <span>Monitoreo & Seguridad Ciudadana</span>
                    </div>
                    <span style="font-size: 0.65rem; font-weight: 800; color: #047857;">● Cuadrante 3 Activo</span>
                </div>
                <p style="font-size: 0.72rem; color: #64748b; line-height: 1.4; margin-bottom: 0.75rem;">
                    Tu desplazamiento está registrado por la red satelital de la Central de Taxis de Ubaté y enlazado preventivamente al Distrito de Policía.
                </p>

                <form action="{{ route('movil.trips.status', $activePassengerTrip) }}" method="POST" style="margin-bottom: 0.5rem;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="cancelado">
                    <button type="submit" style="width: 100%; background: #e8eef5; color: #0f172a; border: none; border-radius: 11px; padding: 0.68rem; font-size: 0.78rem; font-weight: 700; cursor: pointer;">
                        <i class="bi bi-x-circle"></i> Cancelar Solicitud Actual
                    </button>
                </form>

                <button type="button" onclick="alert('Alerta SOS enviada a Estación de Policía Ubaté (123).')" style="width: 100%; background: #b91c1c; color: #ffffff; border: none; border-radius: 11px; padding: 0.72rem; font-size: 0.8rem; font-weight: 800; cursor: pointer;">
                    SOS Botón SOS / Policía Ubaté
                </button>
            </div>
        @else
            <div class="mob-card" style="text-align: center; padding: 2.5rem 1.25rem; margin-top: 1.5rem;">
                <i class="bi bi-signpost-split" style="font-size: 2.2rem; color: #94a3b8;"></i>
                <h3 class="outfit" style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-top: 0.5rem;">
                    0 Viajes en Ruta Ahora
                </h3>
                <p style="font-size: 0.78rem; color: #64748b; margin: 0.35rem 0 1.1rem; line-height: 1.45;">
                    No tienes ningún servicio activo en curso. Ve a la pestaña <strong>"Pedir"</strong> para solicitar un taxi y seguir tu recorrido en vivo.
                </p>
                <button type="button" onclick="switchMobTab('pedir')" style="background: #f59e0b; color: #0f172a; border: none; border-radius: 11px; padding: 0.7rem 1.25rem; font-weight: 800; cursor: pointer;">
                    Ir a Pedir Taxi
                </button>
            </div>
        @endif
    </div>

    <!-- =========================================================================
         PESTAÑA 3: CONDUCTOR MÓVIL (IMAGEN 2: SOLICITUD E IMAGEN 4: EN VIAJE)
         ========================================================================= -->
    <div id="tab-conductor" class="mob-tab-pane {{ $defaultTab === 'conductor' ? 'active' : '' }}">
        <!-- Selector Rápido entre Vista Solicitud (Imagen 2) y Vista Navegación en Viaje (Imagen 4) -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.4rem; margin: 0.65rem 0.85rem 0; background: #e2e8f0; padding: 0.22rem; border-radius: 11px;">
            <button type="button" id="btnSubDriverReq" onclick="switchDriverSubView('solicitud')" style="border: none; border-radius: 9px; padding: 0.42rem; font-size: 0.72rem; font-weight: 800; cursor: pointer; background: {{ !$activeDriverTrip ? '#ffffff' : 'transparent' }}; color: #0f172a;">
                1. Recepción ({{ $driverStats['pending_count'] }})
            </button>
            <button type="button" id="btnSubDriverNav" onclick="switchDriverSubView('navegacion')" style="border: none; border-radius: 9px; padding: 0.42rem; font-size: 0.72rem; font-weight: 800; cursor: pointer; background: {{ $activeDriverTrip ? '#ffffff' : 'transparent' }}; color: #0f172a;">
                2. En Viaje / GPS {{ $activeDriverTrip ? '●' : '' }}
            </button>
        </div>

        <!-- SUB-VISTA A: RECEPCIÓN DE SOLICITUDES DEL CONDUCTOR (IMAGEN 2) -->
        <div id="driver-sub-solicitud" style="display: {{ !$activeDriverTrip ? 'block' : 'none' }};">
            <!-- Tarjeta Conectado y Activo + Ganancias de Hoy -->
            <div class="mob-card">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.4rem;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #047857;"></span>
                            <strong class="outfit" style="font-size: 1.05rem; color: #0f172a;">Conectado y Activo</strong>
                        </div>
                        <div style="font-size: 0.7rem; color: #047857; font-weight: 700; margin-left: 1.1rem;">
                            Recibiendo viajes prioritarios
                        </div>
                    </div>

                    <form action="{{ route('movil.availability') }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="background: #10b981; color: #064e3b; border: none; border-radius: 99px; padding: 0.42rem 0.85rem; font-size: 0.74rem; font-weight: 800; cursor: pointer;">
                            <i class="bi bi-power"></i> {{ $user->is_available ? 'Disponible' : 'Activar' }}
                        </button>
                    </form>
                </div>

                <div style="background: #f1f5f9; border-radius: 12px; padding: 0.65rem 0.85rem; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 0.6rem;">
                        <i class="bi bi-cash-stack" style="color: #b45309; font-size: 1.1rem;"></i>
                        <div>
                            <div style="font-size: 0.68rem; color: #475569; font-weight: 600;">
                                Hoy: {{ $driverStats['completed_trips'] }} carreras
                            </div>
                            <div class="outfit" style="font-size: 1.15rem; font-weight: 800; color: #0f172a;">
                                ${{ number_format($driverStats['total_earnings'], 0, ',', '.') }} <span style="font-size: 0.7rem; font-weight: 500; color: #64748b;">COP</span>
                            </div>
                        </div>
                    </div>
                    <span style="background: #86efac; color: #064e3b; font-size: 0.66rem; font-weight: 800; padding: 0.22rem 0.55rem; border-radius: 6px;">
                        <i class="bi bi-patch-check"></i> 0% Comisión
                    </span>
                </div>
            </div>

            <!-- Mapa de Zonas Altas (Imagen 2) -->
            <div class="mob-card" style="padding: 0; overflow: hidden; position: relative; height: 185px; background: linear-gradient(135deg, #d1fae5 0%, #ccfbf1 60%, #cbd5e1 100%);">
                <svg viewBox="0 0 400 185" style="width: 100%; height: 100%;">
                    <path d="M 120 185 L 210 95 L 250 10" fill="none" stroke="#94a3b8" stroke-width="2.5" />
                    <g fill="#334155" font-size="9" font-weight="700">
                        <text x="35" y="65">Carmen de Carupa</text>
                        <text x="195" y="75">Suaga</text>
                        <text x="195" y="118" font-size="11" fill="#0f172a">Ubaté</text>
                        <text x="135" y="135">Bruselas</text>
                        <text x="275" y="105">Gibraltar</text>
                    </g>
                </svg>

                <div style="position: absolute; top: 10px; left: 10px; background: #ffffff; padding: 0.25rem 0.65rem; border-radius: 99px; font-size: 0.68rem; font-weight: 800;">
                    <span style="color: #f59e0b;">●</span> En Cola ({{ $driverStats['pending_count'] }})
                </div>

                <div style="position: absolute; bottom: 10px; left: 10px; right: 10px; display: flex; gap: 0.4rem;">
                    <span style="background: #ffffff; padding: 0.24rem 0.6rem; border-radius: 99px; font-size: 0.65rem; font-weight: 700;">
                        🔥 Terminal de Transportes
                    </span>
                    <span style="background: #ffffff; padding: 0.24rem 0.6rem; border-radius: 99px; font-size: 0.65rem; font-weight: 700;">
                        🧭 Parque Los Libertadores
                    </span>
                </div>
            </div>

            <!-- Tarjeta ¡NUEVA SOLICITUD! Real desde BD (Imagen 2) -->
            @if($incomingDriverTrip)
                <div class="mob-card">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 0.6rem;">
                            <div style="width: 38px; height: 38px; border-radius: 50%; border: 3px solid #f59e0b; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.82rem; color: #0f172a;">
                                12
                            </div>
                            <div>
                                <div style="font-size: 0.65rem; font-weight: 800; color: #b45309; text-transform: uppercase;">
                                    ¡NUEVA SOLICITUD! #TX-{{ $incomingDriverTrip->id }}
                                </div>
                                <div class="outfit" style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                                    Servicio Inmediato
                                </div>
                            </div>
                        </div>

                        <div style="text-align: right;">
                            <div class="outfit" style="font-size: 1.45rem; font-weight: 800; color: #0f172a; line-height: 1;">
                                ${{ number_format($incomingDriverTrip->estimated_fare, 0, ',', '.') }}
                            </div>
                            <div style="font-size: 0.65rem; color: #64748b;">Neto conductor</div>
                        </div>
                    </div>

                    <div style="background: #f1f5f9; border-radius: 12px; padding: 0.65rem 0.75rem; display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.85rem;">
                        <div style="display: flex; align-items: center; gap: 0.6rem;">
                            <div class="mob-avatar" style="background: #1e293b;">
                                {{ $incomingDriverTrip->passenger ? strtoupper(substr($incomingDriverTrip->passenger->name, 0, 2)) : 'PA' }}
                            </div>
                            <div>
                                <div style="font-weight: 800; font-size: 0.85rem; color: #0f172a;">
                                    {{ $incomingDriverTrip->passenger ? $incomingDriverTrip->passenger->name : 'Pasajero' }}
                                </div>
                                <div style="font-size: 0.68rem; color: #64748b;">
                                    <span style="color: #d97706; font-weight: 700;">☆ 4.9</span> • Pago:
                                    <span style="background: #dbeafe; color: #1e40af; padding: 0.08rem 0.35rem; border-radius: 4px; font-weight: 700;">Efectivo</span>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: right; font-size: 0.68rem;">
                            <div style="color: #047857; font-weight: 700;">Tarifa: ${{ number_format($incomingDriverTrip->estimated_fare, 0, ',', '.') }}</div>
                            <div style="color: #b45309; font-weight: 600;">{{ $incomingDriverTrip->distance_km }} km</div>
                        </div>
                    </div>

                    <div style="padding-left: 0.25rem; margin-bottom: 0.9rem;">
                        <div style="display: flex; gap: 0.65rem; margin-bottom: 0.65rem;">
                            <span style="color: #047857; font-size: 0.9rem;">⊙</span>
                            <div>
                                <div style="font-size: 0.65rem; font-weight: 800; color: #047857; text-transform: uppercase;">
                                    RECOGIDA (a 650 m • 2 min)
                                </div>
                                <div style="font-size: 0.85rem; font-weight: 800; color: #0f172a;">
                                    {{ $incomingDriverTrip->origin_address }}
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 0.65rem;">
                            <span style="color: #f59e0b; font-size: 0.9rem;">⏹</span>
                            <div>
                                <div style="font-size: 0.65rem; font-weight: 800; color: #475569; text-transform: uppercase;">
                                    DESTINO ({{ $incomingDriverTrip->distance_km }} km aprox)
                                </div>
                                <div style="font-size: 0.85rem; font-weight: 800; color: #0f172a;">
                                    {{ $incomingDriverTrip->destination_address }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1.65fr; gap: 0.55rem;">
                        <form action="{{ route('movil.trips.status', $incomingDriverTrip) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelado">
                            <input type="hidden" name="tab" value="conductor">
                            <button type="submit" style="width: 100%; background: #e8eef5; color: #0f172a; border: none; border-radius: 12px; padding: 0.8rem; font-size: 0.82rem; font-weight: 800; cursor: pointer;">
                                ✕ Rechazar
                            </button>
                        </form>

                        <form action="{{ route('movil.trips.accept', $incomingDriverTrip) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="width: 100%; background: #f59e0b; color: #0f172a; border: none; border-radius: 12px; padding: 0.8rem; font-family: 'Outfit', sans-serif; font-size: 0.9rem; font-weight: 800; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                                <i class="bi bi-cursor-fill"></i> ACEPTAR VIAJE
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="mob-card" style="text-align: center; padding: 1.75rem 1rem;">
                    <i class="bi bi-inbox" style="font-size: 1.8rem; color: #94a3b8;"></i>
                    <div class="outfit" style="font-size: 0.98rem; font-weight: 800; color: #0f172a; margin-top: 0.35rem;">
                        0 Solicitudes Pendientes
                    </div>
                    <p style="font-size: 0.74rem; color: #64748b; margin-top: 0.2rem;">
                        Cuando un pasajero solicite un taxi desde la pestaña "Pedir" o el panel web, aparecerá aquí al instante.
                    </p>
                </div>
            @endif

            <!-- Barra Red de Apoyo Ubaté Activa -->
            <div class="mob-card" style="background: #e8eef5; display: flex; align-items: center; justify-content: space-between; padding: 0.7rem 0.95rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.7rem; color: #334155;">
                    <i class="bi bi-shield-check"></i>
                    <span>Red de Apoyo Ubaté<br>Activa</span>
                </div>
                <div style="font-size: 0.7rem; font-weight: 800; color: #0f172a;">
                    Frecuencia: 142.3<br>MHz
                </div>
                <button type="button" style="background: #dbeafe; color: #92400e; border: none; border-radius: 8px; padding: 0.35rem 0.65rem; font-size: 0.68rem; font-weight: 800;">
                    Canal<br>PTT
                </button>
            </div>
        </div>

        <!-- SUB-VISTA B: NAVEGACIÓN EN VIAJE Y FINALIZAR CARRERA (IMAGEN 4) -->
        <div id="driver-sub-navegacion" style="display: {{ $activeDriverTrip ? 'block' : 'none' }};">
            <!-- Mapa con Banner Oscuro Turn-by-Turn (Imagen 4) -->
            <div style="position: relative; height: 280px; background: linear-gradient(135deg, #d1fae5 0%, #99f6e4 50%, #cbd5e1 100%); margin-top: 0.6rem; overflow: hidden;">
                <svg viewBox="0 0 400 280" style="width: 100%; height: 100%;">
                    <path d="M 140 280 L 210 150 L 265 20" fill="none" stroke="#64748b" stroke-width="3" />
                    <g fill="#334155" font-size="9" font-weight="700">
                        <text x="195" y="140" font-size="11" fill="#0f172a">Ubaté</text>
                        <text x="215" y="158">Altamira</text>
                        <text x="125" y="158">Bruselas</text>
                        <text x="235" y="195">La Ramada</text>
                    </g>
                </svg>

                <!-- Banner Oscuro Superior de Giro (En 200 m Gire a la derecha) -->
                <div style="position: absolute; top: 10px; left: 10px; right: 10px; background: #1e293b; color: #ffffff; border-radius: 14px; padding: 0.65rem 0.8rem; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 6px 16px rgba(0,0,0,0.25);">
                    <div style="display: flex; align-items: center; gap: 0.65rem;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #f59e0b; color: #0f172a; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                            <i class="bi bi-arrow-90deg-right"></i>
                        </div>
                        <div>
                            <div style="display: flex; align-items: center; gap: 0.4rem;">
                                <strong class="outfit" style="font-size: 0.95rem;">En 200 m</strong>
                                <span style="background: #065f46; color: #6ee7b7; font-size: 0.58rem; font-weight: 800; padding: 0.1rem 0.4rem; border-radius: 99px;">● Rápido</span>
                            </div>
                            <div style="font-size: 0.78rem; font-weight: 700;">Gire a la derecha en Cra 6</div>
                            <div style="font-size: 0.66rem; color: #94a3b8;">
                                Hacia {{ $activeDriverTrip ? Str::limit($activeDriverTrip->destination_address, 26) : 'Parque Los Libertadores' }}
                            </div>
                        </div>
                    </div>

                    <a href="https://www.google.com/maps/dir/?api=1&destination=5.3165,-73.8210&travelmode=driving" target="_blank" style="background: #334155; color: #fff; border-radius: 10px; padding: 0.4rem 0.55rem; text-decoration: none; text-align: center; font-size: 0.65rem; font-weight: 700;">
                        <i class="bi bi-cursor" style="display: block; font-size: 0.9rem;"></i>
                        Waze
                    </a>
                </div>

                <!-- Barra Oscura Inferior de Velocidad, Distancia Restante y Llegada -->
                <div style="position: absolute; bottom: 0; left: 0; right: 0; background: #1e293b; color: #ffffff; padding: 0.65rem 1rem; display: grid; grid-template-columns: repeat(3, 1fr); text-align: center;">
                    <div>
                        <div class="outfit" style="font-size: 1.15rem; font-weight: 800; color: #fbbf24;">
                            32 <span style="font-size: 0.7rem;">km/h</span>
                        </div>
                        <div style="font-size: 0.58rem; color: #94a3b8; font-weight: 700;">VELOCIDAD</div>
                    </div>
                    <div style="background: #334155; border-radius: 8px; padding: 0.15rem 0;">
                        <div class="outfit" style="font-size: 1.15rem; font-weight: 800; color: #ffffff;">
                            {{ $activeDriverTrip ? $activeDriverTrip->distance_km : '0.0' }} <span style="font-size: 0.7rem;">km</span>
                        </div>
                        <div style="font-size: 0.58rem; color: #94a3b8; font-weight: 700;">RESTANTE</div>
                    </div>
                    <div>
                        <div class="outfit" style="font-size: 1.15rem; font-weight: 800; color: #4ade80;">
                            {{ $activeDriverTrip ? max(2, ceil($activeDriverTrip->distance_km * 2)) : '0' }} <span style="font-size: 0.7rem;">min</span>
                        </div>
                        <div style="font-size: 0.58rem; color: #94a3b8; font-weight: 700;">LLEGADA</div>
                    </div>
                </div>
            </div>

            @if($activeDriverTrip)
                <!-- Tarjeta Pasajero a Bordo (Imagen 4) -->
                <div class="mob-card">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                        <div style="display: flex; align-items: center; gap: 0.65rem;">
                            <div class="mob-avatar" style="width: 44px; height: 44px;">
                                {{ $activeDriverTrip->passenger ? strtoupper(substr($activeDriverTrip->passenger->name, 0, 2)) : 'PA' }}
                            </div>
                            <div>
                                <div style="display: flex; align-items: center; gap: 0.4rem;">
                                    <strong class="outfit" style="font-size: 1rem; color: #0f172a;">
                                        {{ $activeDriverTrip->passenger ? Str::limit($activeDriverTrip->passenger->name, 16) : 'Pasajero' }}
                                    </strong>
                                    <span style="background: #dbeafe; color: #1e40af; font-size: 0.62rem; font-weight: 800; padding: 0.1rem 0.4rem; border-radius: 99px;">★ 4.9</span>
                                </div>
                                <div style="font-size: 0.72rem; color: #047857; font-weight: 700;">
                                    <i class="bi bi-person-check"></i> Pasajero a bordo
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; gap: 0.4rem;">
                            <a href="tel:{{ $activeDriverTrip->passenger->phone ?? '123' }}" style="width: 36px; height: 36px; border-radius: 10px; background: #dbeafe; color: #0f172a; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                <i class="bi bi-telephone"></i>
                            </a>
                            <button type="button" style="width: 36px; height: 36px; border-radius: 10px; background: #ffedd5; color: #0f172a; border: none;">
                                <i class="bi bi-headset"></i>
                            </button>
                        </div>
                    </div>

                    <div style="background: #f1f5f9; border-radius: 12px; padding: 0.75rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                            <span style="font-size: 0.65rem; font-weight: 800; color: #475569; text-transform: uppercase;">
                                <i class="bi bi-plus-square-fill" style="color: #92400e;"></i> DESTINO ACTIVO
                            </span>
                            <span style="background: #fee2e2; color: #dc2626; font-size: 0.6rem; font-weight: 800; padding: 0.1rem 0.45rem; border-radius: 4px;">
                                Prioritario
                            </span>
                        </div>
                        <div class="outfit" style="font-size: 1rem; font-weight: 800; color: #0f172a;">
                            {{ $activeDriverTrip->destination_address }}
                        </div>
                        <div style="font-size: 0.7rem; color: #64748b; margin-top: 2px;">
                            Origen: {{ $activeDriverTrip->origin_address }}
                        </div>
                    </div>
                </div>

                <!-- Tarjeta Estado del Servicio (Etapa 4 de 5) -->
                <div class="mob-card">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.6rem;">
                        <span style="font-size: 0.68rem; font-weight: 800; color: #334155; text-transform: uppercase;">ESTADO DEL SERVICIO</span>
                        <span style="background: #ffedd5; color: #92400e; font-size: 0.64rem; font-weight: 800; padding: 0.15rem 0.5rem; border-radius: 99px;">
                            Etapa 4 de 5
                        </span>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 0.3rem; margin-bottom: 0.35rem;">
                        <div style="height: 6px; border-radius: 99px; background: #10b981;"></div>
                        <div style="height: 6px; border-radius: 99px; background: #10b981;"></div>
                        <div style="height: 6px; border-radius: 99px; background: #10b981;"></div>
                        <div style="height: 6px; border-radius: 99px; background: #f59e0b;"></div>
                        <div style="height: 6px; border-radius: 99px; background: #e2e8f0;"></div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(5, 1fr); font-size: 0.6rem; color: #64748b; margin-bottom: 0.85rem;">
                        <span>1. Aceptado</span>
                        <span>2. En camino</span>
                        <span>3. Llegué</span>
                        <strong style="color: #92400e;">4. En Viaje</strong>
                        <span style="text-align: right;">5. Finalizar</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.65rem; border-top: 1px solid #f1f5f9;">
                        <span style="font-size: 0.74rem; color: #475569; font-weight: 600;">
                            <i class="bi bi-patch-check" style="color: #047857;"></i> Tarifa Regulada Ubaté
                        </span>
                        <strong class="outfit" style="font-size: 1.2rem; font-weight: 800; color: #0f172a;">
                            COP ${{ number_format($activeDriverTrip->estimated_fare, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>

                <!-- Botón FINALIZAR CARRERA (Imagen 4) -->
                <div style="margin: 0.5rem 0.85rem; background: #3f3826; padding: 0.45rem; border-radius: 16px;">
                    <form action="{{ route('movil.trips.status', $activeDriverTrip) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="completado">
                        <button type="submit" style="width: 100%; background: #f59e0b; color: #0f172a; border: none; border-radius: 12px; padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between; cursor: pointer;">
                            <div style="display: flex; align-items: center; gap: 0.65rem; text-align: left;">
                                <div style="width: 34px; height: 34px; border-radius: 50%; background: rgba(15, 23, 42, 0.12); display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-flag"></i>
                                </div>
                                <div>
                                    <div class="outfit" style="font-size: 0.92rem; font-weight: 800;">FINALIZAR CARRERA</div>
                                    <div style="font-size: 0.68rem; font-weight: 600; opacity: 0.85;">Toca para cobrar y cerrar</div>
                                </div>
                            </div>
                            <span style="font-weight: 800; font-size: 1rem;">&gt;&gt;</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="mob-card" style="text-align: center; padding: 1.75rem 1rem;">
                    <div class="outfit" style="font-size: 0.98rem; font-weight: 800; color: #0f172a;">
                        Sin Viaje en Navegación Activa
                    </div>
                    <p style="font-size: 0.74rem; color: #64748b; margin: 0.25rem 0 0.85rem;">
                        Acepta primero una solicitud en la pestaña "1. Recepción" para iniciar la navegación paso a paso.
                    </p>
                    <button type="button" onclick="switchDriverSubView('solicitud')" style="background: #0f172a; color: #fff; border: none; border-radius: 9px; padding: 0.5rem 1rem; font-size: 0.75rem; font-weight: 700; cursor: pointer;">
                        Ver Solicitudes
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- =========================================================================
         PESTAÑA 4: HISTORIAL REAL DE SERVICIOS
         ========================================================================= -->
    <div id="tab-historial" class="mob-tab-pane {{ $defaultTab === 'historial' ? 'active' : '' }}">
        <div class="mob-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <h3 class="outfit" style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">
                    Historial Real de Viajes ({{ $myTrips->count() }})
                </h3>
                <span style="font-size: 0.68rem; font-weight: 700; color: #047857;">Base de Datos</span>
            </div>

            @forelse($myTrips as $hTrip)
                <div style="padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                        <strong style="font-size: 0.8rem; color: #0f172a;">#TX-{{ $hTrip->id }} • {{ $hTrip->created_at ? $hTrip->created_at->format('d/m H:i') : '' }}</strong>
                        <span style="font-size: 0.68rem; font-weight: 800; color: {{ $hTrip->status === 'completado' ? '#047857' : ($hTrip->status === 'cancelado' ? '#dc2626' : '#b45309') }};">
                            {{ strtoupper(str_replace('_', ' ', $hTrip->status)) }}
                        </span>
                    </div>
                    <div style="font-size: 0.75rem; color: #334155;">
                        <strong>Origen:</strong> {{ $hTrip->origin_address }}
                    </div>
                    <div style="font-size: 0.75rem; color: #334155;">
                        <strong>Destino:</strong> {{ $hTrip->destination_address }}
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 0.3rem; font-size: 0.74rem;">
                        <span style="color: #64748b;">Distancia: {{ $hTrip->distance_km }} km</span>
                        <strong style="color: #0f172a;">${{ number_format($hTrip->estimated_fare, 0, ',', '.') }} COP</strong>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 2rem 1rem; color: #64748b; font-size: 0.78rem;">
                    0 viajes registrados en la base de datos.
                </div>
            @endforelse
        </div>
    </div>

    <!-- BARRA DE NAVEGACIÓN INFERIOR MÓVIL (Pedir | En Ruta | Conductor | Historial) -->
    <nav class="mob-bottom-nav">
        <button type="button" id="nav-pedir" class="mob-nav-item {{ $defaultTab === 'pedir' ? 'active' : '' }}" onclick="switchMobTab('pedir')">
            <i class="bi bi-taxi-front"></i>
            <span>Pedir</span>
        </button>
        <button type="button" id="nav-en_ruta" class="mob-nav-item {{ $defaultTab === 'en_ruta' ? 'active' : '' }}" onclick="switchMobTab('en_ruta')">
            <i class="bi bi-bezier2"></i>
            <span>En Ruta</span>
        </button>
        <button type="button" id="nav-conductor" class="mob-nav-item {{ $defaultTab === 'conductor' ? 'active' : '' }}" onclick="switchMobTab('conductor')">
            <i class="bi bi-bullseye"></i>
            <span>Conductor</span>
        </button>
        <button type="button" id="nav-historial" class="mob-nav-item {{ $defaultTab === 'historial' ? 'active' : '' }}" onclick="switchMobTab('historial')">
            <i class="bi bi-receipt"></i>
            <span>Historial</span>
        </button>
    </nav>
</div>

<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').catch(function () {});
    }

    function switchMobTab(tab) {
        document.querySelectorAll('.mob-tab-pane').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.mob-bottom-nav .mob-nav-item').forEach(b => b.classList.remove('active'));

        document.getElementById('tab-' + tab).classList.add('active');
        document.getElementById('nav-' + tab).classList.add('active');

        const titles = {
            'pedir': 'Pedir',
            'en_ruta': 'En Ruta',
            'conductor': 'Conductor',
            'historial': 'Historial'
        };
        document.getElementById('mobTopSubtitle').textContent = titles[tab] || 'App Móvil';
    }

    function switchDriverSubView(mode) {
        const reqEl = document.getElementById('driver-sub-solicitud');
        const navEl = document.getElementById('driver-sub-navegacion');
        const btnReq = document.getElementById('btnSubDriverReq');
        const btnNav = document.getElementById('btnSubDriverNav');

        if (mode === 'solicitud') {
            reqEl.style.display = 'block';
            navEl.style.display = 'none';
            btnReq.style.background = '#ffffff';
            btnNav.style.background = 'transparent';
        } else {
            reqEl.style.display = 'none';
            navEl.style.display = 'block';
            btnReq.style.background = 'transparent';
            btnNav.style.background = '#ffffff';
        }
    }

    // Inicializar Mapa Leaflet en la App Móvil
    let mobMap = null;
    let mobOriginMarker = null;
    let mobDestMarker = null;
    let mobRouteLine = null;
    const availableDriversMob = @json($availableDrivers);

    function initMobMap() {
        if (mobMap || !document.getElementById('mobLeafletMap')) return;

        mobMap = L.map('mobLeafletMap', { zoomControl: false }).setView([5.3110, -73.8165], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OSM Ubaté'
        }).addTo(mobMap);

        const iconA = L.divIcon({
            className: '',
            html: '<div style="background:#10b981;color:#fff;width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;font-weight:800;font-size:11px;box-shadow:0 2px 5px rgba(0,0,0,0.4);">A</div>',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        });

        const iconB = L.divIcon({
            className: '',
            html: '<div style="background:#ef4444;color:#fff;width:24px;height:24px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;font-weight:800;font-size:11px;box-shadow:0 2px 5px rgba(0,0,0,0.4);">B</div>',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        });

        mobOriginMarker = L.marker([5.3080, -73.8150], { draggable: true, icon: iconA }).addTo(mobMap);
        mobDestMarker = L.marker([5.3165, -73.8210], { draggable: true, icon: iconB }).addTo(mobMap);
        mobRouteLine = L.polyline([[5.3080, -73.8150], [5.3165, -73.8210]], { color: '#f59e0b', weight: 4.5, opacity: 0.9 }).addTo(mobMap);

        // Renderizar taxis disponibles
        if (availableDriversMob && availableDriversMob.length) {
            availableDriversMob.forEach(d => {
                if (!d.latitude || !d.longitude) return;
                const taxiIcon = L.divIcon({
                    className: '',
                    html: `<div style="background:#f59e0b;color:#0f172a;width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #fff;box-shadow:0 2px 5px rgba(0,0,0,0.3);font-size:12px;">
                            <i class="bi bi-taxi-front-fill"></i>
                           </div>`,
                    iconSize: [26, 26],
                    iconAnchor: [13, 13]
                });
                const m = L.marker([parseFloat(d.latitude), parseFloat(d.longitude)], { icon: taxiIcon });
                m.bindPopup(`<b>${d.name}</b><br>Placa: ${d.vehicle ? d.vehicle.license_plate : 'En servicio'}`);
                mobMap.addLayer(m);
            });
        }

        mobOriginMarker.on('dragend', () => {
            const p = mobOriginMarker.getLatLng();
            reverseGeocodeMob(p.lat, p.lng, 'mobOriginInput');
            syncMobDistance();
        });

        mobDestMarker.on('dragend', () => {
            const p = mobDestMarker.getLatLng();
            reverseGeocodeMob(p.lat, p.lng, 'mobDestInput');
            syncMobDistance();
        });

        mobMap.on('click', (e) => {
            mobDestMarker.setLatLng(e.latlng);
            reverseGeocodeMob(e.latlng.lat, e.latlng.lng, 'mobDestInput');
            syncMobDistance();
        });
    }

    async function reverseGeocodeMob(lat, lng, inputId) {
        try {
            const res = await fetch(`/geo/reverse?latitude=${lat}&longitude=${lng}`);
            if (res.ok) {
                const data = await res.json();
                if (data && data.address) {
                    document.getElementById(inputId).value = data.address;
                    return;
                }
            }
        } catch (e) {}
    }

    function syncMobDistance() {
        const o = mobOriginMarker.getLatLng();
        const d = mobDestMarker.getLatLng();

        document.getElementById('mob_origin_lat').value = o.lat.toFixed(7);
        document.getElementById('mob_origin_lng').value = o.lng.toFixed(7);
        document.getElementById('mob_dest_lat').value = d.lat.toFixed(7);
        document.getElementById('mob_dest_lng').value = d.lng.toFixed(7);

        mobRouteLine.setLatLngs([o, d]);

        const R = 6371;
        const dLat = (d.lat - o.lat) * Math.PI / 180;
        const dLon = (d.lng - o.lng) * Math.PI / 180;
        const a = Math.sin(dLat/2)*Math.sin(dLat/2) + Math.cos(o.lat*Math.PI/180)*Math.cos(d.lat*Math.PI/180)*Math.sin(dLon/2)*Math.sin(dLon/2);
        const dist = Math.max(0.5, R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)) * 1.25);

        const base = 5000;
        const distCost = Math.round((dist * 1500) / 100) * 100;
        const fare = Math.max(6000, base + distCost);

        updateMobNumbers(dist, fare);
    }

    function useMobGPS() {
        const btn = document.getElementById('btnMobGps');
        const toast = document.getElementById('mobGpsToast');

        if (!navigator.geolocation) {
            showMobToast('GPS no soportado en tu dispositivo.', '#fef2f2', '#b91c1c');
            return;
        }

        btn.style.opacity = '0.5';
        showMobToast('Capturando señal GPS satelital...', '#eff6ff', '#1d4ed8');

        navigator.geolocation.getCurrentPosition(
            function(pos) {
                btn.style.opacity = '1';
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                const acc = Math.round(pos.coords.accuracy || 0);

                if (mobOriginMarker && mobMap) {
                    mobOriginMarker.setLatLng([lat, lng]);
                    mobMap.setView([lat, lng], 15);
                    reverseGeocodeMob(lat, lng, 'mobOriginInput');
                    syncMobDistance();
                }

                showMobToast(`✓ GPS fijado (Precisión: ±${acc}m)`, '#ecfdf5', '#047857');
            },
            function(err) {
                btn.style.opacity = '1';
                let msg = 'Error de GPS.';
                if (err.code === 1) msg = 'Permiso GPS denegado. Permite la ubicación en el navegador.';
                else if (err.code === 2) msg = 'Señal GPS no disponible.';
                else if (err.code === 3) msg = 'Tiempo agotado al buscar GPS.';
                showMobToast(msg, '#fffbeb', '#b45309');
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    function showMobToast(text, bg, color) {
        const toast = document.getElementById('mobGpsToast');
        if (!toast) return;
        toast.style.display = 'block';
        toast.style.background = bg;
        toast.style.color = color;
        toast.textContent = text;
        setTimeout(() => { toast.style.display = 'none'; }, 5000);
    }

    function setMobRoute(dest, lat, lng, km, fare) {
        document.getElementById('mobDestInput').value = dest;
        if (mobDestMarker && mobMap) {
            mobDestMarker.setLatLng([lat, lng]);
            mobMap.panTo([lat, lng]);
            syncMobDistance();
        } else {
            updateMobNumbers(km, fare);
        }
    }

    // Inicializar mapa al cargar pestaña
    document.addEventListener('DOMContentLoaded', () => {
        initMobMap();
    });

    function selectMobService(card, km, fare) {
        document.querySelectorAll('.service-option-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        updateMobNumbers(km, fare);
    }

    function updateMobNumbers(km, fare) {
        const mins = Math.max(4, Math.ceil(km * 2.8));
        document.getElementById('mobDistanceInput').value = km;
        document.getElementById('mobFareInput').value = fare;
        document.getElementById('mobDistDisplay').textContent = km.toFixed(1) + ' km';
        document.getElementById('mobTimeDisplay').textContent = '~' + mins + ' min';
        document.getElementById('mobCtaPrice').textContent = '$' + fare.toLocaleString('es-CO') + ' →';
    }

    function selectMobPay(item) {
        document.querySelectorAll('.pay-grid .pay-item').forEach(i => i.classList.remove('selected'));
        item.classList.add('selected');
    }
</script>
</body>
</html>
