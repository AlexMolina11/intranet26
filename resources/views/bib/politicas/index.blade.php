@extends('layouts.app')

@section('title', 'Políticas de préstamo')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Políticas de préstamo</h1>
            <p class="page-subtitle">Administración de reglas base para circulación bibliográfica</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_POLITICAS_EDITAR'))
                <a href="{{ route('bib.politicas.create') }}" class="btn btn-primary">Nueva política</a>
            @endif
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <form method="GET" action="{{ route('bib.politicas.index') }}" class="form-grid">
            <div class="form-group">
                <label class="form-label" for="q">Buscar</label>
                <input
                    type="text"
                    name="q"
                    id="q"
                    class="form-control"
                    value="{{ request('q') }}"
                    placeholder="Código o tipo de recurso"
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="activo">Estado</label>
                <select name="activo" id="activo" class="form-control">
                    <option value="">Todos</option>
                    <option value="1" {{ request('activo') === '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ request('activo') === '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group" style="display:flex; align-items:end; gap:8px;">
                <button type="submit" class="btn btn-primary">Filtrar</button>
                <a href="{{ route('bib.politicas.index') }}" class="btn btn-secondary">Limpiar</a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo de recurso</th>
                        <th>Días</th>
                        <th>Renovaciones</th>
                        <th>Máx. préstamos</th>
                        <th>Multa diaria</th>
                        <th>Reserva</th>
                        <th>Aprobación</th>
                        <th>Préstamo externo</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($politicas as $politica)
                        <tr>
                            <td>
                                {{ $politica->tipoRecurso?->nombre }}
                                @if($politica->tipoRecurso?->codigo)
                                    <br>
                                    <small>{{ $politica->tipoRecurso->codigo }}</small>
                                @endif
                            </td>
                            <td>{{ $politica->dias_prestamo }}</td>
                            <td>{{ $politica->max_renovaciones }}</td>
                            <td>{{ $politica->max_prestamos_usuario }}</td>
                            <td>{{ number_format((float) $politica->multa_diaria, 2) }}</td>
                            <td>{{ $politica->permite_reserva ? 'Sí' : 'No' }}</td>
                            <td>{{ $politica->requiere_aprobacion ? 'Sí' : 'No' }}</td>
                            <td>{{ $politica->permite_prestamo_externo ? 'Sí' : 'No' }}</td>
                            <td>{{ $politica->orden }}</td>
                            <td>{{ $politica->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                @if(auth()->user()->tienePermiso('BIB_POLITICAS_EDITAR'))
                                    <a href="{{ route('bib.politicas.edit', $politica) }}" class="btn btn-secondary">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">No hay políticas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $politicas->links() }}
        </div>
    </div>
@endsection