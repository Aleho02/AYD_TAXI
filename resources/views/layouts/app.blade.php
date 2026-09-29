<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Control') - AYD TAXII</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #f59e0b;
            --primary-dark: #d97706;
            --primary-light: #fef3c7;
            --accent: #2563eb;
            --bg-dark: #0f172a;
            --bg-card: #1e293b;
            --bg-card-hover: #334155;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: #334155;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4, h5, .brand-font {
            font-family: 'Outfit', sans-serif;
        }

        .navbar {
            background-color: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 0.85rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--text-main);
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .brand-badge {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #000;
            padding: 0.2rem 0.55rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.92rem;
            padding: 0.45rem 0.8rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-links a:hover, .nav-links a.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.08);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .role-tag {
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .role-admin { background-color: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.4); }
        .role-conductor { background-color: rgba(245, 158, 11, 0.2); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); }
        .role-pasajero { background-color: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.4); }

        .btn-logout {
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            padding: 0.4rem 0.85rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .btn-logout:hover {
            color: #ef4444;
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.05);
        }

        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
            flex: 1;
            width: 100%;
        }

        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.25);
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
            padding-bottom: 0.85rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.55rem 1.15rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #0f172a;
        }

        .btn-primary:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #334155;
            color: #f8fafc;
        }

        .btn-secondary:hover {
            background-color: #475569;
        }

        .btn-danger {
            background-color: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            background-color: rgba(239, 68, 68, 0.35);
        }

        .btn-sm {
            padding: 0.35rem 0.7rem;
            font-size: 0.8rem;
        }

        /* Form elements */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.45rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #cbd5e1;
        }

        .form-control {
            width: 100%;
            padding: 0.65rem 0.9rem;
            border-radius: 8px;
            background-color: #0f172a;
            border: 1px solid var(--border-color);
            color: #fff;
            font-size: 0.92rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
        }

        .invalid-feedback {
            color: #f87171;
            font-size: 0.8rem;
            margin-top: 0.35rem;
        }

        /* Table styles */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: rgba(15, 23, 42, 0.6);
            color: var(--text-muted);
            padding: 0.75rem 1rem;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 0.9rem 1rem;
            font-size: 0.88rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }

        tr:hover td {
            background-color: rgba(255, 255, 255, 0.02);
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-success { background: rgba(16, 185, 129, 0.2); color: #34d399; }
        .status-warning { background: rgba(245, 158, 11, 0.2); color: #fbbf24; }
        .status-info { background: rgba(59, 130, 246, 0.2); color: #60a5fa; }
        .status-danger { background: rgba(239, 68, 68, 0.2); color: #f87171; }

        /* Alerts */
        .alert {
            padding: 0.9rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary);
            background-color: #334155;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #fff;
        }

        footer {
            text-align: center;
            padding: 1.5rem;
            font-size: 0.82rem;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            margin-top: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ url('/') }}" class="nav-brand">
            <span>🚖 AYD TAXII</span>
            <span class="brand-badge">Valle de Ubaté</span>
        </a>

        @auth
            <div class="nav-links">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                    <a href="{{ route('admin.fleet.index') }}" class="{{ request()->routeIs('admin.fleet.*') ? 'active' : '' }}">Flota Taxis</a>
                    <a href="{{ route('admin.drivers.index') }}" class="{{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">Conductores</a>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Usuarios</a>
                @elseif(auth()->user()->isConductor())
                    <a href="{{ route('conductor.dashboard') }}" class="active">Panel Conductor</a>
                @else
                    <a href="{{ route('pasajero.dashboard') }}" class="active">Panel Pasajero</a>
                @endif
            </div>

            <div class="user-menu">
                <span class="role-tag role-{{ auth()->user()->role }}">{{ auth()->user()->role }}</span>
                <span style="font-size: 0.9rem; font-weight: 500;">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Salir</button>
                </form>
            </div>
        @else
            <div class="nav-links">
                <a href="{{ route('login') }}">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm" style="color: #000;">Registrarse</a>
            </div>
        @endauth
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert alert-success">
                <span>✓</span> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <span>✕</span> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>AYD TAXII &copy; {{ date('Y') }} - Sistema de Información Geoespacial Distribuido para Taxis en Valle de Ubaté, Cundinamarca.</p>
    </footer>
</body>
</html>
