<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaxiUbaté — Provincia del Valle de Ubaté | Transporte Oficial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            line-height: 1.5;
        }

        h1, h2, h3, h4, .brand-font {
            font-family: 'Outfit', sans-serif;
        }

        .landing-nav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .landing-nav-inner {
            max-width: 1220px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .municipal-strip {
            background: #0f172a;
            color: #cbd5e1;
            font-size: 0.68rem;
            font-weight: 600;
            padding: 0.42rem 2rem;
        }

        .municipal-strip-inner {
            max-width: 1220px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .section-wrap {
            max-width: 1220px;
            margin: 0 auto;
            padding: 3.5rem 1.5rem;
        }

        /* Hero */
        .hero-grid {
            display: grid;
            grid-template-columns: 1.25fr 1fr;
            gap: 2.5rem;
            align-items: center;
        }

        .hero-title {
            font-size: 2.85rem;
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -1px;
            color: #0f172a;
            margin: 0.85rem 0 1.1rem;
        }

        .btn-black {
            background: #050505;
            color: #ffffff;
            padding: 0.78rem 1.35rem;
            border-radius: 9px;
            font-size: 0.84rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }

        .btn-light {
            background: #ffffff;
            color: #0f172a;
            border: 1px solid #cbd5e1;
            padding: 0.78rem 1.25rem;
            border-radius: 9px;
            font-size: 0.84rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .hero-mini-badges {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .hero-mini-card {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.65rem 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        /* Portales (3 Tarjetas) */
        .portals-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.35rem;
            margin-top: 1.5rem;
        }

        .portal-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 1.65rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        }

        .portal-check-list {
            list-style: none;
            margin: 1.15rem 0 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.45rem;
            font-size: 0.75rem;
            color: #334155;
            font-weight: 500;
        }

        /* Cotizador Oficial */
        .quoter-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 2rem;
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 2rem;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        }

        /* 4 Pilares */
        .pillars-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.15rem;
            margin-top: 2rem;
        }

        .pillar-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.35rem;
        }

        @media (max-width: 1024px) {
            .hero-grid, .portals-grid, .quoter-card, .pillars-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- NAVBAR SUPERIOR (Imagen 3) -->
    <header class="landing-nav">
        <div class="landing-nav-inner">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 0.55rem; text-decoration: none; color: #0f172a;">
                    <div style="width: 34px; height: 34px; border-radius: 8px; background: #0f172a; color: #fbbf24; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                        <i class="bi bi-taxi-front-fill"></i>
                    </div>
                    <div>
                        <div style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.05rem; line-height: 1;">TaxiUbaté</div>
                        <div style="font-size: 0.54rem; font-weight: 700; color: #64748b; letter-spacing: 0.5px;">PROVINCIA DEL VALLE DE UBATÉ</div>
                    </div>
                </a>

                <span style="background: #f1f5f9; border: 1px solid #e2e8f0; font-size: 0.65rem; font-weight: 700; color: #334155; padding: 0.25rem 0.65rem; border-radius: 6px;">
                    <i class="bi bi-shield-check" style="color: #047857;"></i> Reglamentado Dec. 014 - Alcaldía
                </span>
            </div>

            <nav style="display: flex; align-items: center; gap: 1.15rem; font-size: 0.78rem; font-weight: 600; color: #475569;">
                <a href="#inicio" style="background: #0f172a; color: #fff; padding: 0.35rem 0.75rem; border-radius: 6px; text-decoration: none;">Inicio</a>
                <a href="#cotizador" style="color: #475569; text-decoration: none;">Tarifas Oficiales</a>
                <a href="#portales" style="color: #475569; text-decoration: none;">Padrón de Conductores</a>
                <a href="#garantias" style="color: #475569; text-decoration: none;">Soporte 24/7</a>
            </nav>

            <div style="display: flex; align-items: center; gap: 0.55rem;">
                <a href="tel:123" style="background: #dc2626; color: #fff; font-size: 0.7rem; font-weight: 800; padding: 0.42rem 0.75rem; border-radius: 7px; text-decoration: none;">
                    🚨 SOS 123 / 855-3000
                </a>
                <a href="{{ route('login', ['role' => 'conductor']) }}" style="background: #050505; color: #fff; font-size: 0.72rem; font-weight: 700; padding: 0.42rem 0.8rem; border-radius: 7px; text-decoration: none;">
                    Portal Conductor
                </a>
                <a href="{{ route('login') }}" style="width: 32px; height: 32px; border-radius: 50%; background: #0f172a; color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.8rem;">
                    <i class="bi bi-person-fill"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- FRANJA OFICIAL MUNICIPAL -->
    <div class="municipal-strip">
        <div class="municipal-strip-inner">
            <span><span style="color: #10b981;">●</span> SERVICIO MUNICIPAL OFICIAL • VILLA DE SAN DIEGO DE UBATÉ</span>
            <div style="display: flex; gap: 1.25rem;">
                <span><i class="bi bi-award" style="color: #f59e0b;"></i> Resolución STT N° 042/2024</span>
                <span><i class="bi bi-shield-check" style="color: #10b981;"></i> RUNT & Policía Nacional Enlazados</span>
            </div>
        </div>
    </div>

    <!-- 1. HERO SECTION -->
    <section class="section-wrap" id="inicio">
        <div class="hero-grid">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <span style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; font-size: 0.68rem; font-weight: 700; padding: 0.22rem 0.65rem; border-radius: 99px;">
                        <i class="bi bi-taxi-front"></i> Flota Local Municipal
                    </span>
                    <span style="background: #f1f5f9; color: #334155; font-size: 0.68rem; font-weight: 700; padding: 0.22rem 0.65rem; border-radius: 99px;">
                        Cero Tarifas Dinámicas
                    </span>
                </div>

                <h1 class="hero-title">
                    El transporte formal y seguro de la <span style="color: #92400e; text-decoration: underline; text-decoration-color: #fde68a;">Capital Lechera</span> de Colombia.
                </h1>

                <p style="font-size: 0.92rem; color: #475569; max-width: 540px; margin-bottom: 1.65rem;">
                    Tarifas transparentes fijadas bajo decreto municipal, sin recargos dinámicos en horas pico ni lluvia. Unidades auditadas, geolocalización satelital continua y respaldo directo de las empresas habilitadas en Ubaté y sus 24 veredas.
                </p>

                <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                    <a href="{{ route('login') }}" class="btn-black">
                        <span>Ingresar a mi Cuenta</span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ route('register') }}" class="btn-light">
                        <i class="bi bi-person-plus"></i>
                        <span>Registrarse como Pasajero o Conductor</span>
                    </a>
                </div>

                <div class="hero-mini-badges">
                    <div class="hero-mini-card">
                        <i class="bi bi-receipt" style="color: #b45309; font-size: 1.1rem;"></i>
                        <div>
                            <div style="font-size: 0.72rem; font-weight: 800; color: #0f172a;">Tarifas Oficiales</div>
                            <div style="font-size: 0.64rem; color: #64748b;">Decreto STT N° 014 / 2024</div>
                        </div>
                    </div>
                    <div class="hero-mini-card">
                        <i class="bi bi-shield-check" style="color: #047857; font-size: 1.1rem;"></i>
                        <div>
                            <div style="font-size: 0.72rem; font-weight: 800; color: #0f172a;">Monitoreo 24/7</div>
                            <div style="font-size: 0.64rem; color: #64748b;">Estación de Policía Ubaté</div>
                        </div>
                    </div>
                    <div class="hero-mini-card">
                        <i class="bi bi-signpost-split" style="color: #2563eb; font-size: 1.1rem;"></i>
                        <div>
                            <div style="font-size: 0.72rem; font-weight: 800; color: #0f172a;">24 Veredas</div>
                            <div style="font-size: 0.64rem; color: #64748b;">Cobertura rural garantizada</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Derecha: Central Radial Ubaté (Datos Reales BD) -->
            @php
                $realActiveDriversCount = \App\Models\User::where('role', 'conductor')->where('is_available', true)->count();
                $realLastTrip = \App\Models\Trip::with('driver')->latest()->first();
            @endphp
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 18px; padding: 1.25rem; box-shadow: 0 12px 32px rgba(15, 23, 42, 0.07);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem; font-size: 0.68rem; font-weight: 800;">
                    <span style="color: #0f172a;"><span style="color: #f59e0b;">●</span> CENTRAL RADIAL UBATÉ</span>
                    <span style="color: #047857;">{{ $realActiveDriversCount }} TAXIS ACTIVOS EN BD</span>
                </div>

                <div style="position: relative; height: 175px; background: linear-gradient(135deg, #d1fae5 0%, #bae6fd 100%); border-radius: 12px; border: 1px solid #cbd5e1; margin-bottom: 0.9rem; overflow: hidden;">
                    <svg viewBox="0 0 400 175" style="width: 100%; height: 100%;">
                        <path d="M 35 140 Q 180 95 340 45" fill="none" stroke="#0f172a" stroke-width="2.5" stroke-dasharray="4 4" />
                        <circle cx="190" cy="88" r="7" fill="#0f172a" stroke="#fff" stroke-width="2" />
                    </svg>
                    <div style="position: absolute; top: 10px; left: 10px; background: rgba(255,255,255,0.94); padding: 0.2rem 0.55rem; border-radius: 6px; font-size: 0.64rem; font-weight: 700;">
                        ⊙ Parque Los Libertadores • {{ $realActiveDriversCount }} Libres ahora
                    </div>
                </div>

                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 11px; padding: 0.85rem;">
                    @if($realLastTrip)
                        <div style="display: flex; justify-content: space-between; font-size: 0.66rem; color: #64748b; margin-bottom: 0.4rem;">
                            <strong style="color: #0f172a;">● Último Servicio Registrado (#TX-{{ $realLastTrip->id }})</strong>
                            <span>{{ $realLastTrip->created_at ? $realLastTrip->created_at->diffForHumans() : 'Reciente' }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.74rem; margin-bottom: 0.55rem; gap: 0.5rem;">
                            <div>
                                <div style="font-size: 0.62rem; color: #64748b;">Origen:</div>
                                <strong style="color: #0f172a;">{{ $realLastTrip->origin_address }}</strong>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 0.62rem; color: #64748b;">Destino:</div>
                                <strong style="color: #0f172a;">{{ $realLastTrip->destination_address }}</strong>
                            </div>
                        </div>
                        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.45rem 0.65rem; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.68rem; color: #64748b;">Tarifa Registrada ({{ $realLastTrip->distance_km }} km)</span>
                            <strong style="font-family: 'Outfit', sans-serif; font-size: 0.95rem; color: #92400e;">${{ number_format($realLastTrip->estimated_fare, 0, ',', '.') }} COP</strong>
                        </div>
                    @else
                        <div style="text-align: center; padding: 0.65rem; font-size: 0.74rem; color: #64748b;">
                            <strong>0 Servicios Registrados</strong><br>
                            Aún no hay viajes registrados en la base de datos.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- 2. SELECCIONA TU PORTAL DE ACCESO (3 TARJETAS) -->
    <section class="section-wrap" id="portales" style="padding-top: 1rem;">
        <div style="font-size: 0.64rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px;">
            ARQUITECTURA UNIFICADA
        </div>
        <h2 style="font-size: 1.65rem; font-weight: 800; color: #0f172a; margin-top: 0.15rem;">
            Selecciona tu Portal de Acceso
        </h2>
        <p style="font-size: 0.82rem; color: #64748b; margin-top: 0.2rem;">
            Entornos optimizados para usuarios civiles, conductores habilitados de transporte y supervisores de la Secretaría de Tránsito Municipal.
        </p>

        <div class="portals-grid">
            <!-- Portal Pasajero -->
            <div class="portal-card">
                <div>
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #fffbeb; color: #b45309; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; margin-bottom: 1rem;">
                        <i class="bi bi-person-walking"></i>
                    </div>
                    <div style="font-size: 0.65rem; font-weight: 700; color: #64748b;">Ciudadanos y Turistas</div>
                    <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0.15rem 0 0.55rem;">Portal Pasajero</h3>
                    <p style="font-size: 0.76rem; color: #64748b; line-height: 1.45;">
                        Solicitud de vehículo en 1 clic y expresos veredales. Tarifa calculada con odómetro oficial, código de seguridad PIN de abordaje y pago en efectivo o QR local (Nequi / DaviPlata).
                    </p>
                    <ul class="portal-check-list">
                        <li><i class="bi bi-check-circle" style="color: #047857;"></i> Sin recargos dinámicos ni comisiones</li>
                        <li><i class="bi bi-check-circle" style="color: #047857;"></i> Historial de placas y contacto para reclamos</li>
                        <li><i class="bi bi-check-circle" style="color: #047857;"></i> Envío de ruta en vivo a familiares</li>
                    </ul>
                </div>
                <a href="{{ route('login', ['role' => 'pasajero']) }}" class="btn-black" style="justify-content: center;">
                    <span>Acceder como Pasajero</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Portal Conductor -->
            <div class="portal-card" style="border-color: #fde68a;">
                <div>
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; color: #0f172a; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; margin-bottom: 1rem;">
                        <i class="bi bi-taxi-front-fill"></i>
                    </div>
                    <div style="font-size: 0.65rem; font-weight: 700; color: #64748b;">Cootransubaté & TaxUbaté</div>
                    <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0.15rem 0 0.55rem;">Portal Conductor</h3>
                    <p style="font-size: 0.76rem; color: #64748b; line-height: 1.45;">
                        0% de comisiones extranjeras o multinacionales. Asignación justa por georreferenciación de cuadrante, planilla de viaje electrónica y liquidación directa con cooperativas ubatenses.
                    </p>
                    <ul class="portal-check-list">
                        <li><i class="bi bi-check-circle" style="color: #b45309;"></i> Asignación radial y digital simultánea</li>
                        <li><i class="bi bi-check-circle" style="color: #b45309;"></i> Alertas de SOAT y Técnico-Mecánica RUNT</li>
                        <li><i class="bi bi-check-circle" style="color: #b45309;"></i> Botón de pánico silencioso policial</li>
                    </ul>
                </div>
                <a href="{{ route('login', ['role' => 'conductor']) }}" class="btn-black" style="background: #92400e; justify-content: center;">
                    <span>Acceder como Conductor</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Central de Control STT -->
            <div class="portal-card">
                <div>
                    <div style="width: 40px; height: 40px; border-radius: 10px; background: #eff6ff; color: #1d4ed8; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; margin-bottom: 1rem;">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div style="font-size: 0.65rem; font-weight: 700; color: #64748b;">Tránsito y Monitoreo</div>
                    <h3 style="font-size: 1.2rem; font-weight: 800; color: #0f172a; margin: 0.15rem 0 0.55rem;">Central de Control STT</h3>
                    <p style="font-size: 0.76rem; color: #64748b; line-height: 1.45;">
                        Módulo exclusivo de auditoría para la Secretaría de Tránsito y despachadores autorizados. Supervisión satelital en tiempo real, control de cupos y trazabilidad forense de incidentes.
                    </p>
                    <ul class="portal-check-list">
                        <li><i class="bi bi-check-circle" style="color: #1d4ed8;"></i> Mapa de calor y demanda provincial</li>
                        <li><i class="bi bi-check-circle" style="color: #1d4ed8;"></i> Censo activo de vehículos autorizados</li>
                        <li><i class="bi bi-check-circle" style="color: #1d4ed8;"></i> Auditoría de tarifas y límites de velocidad</li>
                    </ul>
                </div>
                <a href="{{ route('login', ['role' => 'admin']) }}" class="btn-black" style="background: #0f172a; justify-content: center;">
                    <span>Acceder a Central STT</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 3. COTIZADOR OFICIAL DE CARRERA -->
    <section class="section-wrap" id="cotizador" style="padding-top: 1rem;">
        <div class="quoter-card">
            <div>
                <div style="font-size: 0.64rem; font-weight: 800; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px;">
                    <i class="bi bi-calculator"></i> TARIFA REGULADA Y FIJA
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0.2rem 0 0.4rem;">
                    Cotizador Oficial de Carrera
                </h3>
                <p style="font-size: 0.78rem; color: #64748b; margin-bottom: 1.25rem;">
                    Consulta con precisión legal el valor exacto de tu trayecto en el perímetro urbano o hacia cualquiera de las veredas del municipio. Sin sorpresas al finalizar el viaje.
                </p>

                <div style="margin-bottom: 0.9rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem;">Punto de Origen</label>
                    <select style="width: 100%; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.65rem; font-size: 0.8rem; font-weight: 600; color: #0f172a;">
                        <option>Parque Principal Los Libertadores (Casco Urbano)</option>
                        <option>Terminal de Transportes de Ubaté</option>
                        <option>Hospital El Salvador de Ubaté</option>
                    </select>
                </div>

                <div style="margin-bottom: 0.9rem;">
                    <label style="display: block; font-size: 0.72rem; font-weight: 700; color: #334155; margin-bottom: 0.35rem;">Destino Previsto</label>
                    <select id="landingDestSelect" onchange="updateLandingQuote()" style="width: 100%; background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.65rem; font-size: 0.8rem; font-weight: 600; color: #0f172a;">
                        <option value="6000">Carrera Urbana Estándar (Barrio Santa Bárbara / Centro)</option>
                        <option value="10700">Vereda Sucunchoque - Sector El Molino</option>
                        <option value="14500">Vereda San Cayetano / Palogordo</option>
                        <option value="25000">Sutatausa / Carmen de Carupa (Provincial)</option>
                    </select>
                </div>

                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.74rem; color: #475569; cursor: pointer;">
                    <input type="checkbox" id="landingNightCheck" onchange="updateLandingQuote()" style="accent-color: #0f172a;">
                    <span>Aplica recargo nocturno / dominical o festivo (+$1.000 COP por decreto)</span>
                </label>
            </div>

            <div style="background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 14px; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <div>
                            <div style="font-size: 0.62rem; font-weight: 800; color: #64748b; text-transform: uppercase;">TARIFA ESTIMADA</div>
                            <div id="landingTotalVal" style="font-family: 'Outfit', sans-serif; font-size: 2.15rem; font-weight: 800; color: #92400e; line-height: 1.05;">
                                $6.000 COP
                            </div>
                        </div>
                        <span style="background: #fef3c7; color: #b45309; font-size: 0.64rem; font-weight: 800; padding: 0.22rem 0.55rem; border-radius: 5px; text-align: right;">
                            URBANA REGULADA<br><span style="color: #475569; font-weight: 600;">Tiempo est: 4-6 min</span>
                        </span>
                    </div>

                    <div style="font-size: 0.74rem; color: #475569; display: flex; flex-direction: column; gap: 0.35rem; padding-bottom: 0.85rem; border-bottom: 1px solid #e2e8f0;">
                        <div style="display: flex; justify-content: space-between;"><span>Banderazo base reglamentario:</span><strong style="color: #0f172a;">$3.800 COP</strong></div>
                        <div style="display: flex; justify-content: space-between;"><span>Distancia en casco urbano:</span><strong style="color: #0f172a;">12 unidades ($2.200)</strong></div>
                        <div style="display: flex; justify-content: space-between;"><span>Recargo veredal (trocha / ascenso):</span><strong id="landingRuralVal" style="color: #0f172a;">$0 COP</strong></div>
                        <div style="display: flex; justify-content: space-between;"><span>Recargo nocturno / dominical:</span><strong id="landingNightVal" style="color: #0f172a;">$0 COP</strong></div>
                    </div>
                </div>

                <a href="{{ route('login', ['role' => 'pasajero']) }}" class="btn-black" style="justify-content: center; margin-top: 1rem;">
                    <i class="bi bi-send-fill"></i> Pedir Taxi con este Valor Fijado
                </a>
            </div>
        </div>
    </section>

    <!-- 4. ¿POR QUÉ VIAJAR EN TAXIUBATÉ? -->
    <section class="section-wrap" id="garantias" style="padding-top: 0.5rem;">
        <div style="text-align: center; max-width: 600px; margin: 0 auto;">
            <div style="font-size: 0.64rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.6px;">
                GARANTÍA DE SERVICIO PÚBLICO
            </div>
            <h2 style="font-size: 1.65rem; font-weight: 800; color: #0f172a; margin-top: 0.2rem;">
                ¿Por qué viajar en TaxiUbaté?
            </h2>
            <p style="font-size: 0.8rem; color: #64748b; margin-top: 0.25rem;">
                Construimos una plataforma con tecnología de punta concebida para salvaguardar a los usuarios y dignificar el oficio de nuestros conductores provinciales.
            </p>
        </div>

        <div class="pillars-grid">
            <div class="pillar-card">
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #fffbeb; color: #b45309; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;">
                    <i class="bi bi-hammer"></i>
                </div>
                <h4 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 0.35rem;">Tarifa Regulada y Justa</h4>
                <p style="font-size: 0.72rem; color: #64748b; line-height: 1.45;">
                    Sin algoritmos ni multiplicadores de precio. Las tarifas las estipula la Secretaría de Tránsito protegiendo el bolsillo familiar del sector agropecuario y estudiantil.
                </p>
            </div>

            <div class="pillar-card">
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #eff6ff; color: #1d4ed8; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h4 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 0.35rem;">Conductores Locales Certificados</h4>
                <p style="font-size: 0.72rem; color: #64748b; line-height: 1.45;">
                    Conductores reconocidos de la provincia con hoja de vida verificada, pruebas toxicológicas periódicas y antecedentes judiciales limpios ante la Policía Nacional.
                </p>
            </div>

            <div class="pillar-card">
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;">
                    <i class="bi bi-broadcast"></i>
                </div>
                <h4 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 0.35rem;">Botón SOS & Respaldo Radial</h4>
                <p style="font-size: 0.72rem; color: #64748b; line-height: 1.45;">
                    Alerta enlazada instantáneamente con la Estación de Policía de Ubaté y la red comunitaria de taxistas ante cualquier desviación anómala en la ruta.
                </p>
            </div>

            <div class="pillar-card">
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #f0fdf4; color: #047857; display: flex; align-items: center; justify-content: center; margin-bottom: 0.75rem;">
                    <i class="bi bi-map"></i>
                </div>
                <h4 style="font-size: 0.9rem; font-weight: 800; margin-bottom: 0.35rem;">Cobertura Integral Veredal</h4>
                <p style="font-size: 0.72rem; color: #64748b; line-height: 1.45;">
                    Llegamos a fincas, hatos lecheros y caminos de herradura de las 24 veredas de Ubaté. Nuestros conductores conocen los atajos y no cancelan servicios rurales.
                </p>
            </div>
        </div>
    </section>

    <!-- 5. BANNER OSCURO APP / WHATSAPP + FOOTER -->
    <section style="background: #0f172a; color: #ffffff; padding: 3.5rem 2rem; margin-top: 1.5rem;">
        <div style="max-width: 1220px; margin: 0 auto; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 2rem;">
            <div style="max-width: 540px;">
                <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; font-size: 0.65rem; font-weight: 800; padding: 0.22rem 0.6rem; border-radius: 99px;">
                    ACCESIBILIDAD MULTICANAL
                </span>
                <h2 style="font-size: 2rem; font-weight: 800; line-height: 1.15; margin: 0.65rem 0;">
                    Pide tu taxi desde la App o escríbenos directamente al WhatsApp
                </h2>
                <p style="font-size: 0.82rem; color: #94a3b8; margin-bottom: 1.35rem;">
                    Descarga TaxiUbaté para Android e iOS, o utiliza nuestro bot municipal de WhatsApp si tienes baja señal en veredas sin consumir tus datos móviles.
                </p>
                <div style="display: flex; gap: 0.65rem; flex-wrap: wrap;">
                    <a href="{{ route('login') }}" class="btn-light" style="padding: 0.55rem 1rem; font-size: 0.76rem;">Google Play</a>
                    <a href="{{ route('login') }}" class="btn-light" style="padding: 0.55rem 1rem; font-size: 0.76rem;">Apple App Store</a>
                    <a href="{{ route('login') }}" style="background: #10b981; color: #050505; padding: 0.55rem 1.1rem; border-radius: 8px; font-size: 0.76rem; font-weight: 800; text-decoration: none;">
                        <i class="bi bi-whatsapp"></i> WhatsApp Despacho
                    </a>
                </div>
            </div>

            <div style="background: #ffffff; color: #0f172a; border-radius: 16px; padding: 1.25rem; width: 320px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                    <strong style="font-size: 0.78rem;"><i class="bi bi-taxi-front"></i> TaxiUbaté Móvil</strong>
                    <span style="background: #dcfce7; color: #15803d; font-size: 0.62rem; font-weight: 800; padding: 0.14rem 0.45rem; border-radius: 4px;">● En Camino</span>
                </div>
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 0.65rem; margin-bottom: 0.65rem; font-size: 0.74rem;">
                    <strong>Unidad Asignada: #038</strong>
                    <div style="font-size: 0.68rem; color: #64748b;">Wilson Benavides • TKS-912 • ☆ 4.9</div>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.72rem; margin-bottom: 0.75rem;">
                    <span>Código PIN de Abordaje:</span>
                    <strong style="font-family: 'Outfit', sans-serif;">8492</strong>
                </div>
                <a href="{{ route('login') }}" class="btn-black" style="width: 100%; justify-content: center; padding: 0.55rem; font-size: 0.75rem;">
                    Compartir Trayecto en Vivo
                </a>
            </div>
        </div>
    </section>

    <footer style="background: #ffffff; border-top: 1px solid #e2e8f0; padding: 1.5rem 2rem; font-size: 0.72rem; color: #64748b;">
        <div style="max-width: 1220px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <strong style="color: #0f172a;">TaxiUbaté Digital</strong> — Plataforma Oficial de Supervisión y Despacho de Transporte Público Individual en el Municipio de Villa de San Diego de Ubaté, Cundinamarca.
            </div>
            <div>© {{ date('Y') }} TaxiUbaté Oficial. Todos los derechos reservados.</div>
        </div>
    </footer>

    <script>
        function updateLandingQuote() {
            const base = parseInt(document.getElementById('landingDestSelect').value, 10);
            const night = document.getElementById('landingNightCheck').checked ? 1000 : 0;
            const rural = Math.max(0, base - 6000);
            const total = base + night;
            document.getElementById('landingRuralVal').textContent = '$' + rural.toLocaleString('es-CO') + ' COP';
            document.getElementById('landingNightVal').textContent = '$' + night.toLocaleString('es-CO') + ' COP';
            document.getElementById('landingTotalVal').textContent = '$' + total.toLocaleString('es-CO') + ' COP';
        }
    </script>
</body>
</html>
