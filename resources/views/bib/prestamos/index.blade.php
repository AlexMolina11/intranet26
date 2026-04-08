@extends('layouts.app')

@section('title', 'Préstamos')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Préstamos</h1>
            <p class="page-subtitle">Administración de préstamos bibliográficos</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_PRESTAMOS_CREAR'))
                <a href="{{ route('bib.prestamos.create') }}" class="btn btn-primary">Nuevo préstamo</a>
            @endif
        </div>
    </div>

    <div class="card" style="margin-bottom:16px;">
        <form method="GET" action="{{ route('bib.prestamos.index') }}" class="form-grid">
            <div class="form-group">
                <label class="form-label" for="q">Buscar</label>
                <input type="text" name="q" id="q" class="form-control" value="{{ request('q') }}" placeholder="Usuario, recurso o ejemplar">
            </div>

            <div class="form-group">
                <label class="form-label" for="id_estado_prestamo">Estado</label>
                <select name="id_estado_prestamo" id="id_estado_prestamo" class="form-control">
                    <option value="">Todos</option>
                    @foreach($estadosPrestamo as $estado)
                        <option value="{{ $estado->id_estado_prestamo }}" {{ (string) request('id_estado_prestamo') === (string) $estado->id_estado_prestamo ? 'selected' : '' }}>
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
                <a href="{{ route('bib.prestamos.index') }}" class="btn btn-secondary">Limpiar</a>
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
                        <th>Préstamo</th>
                        <th>Vencimiento</th>
                        <th>Devolución</th>
                        <th>Multa acumulada</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->id_prestamo }}</td>
                            <td>{{ $prestamo->usuario?->nombre_completo }}</td>
                            <td>{{ $prestamo->recurso?->titulo }}</td>
                            <td>{{ $prestamo->ejemplar?->codigo_inventario }}</td>
                            <td>{{ $prestamo->estadoPrestamo?->nombre }}</td>
                            <td>{{ optional($prestamo->fecha_prestamo)->format('d/m/Y') }}</td>
                            <td>{{ optional($prestamo->fecha_vencimiento)->format('d/m/Y') }}</td>
                            <td>{{ optional($prestamo->fecha_devolucion)->format('d/m/Y') ?? 'N/D' }}</td>
                            <td>{{ number_format((float) $prestamo->multa_acumulada, 2) }}</td>
                            <td>
                                @if(auth()->user()->tienePermiso('BIB_PRESTAMOS_DEVOLVER'))
                                    <a href="{{ route('bib.prestamos.edit', $prestamo) }}" class="btn btn-secondary">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay préstamos registrados.</td>
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