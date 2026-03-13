@extends('layouts.app')

@section('title', 'Roles del usuario')

@section('content')
    <div class="card">
        <h1>Asignar roles a usuario</h1>
        <p style="color:#64748b;">
            Usuario: <strong>{{ $usuario->nombres }} {{ $usuario->apellidos }}</strong>
        </p>

        <form method="POST" action="{{ route('seg.usuarios.roles.update', $usuario) }}">
            @csrf
            @method('PUT')

            @forelse ($sistemas as $sistema)
                <div style="margin-bottom:20px;">
                    <h3>{{ $sistema->nombre }}</h3>

                    @if (!in_array($sistema->id_sistema, $sistemasActivosUsuario))
                        <p style="color:#dc2626;">Este usuario no tiene acceso activo a este sistema.</p>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Asignar</th>
                                <th>Rol</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sistema->roles as $rol)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="roles[]" value="{{ $rol->id_rol }}"
                                            {{ in_array($rol->id_rol, $rolesAsignados) ? 'checked' : '' }}
                                            {{ !in_array($sistema->id_sistema, $sistemasActivosUsuario) ? 'disabled' : '' }}>
                                    </td>
                                    <td>{{ $rol->nombre }}</td>
                                    <td>{{ $rol->descripcion ?: 'Sin descripción' }}</td>
                                    <td>{{ $rol->activo ? 'Activo' : 'Inactivo' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No hay roles registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @empty
                <p>No hay sistemas registrados.</p>
            @endforelse

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection