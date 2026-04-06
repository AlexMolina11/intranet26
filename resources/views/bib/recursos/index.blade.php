@extends('layouts.app')

@section('title', 'Recursos bibliográficos')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Recursos bibliográficos</h1>
            <p class="page-subtitle">Administración del catálogo principal de biblioteca</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_RECURSOS_CREAR'))
                <a href="{{ route('bib.recursos.create') }}" class="btn btn-primary">Nuevo recurso</a>
            @endif
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <form method="GET" action="{{ route('bib.recursos.index') }}">
            <div class="form-grid form-grid-3">
                <div class="form-group">
                    <label class="form-label" for="q">Buscar</label>
                    <input
                        type="text"
                        name="q"
                        id="q"
                        class="form-control"
                        value="{{ request('q') }}"
                        placeholder="Código, título, ISBN o ISSN">
                </div>

                <div class="form-group">
                    <label class="form-label" for="id_tipo_recurso">Tipo de recurso</label>
                    <select name="id_tipo_recurso" id="id_tipo_recurso" class="form-control">
                        <option value="">Todos</option>
                        @foreach($tiposRecurso as $tipo)
                            <option value="{{ $tipo->id_tipo_recurso }}" @selected(request('id_tipo_recurso') == $tipo->id_tipo_recurso)>
                                {{ $tipo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="activo">Estado</label>
                    <select name="activo" id="activo" class="form-control">
                        <option value="">Todos</option>
                        <option value="1" @selected(request('activo') === '1')>Activos</option>
                        <option value="0" @selected(request('activo') === '0')>Inactivos</option>
                    </select>
                </div>
            </div>

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('bib.recursos.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Autores</th>
                        <th>Tipo</th>
                        <th>Idioma</th>
                        <th>Editorial</th>
                        <th>Estado</th>
                        <th style="width: 220px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recursos as $recurso)
                        <tr>
                            <td>{{ $recurso->codigo }}</td>
                            <td>{{ $recurso->titulo_completo }}</td>
                            <td>
                                @if($recurso->autores->isNotEmpty())
                                    {{ $recurso->autores->pluck('nombre')->join(', ') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $recurso->tipoRecurso?->nombre ?: '-' }}</td>
                            <td>{{ $recurso->idioma?->nombre ?: '-' }}</td>
                            <td>{{ $recurso->editorial?->nombre ?: '-' }}</td>
                            <td>{{ $recurso->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                <a href="{{ route('bib.recursos.show', $recurso) }}" class="btn btn-secondary">Ver</a>

                                @if(auth()->user()->tienePermiso('BIB_RECURSOS_EDITAR'))
                                    <a href="{{ route('bib.recursos.edit', $recurso) }}" class="btn btn-secondary">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No hay recursos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $recursos->links() }}
        </div>
    </div>
@endsection