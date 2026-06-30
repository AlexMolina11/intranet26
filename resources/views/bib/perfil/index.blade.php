@extends('layouts.app')

@section('title', 'Mi Biblioteca')
@section('page-title', 'Mi Biblioteca')
@section('page-subtitle', 'Resumen personal de préstamos, solicitudes y multas')

@section('content')
    @include('bib.partials._perfil_styles')

    <div class="bib-profile-hero">
        <div>
            <h1>Mi Biblioteca</h1>
            <p>
                Bienvenido, <strong>{{ $usuario->nombre_completo }}</strong>. Revisa tu estado bibliotecario y realiza tus acciones principales desde aquí.
            </p>
        </div>

        <div class="bib-profile-actions">
            @if(Route::has('bib.consulta.index'))
                <a href="{{ route('bib.consulta.index') }}" class="btn btn-light">
                    <i class="fa-solid fa-magnifying-glass me-1"></i>
                    Buscar recursos
                </a>
            @endif

            @if(Route::has('bib.solicitudes.create') && auth()->user()->tienePermiso('BIB_SOLICITUDES_CREAR'))
                <a href="{{ route('bib.solicitudes.create') }}" class="btn btn-warning">
                    <i class="fa-solid fa-file-circle-plus me-1"></i>
                    Nueva solicitud
                </a>
            @endif
        </div>
    </div>

    @if($prestamosPorVencer > 0 || $prestamosVencidos > 0 || $multasPendientesCantidad > 0)
        <div class="bib-alert-grid">
            @if($prestamosPorVencer > 0)
                <div class="bib-alert-card is-warning">
                    <div class="bib-alert-title">
                        <i class="fa-solid fa-clock me-1"></i>
                        Préstamos por vencer
                    </div>
                    <p class="bib-alert-text">Tienes {{ $prestamosPorVencer }} préstamo(s) próximos a vencer.</p>
                </div>
            @endif

            @if($prestamosVencidos > 0)
                <div class="bib-alert-card is-danger">
                    <div class="bib-alert-title">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i>
                        Préstamos vencidos
                    </div>
                    <p class="bib-alert-text">Tienes {{ $prestamosVencidos }} préstamo(s) vencidos. Acércate a Biblioteca para regularizar tu estado.</p>
                </div>
            @endif

            @if($multasPendientesCantidad > 0)
                <div class="bib-alert-card is-danger">
                    <div class="bib-alert-title">
                        <i class="fa-solid fa-circle-dollar-to-slot me-1"></i>
                        Multas pendientes
                    </div>
                    <p class="bib-alert-text">Tienes multas pendientes por ${{ number_format((float) $montoMultasPendientes, 2) }}.</p>
                </div>
            @endif
        </div>
    @endif

    <div class="bib-summary-grid">
        <div class="bib-summary-card">
            <div>
                <div class="bib-summary-icon"><i class="fa-solid fa-book-open-reader"></i></div>
                <div class="bib-summary-title">Préstamos activos</div>
                <div class="bib-summary-value">{{ $prestamosActivos->count() }}</div>
            </div>
            <div class="bib-summary-note">{{ $prestamosPorVencer }} por vencer / {{ $prestamosVencidos }} vencidos</div>
        </div>

        <div class="bib-summary-card">
            <div>
                <div class="bib-summary-icon"><i class="fa-solid fa-file-lines"></i></div>
                <div class="bib-summary-title">Solicitudes recientes</div>
                <div class="bib-summary-value">{{ $solicitudes->count() }}</div>
            </div>
            <div class="bib-summary-note">{{ $solicitudesPendientes }} pendientes / {{ $solicitudesAprobadas }} aprobadas</div>
        </div>

        <div class="bib-summary-card">
            <div>
                <div class="bib-summary-icon"><i class="fa-solid fa-coins"></i></div>
                <div class="bib-summary-title">Multas pendientes</div>
                <div class="bib-summary-value">{{ $multasPendientes->count() }}</div>
            </div>
            <div class="bib-summary-note">Saldo pendiente: ${{ number_format((float) $montoMultasPendientes, 2) }}</div>
        </div>

        <div class="bib-summary-card">
            <div>
                <div class="bib-summary-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                <div class="bib-summary-title">Historial reciente</div>
                <div class="bib-summary-value">{{ $historialPrestamos->count() }}</div>
            </div>
            <div class="bib-summary-note">Últimos préstamos devueltos</div>
        </div>
    </div>

    <div class="bib-content-grid">
        <div>
            <div class="bib-section-card">
                <div class="bib-section-header">
                    <div>
                        <h2>Recursos actualmente prestados</h2>
                        <p>Recursos que tienes en disposición actualmente.</p>
                    </div>
                </div>

                <div class="bib-section-body table-responsive">
                    <table class="table bib-clean-table">
                        <thead>
                            <tr>
                                <th>Recurso</th>
                                <th>Vencimiento</th>
                                <th>Renovaciones</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prestamosActivos as $prestamo)
                                @php
                                    $estaVencido = $prestamo->fecha_vencimiento && $prestamo->fecha_vencimiento->isPast() && !$prestamo->fecha_vencimiento->isToday();
                                    $puedeRenovar = $prestamo->estadoPrestamo?->codigo === 'ENTREGADO'
                                        && !$prestamo->fecha_devolucion
                                        && (int) $prestamo->renovaciones_usadas < (int) $prestamo->renovaciones_maximas
                                        && $multasPendientes->count() === 0
                                        && !$estaVencido;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="bib-resource-title">{{ $prestamo->recurso?->titulo ?? 'N/D' }}</div>
                                        <div class="bib-resource-meta">Ejemplar: {{ $prestamo->ejemplar?->codigo_inventario ?? 'N/D' }}</div>
                                    </td>
                                    <td>
                                        {{ optional($prestamo->fecha_vencimiento)->format('d/m/Y') ?? 'N/D' }}
                                        @if($estaVencido)
                                            <div class="bib-muted-help text-danger">Vencido</div>
                                        @endif
                                    </td>
                                    <td>{{ $prestamo->renovaciones_usadas ?? 0 }} / {{ $prestamo->renovaciones_maximas ?? 0 }}</td>
                                    <td>
                                        <span class="bib-badge {{ $estaVencido ? 'is-danger' : 'is-ok' }}">
                                            {{ $estaVencido ? 'Vencido' : ($prestamo->estadoPrestamo?->nombre ?? 'N/D') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($puedeRenovar)
                                            <form method="POST" action="{{ route('bib.perfil.prestamos.renovar', $prestamo) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fa-solid fa-rotate me-1"></i>
                                                    Renovar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">No disponible</span>
                                            @if($multasPendientes->count() > 0)
                                                <div class="bib-muted-help">Renovación bloqueada por multa pendiente.</div>
                                            @elseif($estaVencido)
                                                <div class="bib-muted-help">El préstamo vencido debe gestionarse en Biblioteca.</div>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="bib-empty-state">
                                            <i class="fa-solid fa-book-open"></i>
                                            <div>No tienes préstamos activos actualmente.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bib-section-card">
                <div class="bib-section-header">
                    <div>
                        <h2>Mis solicitudes recientes</h2>
                        <p>Últimas solicitudes realizadas en Biblioteca.</p>
                    </div>

                    @if(Route::has('bib.solicitudes.index'))
                        <a href="{{ route('bib.solicitudes.index') }}" class="btn btn-sm btn-secondary">Ver todas</a>
                    @endif
                </div>

                <div class="bib-section-body table-responsive">
                    <table class="table bib-clean-table">
                        <thead>
                            <tr>
                                <th>Recurso</th>
                                <th>Fecha requerida</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($solicitudes as $solicitud)
                                @php
                                    $estadoSolicitud = $solicitud->estadoSolicitud?->codigo;
                                    $estadoClass = match ($estadoSolicitud) {
                                        'APROBADA' => 'is-ok',
                                        'RECHAZADA', 'CANCELADA' => 'is-danger',
                                        default => 'is-warning',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <div class="bib-resource-title">{{ $solicitud->recurso?->titulo ?? 'N/D' }}</div>
                                        <div class="bib-resource-meta">Solicitada: {{ optional($solicitud->fecha_solicitud)->format('d/m/Y') ?? 'N/D' }}</div>
                                    </td>
                                    <td>{{ optional($solicitud->fecha_requerida)->format('d/m/Y') ?? 'N/D' }}</td>
                                    <td><span class="bib-badge {{ $estadoClass }}">{{ $solicitud->estadoSolicitud?->nombre ?? 'N/D' }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="bib-empty-state">
                                            <i class="fa-solid fa-file-circle-plus"></i>
                                            <div>No tienes solicitudes registradas.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div>
            <div class="bib-section-card">
                <div class="bib-section-header">
                    <div>
                        <h2>Multas pendientes</h2>
                        <p>Multas generadas por atrasos o incidencias.</p>
                    </div>
                </div>

                <div class="bib-section-body table-responsive">
                    <table class="table bib-clean-table">
                        <thead>
                            <tr>
                                <th>Detalle</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($multasPendientes as $multa)
                                @php
                                    $saldo = max((float) $multa->monto - (float) $multa->monto_pagado, 0);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="bib-resource-title">{{ $multa->prestamo?->recurso?->titulo ?? 'N/D' }}</div>
                                        <div class="bib-resource-meta">
                                            {{ optional($multa->fecha_multa)->format('d/m/Y') ?? 'N/D' }} · {{ $multa->dias_atraso ?? 0 }} día(s) atraso
                                        </div>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($saldo, 2) }}</strong>
                                        <div class="bib-muted-help">Pagado: ${{ number_format((float) $multa->monto_pagado, 2) }}</div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">
                                        <div class="bib-empty-state">
                                            <i class="fa-solid fa-circle-check"></i>
                                            <div>No tienes multas pendientes.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bib-section-card">
                <div class="bib-section-header">
                    <div>
                        <h2>Historial reciente</h2>
                        <p>Últimos préstamos devueltos.</p>
                    </div>
                </div>

                <div class="bib-section-body table-responsive">
                    <table class="table bib-clean-table">
                        <thead>
                            <tr>
                                <th>Recurso</th>
                                <th>Devolución</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($historialPrestamos as $prestamo)
                                <tr>
                                    <td>
                                        <div class="bib-resource-title">{{ $prestamo->recurso?->titulo ?? 'N/D' }}</div>
                                        <div class="bib-resource-meta">{{ $prestamo->estadoPrestamo?->nombre ?? 'N/D' }}</div>
                                    </td>
                                    <td>{{ optional($prestamo->fecha_devolucion)->format('d/m/Y') ?? 'N/D' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">
                                        <div class="bib-empty-state">
                                            <i class="fa-solid fa-clock-rotate-left"></i>
                                            <div>Todavía no tienes historial de préstamos devueltos.</div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
