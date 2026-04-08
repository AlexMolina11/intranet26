@extends('layouts.app')

@section('title', 'Multas')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Multas</h1>
            <p class="page-subtitle">Administración de multas bibliográficas</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_MULTAS_VER'))
                <a href="{{ route('bib.multas.create') }}" class="btn btn-primary">Nueva multa</a>
            @endif
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <form method="GET" action="{{ route('bib.multas.index') }}" class="form-grid">
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
                <label class="form-label" for="pagada">Pago</label>
                <select name="pagada" id="pagada" class="form-control">
                    <option value="">Todas</option>
                    <option value="1" {{ request('pagada') === '1' ? 'selected' : '' }}>Pagadas</option>
                    <option value="0" {{ request('pagada') === '0' ? 'selected' : '' }}>Pendientes</option>
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
                <a href="{{ route('bib.multas.index') }}" class="btn btn-secondary">Limpiar</a>
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
                        <th>Préstamo</th>
                        <th>Recurso</th>
                        <th>Fecha multa</th>
                        <th>Días atraso</th>
                        <th>Monto</th>
                        <th>Monto pagado</th>
                        <th>Pagada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($multas as $multa)
                        <tr>
                            <td>{{ $multa->id_multa }}</td>
                            <td>{{ $multa->usuario?->nombre_completo }}</td>
                            <td>#{{ $multa->id_prestamo }}</td>
                            <td>{{ $multa->prestamo?->recurso?->titulo ?? 'N/D' }}</td>
                            <td>{{ optional($multa->fecha_multa)->format('d/m/Y') }}</td>
                            <td>{{ $multa->dias_atraso }}</td>
                            <td>{{ number_format((float) $multa->monto, 2) }}</td>
                            <td>{{ number_format((float) $multa->monto_pagado, 2) }}</td>
                            <td>{{ $multa->pagada ? 'Sí' : 'No' }}</td>
                            <td>
                                <a href="{{ route('bib.multas.edit', $multa) }}" class="btn btn-secondary">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay multas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $multas->links() }}
        </div>
    </div>
@endsection