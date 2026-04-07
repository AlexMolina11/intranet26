@extends('layouts.app')

@section('title', 'Solicitudes')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Solicitudes</h1>
            <p class="page-subtitle">Administración de solicitudes bibliográficas</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_SOLICITUDES_CREAR'))
                <a href="{{ route('bib.solicitudes.create') }}" class="btn btn-primary">Nueva solicitud</a>
            @endif
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <form method="GET" action="{{ route('bib.solicitudes.index') }}" class="form-grid">
            <div class="form-group">
                <label class="form-label" for="q">Buscar</label>
                <input
                    type="text"
                    name="q"
                    id="q"
                    class="form-control"
                    value="{{ request('q') }}"
                    placeholder="Usuario, recurso o motivo"
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="id_estado_solicitud">Estado</label>
                <select name="id_estado_solicitud" id="id_estado_solicitud" class="form-control">
                    <option value="">Todos</option>
                    @foreach($estadosSolicitud as $estado)
                        <option
                            value="{{ $estado->id_estado_solicitud }}"
                            {{ (string) request('id_estado_solicitud') === (string) $estado->id_estado_solicitud ? 'selected' : '' }}
                        >
                            {{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="activo">Estado registro</label>
                <select name="activo" id="activo" class="form-control">
                    <option value="">Todos</option>
                    <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group" style="display:flex; align-items:end; gap:8px;">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('bib.solicitudes.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Recurso</th>
                        <th>Ejemplar</th>
                        <th>Estado</th>
                        <th>Fecha solicitud</th>
                        <th>Fecha requerida</th>
                        <th>Atendida por</th>
                        <th>Estado registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->id_solicitud }}</td>
                            <td>{{ $solicitud->usuario?->nombre }}</td>
                            <td>{{ $solicitud->recurso?->titulo }}</td>
                            <td>{{ $solicitud->ejemplar?->codigo_inventario ?? 'N/D' }}</td>
                            <td>{{ $solicitud->estadoSolicitud?->nombre }}</td>
                            <td>{{ optional($solicitud->fecha_solicitud)->format('d/m/Y') }}</td>
                            <td>{{ optional($solicitud->fecha_requerida)->format('d/m/Y') ?? 'N/D' }}</td>
                            <td>{{ $solicitud->usuarioAtiende?->nombre ?? 'N/D' }}</td>
                            <td>{{ $solicitud->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                @if(auth()->user()->tienePermiso('BIB_SOLICITUDES_GESTIONAR'))
                                    <a href="{{ route('bib.solicitudes.edit', $solicitud) }}" class="btn btn-secondary">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay solicitudes registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $solicitudes->links() }}
        </div>
    </div>
@endsection