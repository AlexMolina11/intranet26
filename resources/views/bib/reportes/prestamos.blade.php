@extends('layouts.app')

@section('title', 'Reporte de préstamos')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Reporte de préstamos</h1>
            <p class="page-subtitle">Listado de préstamos por período.</p>
        </div>

        <div class="page-header-actions">
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

                <div class="form-group" style="display:flex; align-items:end; gap:8px;">
                    <button class="btn btn-primary" type="submit">Filtrar</button>
                    <a href="{{ route('bib.reportes.prestamos') }}" class="btn btn-secondary">Limpiar</a>
                </div>
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
                        <th>Préstamo</th>
                        <th>Vencimiento</th>
                        <th>Devolución</th>
                        <th>Estado</th>
                        <th>Multa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->id_prestamo }}</td>
                            <td>{{ $prestamo->usuario?->nombre_completo ?? '-' }}</td>
                            <td>{{ $prestamo->recurso?->titulo ?? '-' }}</td>
                            <td>{{ $prestamo->ejemplar?->codigo_inventario ?? '-' }}</td>
                            <td>{{ optional($prestamo->fecha_prestamo)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ optional($prestamo->fecha_vencimiento)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ optional($prestamo->fecha_devolucion)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $prestamo->estadoPrestamo?->nombre ?? '-' }}</td>
                            <td>${{ number_format((float) $prestamo->multa_acumulada, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No hay préstamos con los filtros seleccionados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $prestamos->links() }}
        </div>
    </div>
@endsection