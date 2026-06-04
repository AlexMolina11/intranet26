@extends('layouts.app')

@section('title', 'Recursos más prestados')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Recursos más prestados</h1>
            <p class="page-subtitle">Ranking de recursos con mayor circulación.</p>
        </div>

        <div class="page-header-actions">
            <a href="{{ route('bib.reportes.recursos-mas-prestados.exportar', request()->query()) }}" class="btn btn-success">
                Exportar Excel
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

                <div class="form-group" style="display:flex; align-items:end; gap:8px;">
                    <button class="btn btn-primary" type="submit">Filtrar</button>
                    <a href="{{ route('bib.reportes.recursos-mas-prestados') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Posición</th>
                        <th>Código</th>
                        <th>Recurso</th>
                        <th>Total préstamos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recursos as $index => $recurso)
                        <tr>
                            <td>{{ $recursos->firstItem() + $index }}</td>
                            <td>{{ $recurso->codigo }}</td>
                            <td>{{ $recurso->titulo }}</td>
                            <td>{{ $recurso->total_prestamos }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No hay recursos prestados con los filtros seleccionados.</td>
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