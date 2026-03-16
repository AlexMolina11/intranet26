@extends('layouts.app')

@section('title', 'Permisos')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Permisos</h1>
                <p class="page-subtitle">Administración de permisos</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('seg.permisos.create') }}" class="btn btn-primary">Nuevo permiso</a>
            </div>
        </div>

        <form method="GET" action="{{ route('seg.permisos.index') }}" style="margin-bottom:20px;">
            <div class="form-group">
                <label class="form-label" for="id_sistema">Filtrar por sistema</label>
                <select name="id_sistema" id="id_sistema" class="form-control" onchange="this.form.submit()">
                    <option value="">Todos</option>
                    @foreach ($sistemas as $sistema)
                        <option value="{{ $sistema->id_sistema }}" {{ (string) $sistemaId === (string) $sistema->id_sistema ? 'selected' : '' }}>
                            {{ $sistema->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sistema</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permisos as $permiso)
                        <tr>
                            <td>{{ $permiso->id_permiso }}</td>
                            <td>{{ $permiso->sistema->nombre ?? 'N/A' }}</td>
                            <td>{{ $permiso->codigo }}</td>
                            <td>{{ $permiso->nombre }}</td>
                            <td>{{ $permiso->descripcion ?: 'Sin descripción' }}</td>
                            <td>
                                <div class="actions">
                                    <a href="{{ route('seg.permisos.edit', $permiso) }}" class="btn btn-warning">Editar</a>

                                    <form method="POST" action="{{ route('seg.permisos.destroy', $permiso) }}" class="inline-form"
                                        onsubmit="return confirm('¿Deseas eliminar este permiso?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay permisos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $permisos->links() }}
        </div>
    </div>
@endsection