@extends('layouts.app')

@section('title', 'Reporte de multas')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Reporte de multas</h1>
            <p class="page-subtitle">Listado de multas generadas por atraso.</p>
        </div>

        <div class="page-header-actions">
            <a href="{{ route('bib.reportes.multas.exportar', request()->query()) }}" class="btn btn-success">
                Exportar CSV
            </a>
            <a href="{{ route('bib.reportes.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <form method="GET">
            <div class="form-grid form-grid-3">
                <div class="form-group">
                    <label class="form-label">Desde</label>
                    <input type="date" name="desde" class="form-control" value="{{ request('desde') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Hasta</label>
                    <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Estado de pago</label>
                    <select name="pagada" class="form-control">
                        <option value="">Todas</option>
                        <option value="0" @selected(request('pagada') === '0')>Pendientes</option>
                        <option value="1" @selected(request('pagada') === '1')>Pagadas</option>
                    </select>
                </div>
            </div>

            <div class="page-header-actions" style="margin-top:16px;">
                <button class="btn btn-primary" type="submit">Filtrar</button>
                <a href="{{ route('bib.reportes.multas') }}" class="btn btn-secondary">Limpiar</a>
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
                        <th>Fecha</th>
                        <th>Días atraso</th>
                        <th>Monto</th>
                        <th>Pagado</th>
                        <th>Pendiente</th>
                        <th>Pagada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($multas as $multa)
                        <tr>
                            <td>{{ $multa->id_multa }}</td>
                            <td>{{ $multa->usuario?->nombre_completo ?? '-' }}</td>
                            <td>{{ $multa->prestamo?->recurso?->titulo ?? '-' }}</td>
                            <td>{{ optional($multa->fecha_multa)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $multa->dias_atraso }}</td>
                            <td>${{ number_format((float) $multa->monto, 2) }}</td>
                            <td>${{ number_format((float) $multa->monto_pagado, 2) }}</td>
                            <td>${{ number_format((float) $multa->monto - (float) $multa->monto_pagado, 2) }}</td>
                            <td>{{ $multa->pagada ? 'Sí' : 'No' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No hay multas con los filtros seleccionados.</td>
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