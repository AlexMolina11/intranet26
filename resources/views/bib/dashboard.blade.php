@extends('layouts.app')

@section('title', 'Dashboard Biblioteca')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Dashboard Biblioteca</h1>
            <p class="page-subtitle">Resumen operativo del sistema bibliográfico, circulación, solicitudes y multas.</p>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <div class="alert alert-info" style="margin:0;">
            Bienvenido, <strong>{{ $usuario->nombre_completo }}</strong>. Aquí tienes el estado actual del módulo Biblioteca.
        </div>
    </div>

    @if($accesosRapidos->isNotEmpty())
        <div class="card" style="margin-bottom:20px;">
            <div class="page-header" style="margin-bottom:16px;">
                <div class="page-header-text">
                    <h2 style="margin:0; font-size:20px;">Accesos rápidos</h2>
                    <p class="page-subtitle">Atajos disponibles según tus permisos.</p>
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
            <div class="stat-title">Prestados</div>
            <div class="stat-value">{{ $ejemplaresPrestados }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Solicitudes pendientes</div>
            <div class="stat-value">{{ $solicitudesPendientes }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Pendientes de entrega</div>
            <div class="stat-value">{{ $prestamosPendientesEntrega }}</div>
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

    <div class="card" style="margin-top:20px;">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h2 style="margin:0; font-size:20px;">Préstamos recientes</h2>
                <p class="page-subtitle">Últimos registros de circulación.</p>
            </div>
        </div>

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
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prestamosRecientes as $prestamo)
                        @php
                            $codigoEstado = $prestamo->estadoPrestamo?->codigo;
                            $estaVencido = $codigoEstado === 'ENTREGADO'
                                && is_null($prestamo->fecha_devolucion)
                                && $prestamo->fecha_vencimiento
                                && $prestamo->fecha_vencimiento->lt(now()->startOfDay());
                        @endphp

                        <tr>
                            <td>{{ $prestamo->id_prestamo }}</td>
                            <td>{{ $prestamo->usuario?->nombre_completo ?? '-' }}</td>
                            <td>{{ $prestamo->recurso?->titulo ?? '-' }}</td>
                            <td>{{ $prestamo->ejemplar?->codigo_inventario ?? '-' }}</td>
                            <td>{{ optional($prestamo->fecha_prestamo)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ optional($prestamo->fecha_vencimiento)->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                <span class="badge">
                                    {{ $prestamo->estadoPrestamo?->nombre ?? 'Sin estado' }}
                                    @if($estaVencido)
                                        - vencido
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if(Route::has('bib.prestamos.edit') && auth()->user()->tienePermiso('BIB_PRESTAMOS_VER'))
                                    <a href="{{ route('bib.prestamos.edit', $prestamo) }}" class="btn btn-secondary">
                                        Ver
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No hay préstamos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-top:20px;">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h2 style="margin:0; font-size:20px;">Solicitudes recientes</h2>
                <p class="page-subtitle">Últimas solicitudes registradas.</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Recurso</th>
                        <th>Fecha solicitud</th>
                        <th>Fecha requerida</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudesRecientes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->id_solicitud }}</td>
                            <td>{{ $solicitud->usuario?->nombre_completo ?? '-' }}</td>
                            <td>{{ $solicitud->recurso?->titulo ?? '-' }}</td>
                            <td>{{ optional($solicitud->fecha_solicitud)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ optional($solicitud->fecha_requerida)->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                <span class="badge">
                                    {{ $solicitud->estadoSolicitud?->nombre ?? 'Sin estado' }}
                                </span>
                            </td>
                            <td>
                                @if(Route::has('bib.solicitudes.edit') && auth()->user()->tienePermiso('BIB_SOLICITUDES_VER'))
                                    <a href="{{ route('bib.solicitudes.edit', $solicitud) }}" class="btn btn-secondary">
                                        Ver
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay solicitudes registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card" style="margin-top:20px;">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h2 style="margin:0; font-size:20px;">Multas recientes</h2>
                <p class="page-subtitle">Últimas multas registradas por atraso.</p>
            </div>
        </div>

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
                        <th>Pagada</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($multasRecientes as $multa)
                        <tr>
                            <td>{{ $multa->id_multa }}</td>
                            <td>{{ $multa->usuario?->nombre_completo ?? '-' }}</td>
                            <td>{{ $multa->prestamo?->recurso?->titulo ?? '-' }}</td>
                            <td>{{ optional($multa->fecha_multa)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $multa->dias_atraso }}</td>
                            <td>${{ number_format((float) $multa->monto, 2) }}</td>
                            <td>{{ $multa->pagada ? 'Sí' : 'No' }}</td>
                            <td>
                                @if(Route::has('bib.multas.edit') && auth()->user()->tienePermiso('BIB_MULTAS_VER'))
                                    <a href="{{ route('bib.multas.edit', $multa) }}" class="btn btn-secondary">
                                        Ver
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No hay multas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection