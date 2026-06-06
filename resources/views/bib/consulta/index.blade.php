@extends('layouts.app')

@section('title', 'Consulta bibliográfica')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Consulta bibliográfica</h1>
            <p class="page-subtitle">Búsqueda interna de recursos, autores, editoriales y disponibilidad de ejemplares.</p>
        </div>

        <div class="page-header-actions">
            <a href="{{ route('bib.dashboard') }}" class="btn btn-secondary">Volver al dashboard</a>
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <form method="GET" action="{{ route('bib.consulta.index') }}">
            <div class="form-grid form-grid-3">
                <div class="form-group">
                    <label class="form-label" for="q">Buscar</label>
                    <input
                        type="text"
                        name="q"
                        id="q"
                        class="form-control"
                        value="{{ request('q') }}"
                        placeholder="Título, código, autor, editorial, ISBN o ISSN">
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
                    <label class="form-label" for="solo_disponibles">Disponibilidad</label>
                    <select name="solo_disponibles" id="solo_disponibles" class="form-control">
                        <option value="">Todos</option>
                        <option value="1" @selected(request('solo_disponibles') === '1')>Solo disponibles</option>
                    </select>
                </div>
            </div>

            <div class="page-header-actions" style="margin-top:16px;">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="{{ route('bib.consulta.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Recurso</th>
                        <th>Autores</th>
                        <th>Tipo</th>
                        <th>Editorial</th>
                        <th>Idioma</th>
                        <th>Ejemplares</th>
                        <th>Disponibles</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recursos as $recurso)
                        <tr>
                            <td>{{ $recurso->codigo }}</td>
                            <td>
                                <strong>{{ $recurso->titulo_completo }}</strong>

                                @if($recurso->isbn)
                                    <br><small>ISBN: {{ $recurso->isbn }}</small>
                                @endif

                                @if($recurso->issn)
                                    <br><small>ISSN: {{ $recurso->issn }}</small>
                                @endif
                            </td>
                            <td>
                                @if($recurso->autores->isNotEmpty())
                                    {{ $recurso->autores->map(fn ($autor) => $autor->nombre_completo ?: trim($autor->nombre . ' ' . $autor->apellido))->join(', ') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $recurso->tipoRecurso?->nombre ?? '-' }}</td>
                            <td>{{ $recurso->editorial?->nombre ?? '-' }}</td>
                            <td>{{ $recurso->idioma?->nombre ?? '-' }}</td>
                            <td>{{ $recurso->ejemplares_total }}</td>
                            <td>{{ $recurso->ejemplares_disponibles }}</td>
                            <td>
                                <a href="{{ route('bib.recursos.show', $recurso) }}" class="btn btn-secondary">
                                    Ver
                                </a>
                            </td>
                        </tr>

                        @if($recurso->ejemplares->isNotEmpty())
                            <tr>
                                <td colspan="9">
                                    <strong>Ejemplares:</strong>
                                    <div style="margin-top:8px;">
                                        @foreach($recurso->ejemplares as $ejemplar)
                                            <span style="display:inline-block; margin:0 8px 8px 0; padding:6px 10px; border:1px solid #ddd; border-radius:8px;">
                                                {{ $ejemplar->codigo_inventario }}
                                                —
                                                {{ $ejemplar->disponibilidad?->nombre ?? 'Sin disponibilidad' }}
                                                —
                                                {{ $ejemplar->estado?->nombre ?? 'Sin estado' }}
                                                @if($ejemplar->ubicacion)
                                                    —
                                                    {{ $ejemplar->ubicacion }}
                                                @endif
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="9">No se encontraron recursos con los filtros seleccionados.</td>
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