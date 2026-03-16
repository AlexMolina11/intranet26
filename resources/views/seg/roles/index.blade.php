@extends('layouts.app')

@section('title', 'Roles por sistema')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Roles</h1>
                <p class="page-subtitle">Administración de roles por sistema</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('seg.sistemas.index') }}" class="btn btn-secondary">Volver</a>
                <a href="{{ route('seg.sistemas.roles.create', $sistema) }}" class="btn btn-primary">Nuevo rol</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $rol)
                        <tr>
                            <td>{{ $rol->id_rol }}</td>
                            <td>{{ $rol->nombre }}</td>
                            <td>{{ $rol->descripcion ?: 'Sin descripción' }}</td>
                            <td>
                                @if ($rol->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('seg.sistemas.roles.edit', [$sistema, $rol]) }}" class="btn btn-warning">
                                        Editar
                                    </a>

                                    <form method="POST" action="{{ route('seg.sistemas.roles.toggle', [$sistema, $rol]) }}" class="inline-form">
                                        @csrf
                                        @method('PATCH')

                                        @if ($rol->activo)
                                            <button type="submit" class="btn btn-danger">Desactivar</button>
                                        @else
                                            <button type="submit" class="btn btn-success">Activar</button>
                                        @endif
                                    </form>

                                    <a href="{{ route('seg.sistemas.roles.permisos.edit', [$sistema, $rol]) }}" class="btn btn-primary">
                                        Permisos
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay roles registrados para este sistema.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $roles->links() }}
        </div>
    </div>
@endsection