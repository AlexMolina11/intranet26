@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div>
                <h1 style="margin:0;">Usuarios</h1>
                <p style="margin:6px 0 0 0; color:#64748b;">Administración de usuarios del sistema</p>
            </div>

            <a href="{{ route('seg.usuarios.create') }}" class="btn btn-primary">Nuevo usuario</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Correo</th>
                    <th>Usuario</th>
                    <th>Organización</th>
                    <th>Estado</th>
                    <th>Último acceso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id_usuario }}</td>
                        <td>{{ $usuario->nombre_completo }}</td>
                        <td>{{ $usuario->correo }}</td>
                        <td>{{ $usuario->nombre_usuario }}</td>
                        <td>
                            @if ($usuario->areaPrincipalAsignada && $usuario->areaPrincipalAsignada->area)
                                <div>
                                    <strong>Principal:</strong><br>
                                    {{ $usuario->areaPrincipalAsignada->area->nombre_completo }}
                                </div>
                            @else
                                <div>Sin área principal</div>
                            @endif

                            @if ($usuario->areasSecundariasAsignadas->count())
                                <div style="margin-top:8px;">
                                    <strong>Secundarias:</strong><br>
                                    @foreach ($usuario->areasSecundariasAsignadas as $asignacion)
                                        @if ($asignacion->area)
                                            <div>- {{ $asignacion->area->nombre_completo }}</div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td>
                            @if ($usuario->activo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            {{ $usuario->ultimo_acceso ? $usuario->ultimo_acceso->format('d/m/Y H:i') : 'Sin acceso' }}
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('seg.usuarios.edit', $usuario) }}" class="btn btn-warning">
                                    Editar
                                </a>

                                <a href="{{ route('org.usuarios.organizacion.edit', $usuario) }}" class="btn btn-secondary">
                                    Organización
                                </a>

                                <form method="POST" action="{{ route('seg.usuarios.toggle', $usuario) }}" class="inline-form">
                                    @csrf
                                    @method('PATCH')

                                    @if ($usuario->activo)
                                        <button type="submit" class="btn btn-danger">Desactivar</button>
                                    @else
                                        <button type="submit" class="btn btn-success">Activar</button>
                                    @endif
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No hay usuarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $usuarios->links() }}
        </div>
    </div>
@endsection