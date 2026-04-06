@extends('layouts.app')

@section('title', 'Ejemplares')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Ejemplares</h1>
            <p class="page-subtitle">Administración del inventario físico y digital de biblioteca</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_EJEMPLARES_CREAR'))
                <a href="{{ route('bib.ejemplares.create') }}" class="btn btn-primary">Nuevo ejemplar</a>
            @endif
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <form method="GET" action="{{ route('bib.ejemplares.index') }}">
            <div class="form-grid form-grid-4">
                <div class="form-group">
                    <label class="form-label" for="q">Buscar</label>
                    <input
                        type="text"
                        name="q"
                        id="q"
                        class="form-control"
                        value="{{ request('q') }}"
                        placeholder="Inventario, barras, ubicación o recurso">
                </div>

                <div class="form-group">
                    <label class="form-label" for="id_recurso">Recurso</label>
                    <select name="id_recurso" id="id_recurso" class="form-control">
                        <option value="">Todos</option>
                        @foreach($recursos as $recurso)
                            <option value="{{ $recurso->id_recurso }}" @selected(request('id_recurso') == $recurso->id_recurso)>
                                {{ $recurso->titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="id_estado_ejemplar">Estado</label>
                    <select name="id_estado_ejemplar" id="id_estado_ejemplar" class="form-control">
                        <option value="">Todos</option>
                        @foreach($estados as $estado)
                            <option value="{{ $estado->id_estado_ejemplar }}" @selected(request('id_estado_ejemplar') == $estado->id_estado_ejemplar)>
                                {{ $estado->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="id_disponibilidad">Disponibilidad</label>
                    <select name="id_disponibilidad" id="id_disponibilidad" class="form-control">
                        <option value="">Todas</option>
                        @foreach($disponibilidades as $disponibilidad)
                            <option value="{{ $disponibilidad->id_disponibilidad }}" @selected(request('id_disponibilidad') == $disponibilidad->id_disponibilidad)>
                                {{ $disponibilidad->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid form-grid-4" style="margin-top:16px;">
                <div class="form-group">
                    <label class="form-label" for="activo">Estado general</label>
                    <select name="activo" id="activo" class="form-control">
                        <option value="">Todos</option>
                        <option value="1" @selected(request('activo') === '1')>Activos</option>
                        <option value="0" @selected(request('activo') === '0')>Inactivos</option>
                    </select>
                </div>
            </div>

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('bib.ejemplares.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Inventario</th>
                        <th>Recurso</th>
                        <th>Estado</th>
                        <th>Disponibilidad</th>
                        <th>Ubicación</th>
                        <th>Activo</th>
                        <th style="width: 140px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ejemplares as $ejemplar)
                        <tr>
                            <td>{{ $ejemplar->codigo_inventario }}</td>
                            <td>{{ $ejemplar->recurso?->titulo_completo ?? $ejemplar->recurso?->titulo ?? '-' }}</td>
                            <td>{{ $ejemplar->estado?->nombre ?? '-' }}</td>
                            <td>{{ $ejemplar->disponibilidad?->nombre ?? '-' }}</td>
                            <td>{{ $ejemplar->ubicacion ?: '-' }}</td>
                            <td>{{ $ejemplar->activo ? 'Sí' : 'No' }}</td>
                            <td>
                                @if(auth()->user()->tienePermiso('BIB_EJEMPLARES_EDITAR'))
                                    <a href="{{ route('bib.ejemplares.edit', $ejemplar) }}" class="btn btn-secondary">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay ejemplares registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $ejemplares->links() }}
        </div>
    </div>
@endsection