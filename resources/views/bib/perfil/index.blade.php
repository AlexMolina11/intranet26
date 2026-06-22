@extends('layouts.app')

@section('title', 'Mi Biblioteca')
@section('page-title', 'Mi Biblioteca')
@section('page-subtitle', 'Resumen personal de préstamos, solicitudes y multas')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Mi Biblioteca</h1>
            <p class="page-subtitle">
                Bienvenido, <strong>{{ $usuario->nombre_completo }}</strong>. Aquí puedes revisar tu actividad bibliográfica.
            </p>
        </div>

        <div class="page-header-actions">
            @if(Route::has('bib.consulta.index'))
                <a href="{{ route('bib.consulta.index') }}" class="btn btn-primary">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Buscar recursos
                </a>
            @endif

            @if(Route::has('bib.solicitudes.create') && auth()->user()->tienePermiso('BIB_SOLICITUDES_CREAR'))
                <a href="{{ route('bib.solicitudes.create') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    Nueva solicitud
                </a>
            @endif
        </div>
    </div>

    @if($prestamosPorVencer > 0 || $prestamosVencidos > 0 || $multasPendientesCantidad > 0)
        <div class="card" style="margin-bottom:20px;">
            <h2 style="margin-top:0; font-size:18px;">Alertas de mi biblioteca</h2>

            @if($prestamosPorVencer > 0)
                <div class="alert alert-warning">
                    <strong>Próximos a vencer:</strong>
                    Tienes {{ $prestamosPorVencer }} préstamo(s) próximos a vencer.
                </div>
            @endif

            @if($prestamosVencidos > 0)
                <div class="alert alert-danger">
                    <strong>Préstamos vencidos:</strong>
                    Tienes {{ $prestamosVencidos }} préstamo(s) vencidos.
                </div>
            @endif

            @if($multasPendientesCantidad > 0)
                <div class="alert alert-danger">
                    <strong>Multas pendientes:</strong>
                    Tienes multas pendientes de pago.
                </div>
            @endif
        </div>
    @endif

    <div class="stats-grid" style="margin-bottom:20px;">
        <div class="stat-card">
            <div class="stat-title">Préstamos activos</div>
            <div class="stat-value">{{ $prestamosActivos->count() }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Solicitudes recientes</div>
            <div class="stat-value">{{ $solicitudes->count() }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Multas pendientes</div>
            <div class="stat-value">{{ $multasPendientes->count() }}</div>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h2 style="margin:0; font-size:20px;">Recursos actualmente prestados</h2>
                <p class="page-subtitle">Recursos que tienes en disposición actualmente.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Recurso</th>
                        <th>Ejemplar</th>
                        <th>Estado</th>
                        <th>Fecha préstamo</th>
                        <th>Fecha vencimiento</th>
                        <th>Renovaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamosActivos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->recurso?->titulo ?? 'N/D' }}</td>
                            <td>{{ $prestamo->ejemplar?->codigo_inventario ?? 'N/D' }}</td>
                            <td>{{ $prestamo->estadoPrestamo?->nombre ?? 'N/D' }}</td>
                            <td>{{ optional($prestamo->fecha_prestamo)->format('d/m/Y') ?? 'N/D' }}</td>
                            <td>{{ optional($prestamo->fecha_vencimiento)->format('d/m/Y') ?? 'N/D' }}</td>
                            <td>
                                {{ $prestamo->renovaciones_usadas ?? 0 }}
                                /
                                {{ $prestamo->renovaciones_maximas ?? 0 }}
                            </td>
                            <td>
                                @if(
                                    $prestamo->estadoPrestamo?->codigo === 'ENTREGADO'
                                    && !$prestamo->fecha_devolucion
                                    && (int) $prestamo->renovaciones_usadas < (int) $prestamo->renovaciones_maximas
                                    && $multasPendientes->count() === 0
                                )
                                    <form method="POST" action="{{ route('bib.perfil.prestamos.renovar', $prestamo) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            Renovar
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">No disponible</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No tienes préstamos activos actualmente.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h2 style="margin:0; font-size:20px;">Mis solicitudes recientes</h2>
                <p class="page-subtitle">Últimas solicitudes realizadas en Biblioteca.</p>
            </div>

            @if(Route::has('bib.solicitudes.index'))
                <div class="page-header-actions">
                    <a href="{{ route('bib.solicitudes.index') }}" class="btn btn-secondary">
                        Ver todas
                    </a>
                </div>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Recurso</th>
                        <th>Ejemplar</th>
                        <th>Estado</th>
                        <th>Fecha solicitud</th>
                        <th>Fecha requerida</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->recurso?->titulo ?? 'N/D' }}</td>
                            <td>{{ $solicitud->ejemplar?->codigo_inventario ?? 'N/D' }}</td>
                            <td>{{ $solicitud->estadoSolicitud?->nombre ?? 'N/D' }}</td>
                            <td>{{ optional($solicitud->fecha_solicitud)->format('d/m/Y') ?? 'N/D' }}</td>
                            <td>{{ optional($solicitud->fecha_requerida)->format('d/m/Y') ?? 'N/D' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No tienes solicitudes registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h2 style="margin:0; font-size:20px;">Multas pendientes</h2>
                <p class="page-subtitle">Multas generadas por atrasos o incidencias.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Recurso</th>
                        <th>Fecha multa</th>
                        <th>Días atraso</th>
                        <th>Monto</th>
                        <th>Monto pagado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($multasPendientes as $multa)
                        <tr>
                            <td>{{ $multa->prestamo?->recurso?->titulo ?? 'N/D' }}</td>
                            <td>{{ optional($multa->fecha_multa)->format('d/m/Y') ?? 'N/D' }}</td>
                            <td>{{ $multa->dias_atraso ?? 0 }}</td>
                            <td>${{ number_format((float) $multa->monto, 2) }}</td>
                            <td>${{ number_format((float) $multa->monto_pagado, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No tienes multas pendientes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h2 style="margin:0; font-size:20px;">Historial reciente</h2>
                <p class="page-subtitle">Últimos préstamos devueltos.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Recurso</th>
                        <th>Ejemplar</th>
                        <th>Fecha préstamo</th>
                        <th>Fecha devolución</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historialPrestamos as $prestamo)
                        <tr>
                            <td>{{ $prestamo->recurso?->titulo ?? 'N/D' }}</td>
                            <td>{{ $prestamo->ejemplar?->codigo_inventario ?? 'N/D' }}</td>
                            <td>{{ optional($prestamo->fecha_prestamo)->format('d/m/Y') ?? 'N/D' }}</td>
                            <td>{{ optional($prestamo->fecha_devolucion)->format('d/m/Y') ?? 'N/D' }}</td>
                            <td>{{ $prestamo->estadoPrestamo?->nombre ?? 'N/D' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Todavía no tienes historial de préstamos devueltos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection