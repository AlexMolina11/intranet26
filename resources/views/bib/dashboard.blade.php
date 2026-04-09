@extends('layouts.app')

@section('title', 'Dashboard Biblioteca')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Dashboard Biblioteca</h1>
            <p class="page-subtitle">Resumen operativo del sistema bibliográfico</p>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="alert alert-info" style="margin:0;">
            Bienvenido, <strong>{{ $usuario->nombre_completo }}</strong>. Aquí tienes el estado actual de recursos, circulación y sanciones del módulo Biblioteca.
        </div>
    </div>

    @if($accesosRapidos->isNotEmpty())
        <div class="card" style="margin-bottom:20px;">
            <div class="page-header" style="margin-bottom:16px;">
                <div class="page-header-text">
                    <h2 style="margin:0; font-size:20px;">Accesos rápidos</h2>
                    <p class="page-subtitle">Atajos disponibles según tus permisos</p>
                </div>
            </div>

            <div class="page-header-actions">
                @foreach($accesosRapidos as $acceso)
                    <a href="{{ route($acceso['route']) }}" class="btn btn-primary">
                        <i class="{{ $acceso['icon'] }}"></i>
                        {{ $acceso['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">Recursos</div>
            <div class="stat-value">{{ $totalRecursos }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Ejemplares</div>
            <div class="stat-value">{{ $totalEjemplares }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Disponibles</div>
            <div class="stat-value">{{ $ejemplaresDisponibles }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Solicitudes pendientes</div>
            <div class="stat-value">{{ $solicitudesPendientes }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Préstamos activos</div>
            <div class="stat-value">{{ $prestamosActivos }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Préstamos vencidos</div>
            <div class="stat-value">{{ $prestamosVencidos }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Multas pendientes</div>
            <div class="stat-value">{{ $multasPendientes }}</div>
        </div>
    </div>

    <div class="card">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h2 style="margin:0; font-size:20px;">Préstamos recientes</h2>
                <p class="page-subtitle">Últimos movimientos registrados en circulación</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Recurso</th>
                        <th>Fecha préstamo</th>
                        <th>Fecha vencimiento</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamosRecientes as $prestamo)
                        <tr>
                            <td>{{ $prestamo->id_prestamo }}</td>
                            <td>{{ $prestamo->usuario->nombre_completo ?? '-' }}</td>
                            <td>{{ $prestamo->recurso->titulo ?? '-' }}</td>
                            <td>{{ optional($prestamo->fecha_prestamo)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ optional($prestamo->fecha_vencimiento)->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                @php
                                    $estado = $prestamo->estadoPrestamo->nombre ?? 'Sin estado';
                                    $codigoEstado = $prestamo->estadoPrestamo->codigo ?? null;
                                @endphp

                                <span class="badge">
                                    {{ $estado }}
                                    @if($codigoEstado === 'ENTREGADO' && is_null($prestamo->fecha_devolucion) && $prestamo->fecha_vencimiento && $prestamo->fecha_vencimiento->isPast())
                                        - vencido
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if(Route::has('bib.prestamos.edit') && auth()->user()->tienePermiso('BIB_PRESTAMOS_VER'))
                                    <a href="{{ route('bib.prestamos.edit', $prestamo->id_prestamo) }}" class="btn btn-secondary">
                                        Ver
                                    </a>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay préstamos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection