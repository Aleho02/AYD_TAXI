@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="card">
    <div class="card-header">
        <div>
            <h2 class="card-title">Administración de Usuarios</h2>
            <p style="color: var(--text-muted); font-size: 0.88rem; margin-top: 0.25rem;">Control de accesos y roles del sistema AYD TAXII</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            + Nuevo Usuario
        </a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Teléfono</th>
                    <th>Fecha Registro</th>
                    <th style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td style="font-weight: 600;">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="role-tag role-{{ $user->role }}">{{ $user->role }}</span>
                        </td>
                        <td>{{ $user->phone ?? 'Sin teléfono' }}</td>
                        <td style="color: var(--text-muted); font-size: 0.82rem;">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td style="text-align: right;">
                            <div style="display: inline-flex; gap: 0.5rem;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-secondary btn-sm">Editar</a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro de eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 2rem;">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 1.25rem;">
        {{ $users->links() }}
    </div>
</div>
@endsection
