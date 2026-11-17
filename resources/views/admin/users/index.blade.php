@extends('layouts.app')

@section('title', 'Configuración, Usuarios y API Tokens - TaxiUbaté')

@section('content')
<div style="display: flex; align-items: flex-end; justify-content: space-between; gap: 1.5rem; margin-bottom: 1.4rem; flex-wrap: wrap;">
    <div>
        <div style="font-size: 0.66rem; font-weight: 800; color: #ea580c; text-transform: uppercase; letter-spacing: 0.6px; margin-bottom: 0.3rem;">
            SEGURIDAD, CONTROL DE ACCESOS & SANCTUM API
        </div>
        <h1 style="font-family: 'Outfit', sans-serif; font-size: 1.85rem; font-weight: 800; color: #0f172a; letter-spacing: -0.5px;">
            Configuración, Usuarios y API Tokens
        </h1>
        <p style="font-size: 0.82rem; color: #64748b; margin-top: 0.25rem; max-width: 620px;">
            Administración de cuentas del sistema (Administradores, Conductores y Pasajeros), permisos RBAC y credenciales de sincronización con la Secretaría de Tránsito.
        </p>
    </div>

    <div style="display: flex; gap: 0.6rem;">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> + Nuevo Usuario
        </a>
    </div>
</div>

<!-- Tarjetas de Estado de API & Seguridad -->
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.15rem; margin-bottom: 1.35rem;">
    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; font-size: 0.68rem; font-weight: 800; color: #64748b;">
            <span>AUTENTICACIÓN API SANCTUM</span>
            <i class="bi bi-key-fill" style="color: #ea580c;"></i>
        </div>
        <div style="font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0.45rem 0;">
            Tokens Bearer JWT
        </div>
        <div style="font-size: 0.72rem; color: #047857; font-weight: 600;">● Endpoints /api/trips & /api/driver/location activos</div>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; font-size: 0.68rem; font-weight: 800; color: #64748b;">
            <span>PROTECCIÓN CSRF & RBAC</span>
            <i class="bi bi-shield-lock-fill" style="color: #10b981;"></i>
        </div>
        <div style="font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0.45rem 0;">
            100% Verificado
        </div>
        <div style="font-size: 0.72rem; color: #64748b;">Middleware role:admin, conductor, pasajero</div>
    </div>

    <div class="card" style="margin-bottom: 0;">
        <div style="display: flex; justify-content: space-between; font-size: 0.68rem; font-weight: 800; color: #64748b;">
            <span>USUARIOS REGISTRADOS</span>
            <i class="bi bi-people-fill" style="color: #2563eb;"></i>
        </div>
        <div style="font-family: 'Outfit', sans-serif; font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0.45rem 0;">
            {{ $users->total() }} Cuentas
        </div>
        <div style="font-size: 0.72rem; color: #64748b;">Base de datos sincronizada en tiempo real</div>
    </div>
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <div style="padding: 1rem 1.35rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #0f172a;">
            Directorio General de Usuarios y Roles
        </h3>
        <span style="font-size: 0.74rem; color: #64748b;">Mostrando {{ $users->count() }} de {{ $users->total() }}</span>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>USUARIO</th>
                    <th>CORREO ELECTRÓNICO</th>
                    <th>ROL DE ACCESO</th>
                    <th>TELÉFONO</th>
                    <th>FECHA REGISTRO</th>
                    <th style="text-align: right;">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.65rem;">
                                <div class="avatar" style="width: 34px; height: 34px; font-size: 0.78rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span style="font-weight: 700; color: #0f172a;">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-tag role-{{ $user->role }}">{{ $user->role }}</span>
                        </td>
                        <td>{{ $user->phone ?? 'Sin teléfono' }}</td>
                        <td style="color: #64748b; font-size: 0.78rem;">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 0.45rem;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline btn-sm">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro de eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash3"></i> Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: #64748b; padding: 2rem;">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div style="padding: 1rem 1.35rem; border-top: 1px solid #f1f5f9;">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
