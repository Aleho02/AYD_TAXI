<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Movilidad Provincial') - TaxiUbaté</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha384-XGjxtQfXaH2tnPFa9x+ruJTuLE3Aa6LhHSWRr1XeTyhezb4abCG4ccI5AkVDxqC+" crossorigin="anonymous">

    <style>
        :root {
            --primary: #ea580c;
            --primary-hover: #d97706;
            --primary-light: #fff7ed;
            --amber: #f59e0b;
            --navy: #0f172a;
            --navy-light: #1e293b;
            --bg-body: #f4f6f9;
            --bg-sidebar: #f8fafc;
            --bg-card: #ffffff;
            --bg-card-hover: #f8fafc;
            --text-main: #0f172a;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --success: #10b981;
            --success-bg: #ecfdf5;
            --success-text: #047857;
            --warning: #f59e0b;
            --warning-bg: #fffbeb;
            --warning-text: #b45309;
            --danger: #ef4444;
            --danger-bg: #fef2f2;
            --danger-text: #b91c1c;
            --info: #2563eb;
            --info-bg: #eff6ff;
            --info-text: #1d4ed8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        body.has-sidebar {
            flex-direction: row;
        }

        h1, h2, h3, h4, h5, .brand-font {
            font-family: 'Outfit', sans-serif;
            color: var(--navy);
        }

        /* ====== SIDEBAR SHELL (ADMIN & CONDUCTOR) ====== */
        .admin-sidebar {
            width: 256px;
            min-width: 256px;
            background-color: #ffffff;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 1.15rem 0.9rem;
            z-index: 120;
            user-select: none;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.2rem 0.35rem 0.85rem;
            text-decoration: none;
            color: var(--navy);
        }

        .sidebar-brand-left {
            display: flex;
            align-items: center;
            gap: 0.55rem;
        }

        .sidebar-logo-mark {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: var(--navy);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.05rem;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.15);
        }

        .sidebar-brand-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.05rem;
            letter-spacing: -0.3px;
            line-height: 1.1;
            color: var(--navy);
        }

        .sidebar-brand-sub {
            font-size: 0.58rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            display: block;
            margin-top: 2px;
        }

        .version-badge {
            font-size: 0.62rem;
            font-weight: 700;
            background: #f1f5f9;
            color: #475569;
            padding: 0.15rem 0.42rem;
            border-radius: 5px;
            border: 1px solid #e2e8f0;
        }

        .uptime-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background-color: #e6f7ef;
            border: 1px solid #bbf7d0;
            color: #047857;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.32rem 0.7rem;
            border-radius: 9999px;
            margin: 0.15rem 0.35rem 1.25rem;
            width: fit-content;
        }

        .uptime-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }

        .role-active-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.65rem 0.75rem;
            margin: 0.1rem 0.2rem 1.1rem;
        }

        .sidebar-section-label {
            font-size: 0.62rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #94a3b8;
            padding: 0.55rem 0.65rem 0.3rem;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            flex: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.62rem 0.8rem;
            border-radius: 9px;
            text-decoration: none;
            color: #475569;
            font-size: 0.82rem;
            font-weight: 500;
            transition: all 0.18s ease;
        }

        .sidebar-link i {
            font-size: 0.96rem;
            color: #64748b;
            transition: color 0.18s ease;
        }

        .sidebar-link:hover {
            background-color: #f1f5f9;
            color: var(--navy);
        }

        .sidebar-link.active {
            background-color: var(--navy);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.16);
        }

        .sidebar-link.active i {
            color: #fbbf24;
        }

        .sidebar-link.active-soft {
            background-color: #f1f5f9;
            color: var(--navy);
            font-weight: 700;
        }

        .sidebar-link.active-soft i {
            color: var(--navy);
        }

        .sidebar-subnav {
            margin-left: 1.65rem;
            padding-left: 0.75rem;
            border-left: 2px solid #cbd5e1;
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
            margin-top: 0.15rem;
            margin-bottom: 0.35rem;
        }

        .sidebar-sublink {
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            padding: 0.28rem 0.55rem;
            border-radius: 6px;
            transition: all 0.15s;
        }

        .sidebar-sublink:hover, .sidebar-sublink.active {
            color: var(--primary);
            background: rgba(234, 88, 12, 0.08);
        }

        .sidebar-footer {
            margin-top: auto;
            padding-top: 0.75rem;
        }

        .sos-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 11px;
            padding: 0.8rem;
            margin-bottom: 0.5rem;
        }

        .sos-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.3rem;
        }

        .sos-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.68rem;
            font-weight: 800;
            color: #dc2626;
            letter-spacing: 0.3px;
        }

        .sos-phone {
            font-family: 'Outfit', sans-serif;
            font-size: 0.76rem;
            font-weight: 800;
            color: var(--navy);
        }

        .sos-desc {
            font-size: 0.69rem;
            color: var(--text-muted);
            line-height: 1.35;
        }

        .transit-report-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.45rem 0.6rem;
            text-decoration: none;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 8px;
        }

        /* ====== MAIN WRAPPER & TOPBAR ====== */
        .admin-main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .admin-topbar {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border-color);
            height: 64px;
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            flex-wrap: wrap;
        }

        .topbar-search {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.4rem 0.75rem;
            width: 280px;
        }

        .topbar-search i {
            color: #64748b;
            font-size: 0.8rem;
        }

        .topbar-search input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.78rem;
            color: var(--navy);
            width: 100%;
        }

        .topbar-kbd {
            font-size: 0.64rem;
            font-weight: 700;
            color: #64748b;
            background: #e2e8f0;
            padding: 0.1rem 0.35rem;
            border-radius: 4px;
        }

        .topbar-pills {
            display: flex;
            align-items: center;
            gap: 0.45rem;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.38rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 0.3rem 0.65rem;
            border-radius: 6px;
            font-size: 0.74rem;
            font-weight: 600;
            color: #334155;
            white-space: nowrap;
        }

        .chip-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 0.95rem;
        }

        .topbar-location {
            text-align: right;
            line-height: 1.2;
        }

        .topbar-location-city {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--navy);
        }

        .topbar-location-tz {
            font-size: 0.67rem;
            color: var(--text-muted);
        }

        .topbar-bell {
            position: relative;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            cursor: pointer;
        }

        .topbar-bell-dot {
            position: absolute;
            top: 5px;
            right: 6px;
            width: 7px;
            height: 7px;
            background: #ef4444;
            border-radius: 50%;
            border: 1.5px solid #fff;
        }

        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding-left: 0.75rem;
            border-left: 1px solid #e2e8f0;
        }

        .topbar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--navy);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .topbar-user-info {
            line-height: 1.2;
        }

        .topbar-user-name {
            font-size: 0.76rem;
            font-weight: 700;
            color: var(--navy);
        }

        .topbar-user-role {
            font-size: 0.66rem;
            color: var(--text-muted);
        }

        .btn-logout {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 0.35rem 0.65rem;
            border-radius: 7px;
            cursor: pointer;
            font-size: 0.74rem;
            font-weight: 600;
            transition: all 0.15s;
        }

        .btn-logout:hover {
            color: #dc2626;
            border-color: #fca5a5;
            background: #fef2f2;
        }

        .admin-content {
            padding: 1.5rem 1.85rem 2.5rem;
            max-width: 1440px;
            width: 100%;
            margin: 0 auto;
            flex: 1;
        }

        /* ====== PASAJERO TOPBAR SHELL (Imagen 2) ====== */
        .pasajero-navbar {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            height: 62px;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .pasajero-nav-left {
            display: flex;
            align-items: center;
            gap: 1.75rem;
        }

        .pasajero-nav-links {
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .pasajero-nav-link {
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 600;
            color: #475569;
            padding: 0.42rem 0.85rem;
            border-radius: 7px;
            transition: all 0.15s;
        }

        .pasajero-nav-link:hover {
            color: var(--navy);
            background: #f1f5f9;
        }

        .pasajero-nav-link.active {
            background: var(--navy);
            color: #ffffff;
        }

        /* ====== COMMON UI ELEMENTS ====== */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1.35rem 1.5rem;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            margin-bottom: 1.35rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.15rem;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--navy);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.52rem 1rem;
            font-size: 0.82rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.18s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(234, 88, 12, 0.22);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #ea580c, #c2410c);
            transform: translateY(-1px);
        }

        .btn-navy {
            background-color: var(--navy);
            color: #ffffff;
        }

        .btn-navy:hover {
            background-color: #1e293b;
        }

        .btn-secondary, .btn-outline {
            background-color: #ffffff;
            color: #334155;
            border: 1px solid #cbd5e1;
        }

        .btn-secondary:hover, .btn-outline:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
            color: var(--navy);
        }

        .btn-danger {
            background-color: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .btn-danger:hover {
            background-color: #fee2e2;
        }

        .btn-sm {
            padding: 0.35rem 0.7rem;
            font-size: 0.76rem;
        }

        .brand-badge {
            background: #fff7ed;
            color: #ea580c;
            border: 1px solid #fed7aa;
            padding: 0.2rem 0.55rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .form-group {
            margin-bottom: 1.1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.38rem;
            font-size: 0.78rem;
            font-weight: 600;
            color: #334155;
        }

        .form-control {
            width: 100%;
            padding: 0.62rem 0.85rem;
            border-radius: 8px;
            background-color: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: var(--navy);
            font-size: 0.86rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            background-color: #ffffff;
            border-color: var(--navy);
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
        }

        .invalid-feedback {
            color: #dc2626;
            font-size: 0.76rem;
            margin-top: 0.3rem;
            font-weight: 600;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: #f8fafc;
            color: #64748b;
            padding: 0.75rem 1rem;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 0.9rem 1rem;
            font-size: 0.83rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            color: #1e293b;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.22rem 0.6rem;
            border-radius: 6px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .status-success { background: #dcfce7; color: #15803d; }
        .status-warning { background: #fef3c7; color: #b45309; }
        .status-info { background: #dbeafe; color: #1d4ed8; }
        .status-danger { background: #fee2e2; color: #b91c1c; }

        .role-tag {
            padding: 0.22rem 0.6rem;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .role-admin { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .role-conductor { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .role-pasajero { background-color: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }

        .alert {
            padding: 0.85rem 1.15rem;
            border-radius: 10px;
            margin-bottom: 1.25rem;
            font-size: 0.85rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e2e8f0;
            background-color: #0f172a;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            font-size: 0.9rem;
        }

        .plate-badge {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(180deg, #f59e0b 0%, #ea580c 100%);
            color: #0f172a;
            border-radius: 6px;
            padding: 0.22rem 0.55rem;
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 0.82rem;
            border: 1px solid #d97706;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.35);
            gap: 0.35rem;
        }

        .plate-badge .plate-col {
            font-size: 0.58rem;
            font-weight: 800;
            opacity: 0.85;
            border-right: 1px solid rgba(15, 23, 42, 0.25);
            padding-right: 0.3rem;
        }

        @media (max-width: 1024px) {
            .admin-sidebar {
                width: 220px;
                min-width: 220px;
            }
            .topbar-pills {
                display: none;
            }
        }
    </style>
</head>
<body class="{{ auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isConductor()) ? 'has-sidebar' : '' }}">

    @if(auth()->check() && auth()->user()->isAdmin())
        <!-- ================= 1. SHELL ADMINISTRADOR (CENTRAL DE CONTROL) ================= -->
        <aside class="admin-sidebar" style="background-color: #f1f5f9;">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <div class="sidebar-brand-left">
                    <div class="sidebar-logo-mark" style="color: #fbbf24;">
                        <i class="bi bi-taxi-front-fill"></i>
                    </div>
                    <div>
                        <div class="sidebar-brand-title">TaxiUbaté</div>
                        <span class="sidebar-brand-sub">CENTRAL DE CONTROL</span>
                    </div>
                </div>
            </a>

            <div class="uptime-pill">
                <span class="uptime-dot"></span>
                <span>En Línea - 99.8% Uptime</span>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-broadcast-pin"></i>
                    <span>Monitoreo y Despacho</span>
                </a>

                <a href="{{ route('admin.drivers.index') }}" class="sidebar-link {{ request()->routeIs('admin.drivers.*') || request()->routeIs('admin.fleet.*') ? 'active' : '' }}">
                    <i class="bi bi-car-front-fill"></i>
                    <span>Gestión de Flota & Conductores</span>
                </a>

                @if(request()->routeIs('admin.drivers.*') || request()->routeIs('admin.fleet.*'))
                    <div class="sidebar-subnav">
                        <a href="{{ route('admin.drivers.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                            • Padrón de Conductores
                        </a>
                        <a href="{{ route('admin.fleet.index') }}" class="sidebar-sublink {{ request()->routeIs('admin.fleet.*') ? 'active' : '' }}">
                            • Parque Automotor (Flota)
                        </a>
                    </div>
                @endif

                <a href="{{ route('admin.audit') }}" class="sidebar-link {{ request()->routeIs('admin.audit') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i>
                    <span>Trazabilidad & Auditoría</span>
                </a>

                <a href="{{ route('admin.analytics') }}" class="sidebar-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>Analítica y Demanda</span>
                </a>

                <a href="{{ route('admin.tariffs') }}" class="sidebar-link {{ request()->routeIs('admin.tariffs') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    <span>Tarifas y Zonas Veredales</span>
                </a>

                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock"></i>
                    <span>Configuración & API Tokens</span>
                </a>

                <a href="{{ route('movil.index') }}" class="sidebar-link" style="margin-top: 0.35rem; background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; font-weight: 700;">
                    <i class="bi bi-phone-fill" style="color: #ea580c;"></i>
                    <span>App Móvil (Celular)</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sos-box" style="background: #ffffff;">
                    <div class="sos-header">
                        <span class="sos-badge"><i class="bi bi-exclamation-octagon-fill"></i> SOS DESPACHO</span>
                        <span class="sos-phone">123 / 725-3344</span>
                    </div>
                    <p class="sos-desc">
                        Línea directa interconectada Policía Municipal Ubaté
                    </p>
                </div>

                <a href="{{ route('admin.audit') }}" class="transit-report-link">
                    <span><i class="bi bi-file-earmark-text"></i> Reportes Tránsito Ubaté</span>
                    <i class="bi bi-arrow-up-right" style="font-size: 0.7rem;"></i>
                </a>
            </div>
        </aside>

        <div class="admin-main-wrapper">
            <header class="admin-topbar">
                <div class="topbar-left">
                    <div class="topbar-search" style="width: 200px;">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Buscar...">
                        <span class="topbar-kbd">⌘K</span>
                    </div>

                    <div class="topbar-pills">
                        <div class="status-chip">
                            <span class="chip-dot" style="background-color: #10b981;"></span>
                            <span>{{ \App\Models\User::where('role', 'conductor')->where('is_available', true)->count() }} Activos</span>
                        </div>
                        <div class="status-chip">
                            <span class="chip-dot" style="background-color: #b45309;"></span>
                            <span>{{ \App\Models\Trip::whereIn('status', ['aceptado', 'en_camino'])->count() }} En Carrera</span>
                        </div>
                        <div class="status-chip">
                            <span class="chip-dot" style="background-color: #3b82f6;"></span>
                            <span>{{ \App\Models\Trip::where('status', 'solicitado')->count() }} En Cola</span>
                        </div>
                        <div class="status-chip">
                            <span class="chip-dot" style="background-color: #ef4444;"></span>
                            <span>{{ \App\Models\Trip::where('status', 'cancelado')->count() }} Cancelados</span>
                        </div>
                    </div>
                </div>

                <div class="topbar-right">
                    <div class="topbar-location">
                        <div class="topbar-location-city">Ubaté, Cundinamarca</div>
                        <div class="topbar-location-tz">GMT-5 • En Servicio</div>
                    </div>

                    <div class="topbar-bell" title="Notificaciones del Sistema">
                        <i class="bi bi-bell-fill"></i>
                        <span class="topbar-bell-dot"></span>
                    </div>

                    <div class="topbar-profile">
                        <div class="topbar-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <div class="topbar-user-info">
                            <div class="topbar-user-name">{{ auth()->user()->name }}</div>
                            <div class="topbar-user-role">Dir. Operaciones & Despacho</div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 0.35rem;">
                            @csrf
                            <button type="submit" class="btn-logout">
                                <i class="bi bi-box-arrow-right"></i> Salir
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <span><i class="bi bi-check-circle-fill"></i></span> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        <span><i class="bi bi-x-circle-fill"></i></span> {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>

    @elseif(auth()->check() && auth()->user()->isConductor())
        <!-- ================= 2. SHELL CONDUCTOR (PORTAL CONDUCTOR - Imagen 1) ================= -->
        <aside class="admin-sidebar">
            <a href="{{ route('conductor.dashboard') }}" class="sidebar-brand">
                <div class="sidebar-brand-left">
                    <div class="sidebar-logo-mark">
                        <i class="bi bi-taxi-front-fill"></i>
                    </div>
                    <div>
                        <div class="sidebar-brand-title">TaxiUbaté</div>
                        <span class="sidebar-brand-sub">MOVILIDAD PROVINCIAL</span>
                    </div>
                </div>
                <span class="version-badge">v2.4</span>
            </a>

            <div class="role-active-box">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                    <span style="font-size: 0.58rem; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">ROL ACTIVO</span>
                    <span style="width: 7px; height: 7px; border-radius: 50%; background: {{ auth()->user()->is_available ? '#10b981' : '#f59e0b' }};"></span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.76rem; font-weight: 700; color: #0f172a;">
                        <i class="bi bi-person-badge"></i> {{ auth()->user()->vehicle ? auth()->user()->vehicle->license_plate : 'Sin Vehículo' }}
                    </span>
                    <span style="font-size: 0.68rem; font-weight: 700; color: {{ auth()->user()->is_available ? '#047857' : '#b45309' }};">
                        {{ auth()->user()->is_available ? 'En Línea' : 'Pausa' }}
                    </span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="sidebar-section-label">PORTAL CONDUCTOR</div>
                <a href="#despacho-conductor" class="sidebar-link active-soft">
                    <i class="bi bi-broadcast"></i>
                    <span>Recepción de Despacho</span>
                </a>
                <a href="#liquidacion-conductor" class="sidebar-link">
                    <i class="bi bi-wallet2"></i>
                    <span>Liquidación e Ingresos</span>
                </a>
                <a href="#documentos-conductor" class="sidebar-link">
                    <i class="bi bi-shield-check"></i>
                    <span>Documentos y SOAT/T.O.</span>
                </a>
                <a href="#monitor-demanda" class="sidebar-link">
                    <i class="bi bi-grid"></i>
                    <span>Cuadrantes y Turno</span>
                </a>

                <div class="sidebar-section-label" style="margin-top: 0.75rem;">PORTAL PASAJERO</div>
                <a href="#cola-cuadrantes" class="sidebar-link">
                    <i class="bi bi-person-raised-hand"></i>
                    <span>Solicitud Express</span>
                </a>
                <a href="#monitor-demanda" class="sidebar-link">
                    <i class="bi bi-calculator"></i>
                    <span>Estimador Veredal/Urbano</span>
                </a>
                <a href="#despacho-conductor" class="sidebar-link">
                    <i class="bi bi-123"></i>
                    <span>Trazabilidad y PIN</span>
                </a>
                <a href="#mis-viajes-conductor" class="sidebar-link">
                    <i class="bi bi-journal-text"></i>
                    <span>Historial de Servicios</span>
                </a>

                <a href="{{ route('movil.index', ['tab' => 'conductor']) }}" class="sidebar-link" style="margin-top: 0.45rem; background: #fffbeb; color: #b45309; border: 1px solid #fde68a; font-weight: 700;">
                    <i class="bi bi-phone-fill" style="color: #d97706;"></i>
                    <span>Abrir App Móvil Conductor</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sos-box">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                        <span style="font-size: 0.7rem; color: #64748b; font-weight: 500;">Estado Radial</span>
                        <span style="background: #064e3b; color: #6ee7b7; font-size: 0.62rem; font-weight: 700; padding: 0.15rem 0.5rem; border-radius: 99px;">
                            Canal Activo
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 0.7rem; color: #64748b;">Frecuencia Ubaté</span>
                        <strong style="font-size: 0.75rem; color: #0f172a; font-family: 'Outfit', sans-serif;">148.525 MHz</strong>
                    </div>
                </div>
            </div>
        </aside>

        <div class="admin-main-wrapper">
            <header class="admin-topbar">
                <div class="topbar-left">
                    <div class="topbar-search" style="width: 340px;">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Buscar servicio, placa (p. ej. WFF-124), vereda...">
                        <span class="topbar-kbd">⌘K</span>
                    </div>
                </div>

                <div class="topbar-right">
                    <div class="status-chip" style="background: #fffbeb; border-color: #fde68a; color: #92400e;">
                        <i class="bi bi-buildings-fill" style="color: #d97706;"></i>
                        <span style="font-size: 0.7rem; line-height: 1.15;">Valle de Ubaté •<br>Sector Urbano & Rural</span>
                    </div>

                    <div style="display: inline-flex; background: #f1f5f9; padding: 0.2rem; border-radius: 8px; border: 1px solid #e2e8f0;">
                        <span style="background: #ffffff; color: #0f172a; font-size: 0.72rem; font-weight: 700; padding: 0.25rem 0.65rem; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.06);">Conductor</span>
                        <span style="color: #64748b; font-size: 0.72rem; font-weight: 600; padding: 0.25rem 0.65rem;">Pasajero</span>
                    </div>

                    <div class="topbar-bell">
                        <i class="bi bi-bell"></i>
                        <span class="topbar-bell-dot"></span>
                    </div>

                    <div class="topbar-bell">
                        <i class="bi bi-headset"></i>
                    </div>

                    <div class="topbar-profile">
                        <div class="topbar-user-info" style="text-align: right;">
                            <div class="topbar-user-name">{{ auth()->user()->name }}</div>
                            <div class="topbar-user-role">{{ auth()->user()->email }}</div>
                        </div>
                        <div class="topbar-avatar">
                            <i class="bi bi-person"></i>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-logout">Salir</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success">
                        <span><i class="bi bi-check-circle-fill"></i></span> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">
                        <span><i class="bi bi-x-circle-fill"></i></span> {{ session('error') }}
                    </div>
                @endif
                @yield('content')
            </main>
        </div>

    @elseif(auth()->check() && auth()->user()->isPasajero())
        <!-- ================= 3. SHELL PASAJERO (PORTAL PASAJERO - Imagen 2) ================= -->
        <header class="pasajero-navbar">
            <div class="pasajero-nav-left">
                <a href="{{ route('pasajero.dashboard') }}" class="sidebar-brand" style="padding: 0;">
                    <div class="sidebar-brand-left">
                        <div class="sidebar-logo-mark">
                            <i class="bi bi-taxi-front-fill"></i>
                        </div>
                        <div>
                            <div class="sidebar-brand-title">TaxiUbaté</div>
                            <span class="sidebar-brand-sub">VEREDAL & URBANO</span>
                        </div>
                    </div>
                </a>

                <nav class="pasajero-nav-links">
                    <a href="#cotizador-pasajero" class="pasajero-nav-link active">Portal Pasajero</a>
                    <a href="{{ route('movil.index') }}" class="pasajero-nav-link" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; font-weight: 700;">
                        <i class="bi bi-phone-fill"></i> App Móvil (Celular)
                    </a>
                    <a href="#cotizador-pasajero" class="pasajero-nav-link">Calculadora Tarifaria</a>
                    <a href="#pin-seguridad" class="pasajero-nav-link">Seguridad & PIN</a>
                    <a href="#historial-pasajero" class="pasajero-nav-link">Estación Conductor</a>
                </nav>
            </div>

            <div style="display: flex; align-items: center; gap: 0.85rem;">
                <span style="background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 0.72rem; font-weight: 600; padding: 0.32rem 0.75rem; border-radius: 999px; display: inline-flex; align-items: center; gap: 0.35rem;">
                    <i class="bi bi-shield-check"></i> Transporte Formal Reglamentado
                </span>

                <div class="topbar-avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">
                    <i class="bi bi-person-fill"></i>
                </div>

                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Cerrar Sesión</button>
                </form>
            </div>
        </header>

        <main style="flex: 1; width: 100%;">
            @if(session('success'))
                <div style="max-width: 1220px; margin: 1rem auto 0; padding: 0 1.5rem;">
                    <div class="alert alert-success">
                        <span><i class="bi bi-check-circle-fill"></i></span> {{ session('success') }}
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div style="max-width: 1220px; margin: 1rem auto 0; padding: 0 1.5rem;">
                    <div class="alert alert-danger">
                        <span><i class="bi bi-x-circle-fill"></i></span> {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

    @else
        <!-- ================= 4. SHELL INVITADOS / AUTENTICACIÓN (Imágenes 4, 5, 6) ================= -->
        <main style="flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 2rem 1rem; background-color: #f4f6f9;">
            @if(session('success'))
                <div style="max-width: 460px; width: 100%; margin: 0 auto 1rem;">
                    <div class="alert alert-success">
                        <span><i class="bi bi-check-circle-fill"></i></span> {{ session('success') }}
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div style="max-width: 460px; width: 100%; margin: 0 auto 1rem;">
                    <div class="alert alert-danger">
                        <span><i class="bi bi-x-circle-fill"></i></span> {{ session('error') }}
                    </div>
                </div>
            @endif

            @yield('content')
        </main>
    @endif
</body>
</html>
