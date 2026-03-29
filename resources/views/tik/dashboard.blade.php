@extends('layouts.app')

@section('title', 'Dashboard Tickets')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Dashboard Tickets</h1>
            <p class="page-subtitle">Resumen operativo y accesos rápidos del sistema de tickets</p>
        </div>
    </div>

    @if($accesosRapidos->isNotEmpty())
        <div class="card">
            <div class="page-header" style="margin-bottom:16px;">
                <div class="page-header-text">
                    <h1 style="font-size:20px; margin:0;">Accesos rápidos</h1>
                    <p class="page-subtitle">Opciones disponibles según tu perfil</p>
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
            <div class="stat-title">Mis tickets</div>
            <div class="stat-value">{{ $misTicketsTotal }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Mis tickets abiertos</div>
            <div class="stat-value">{{ $misTicketsAbiertos }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-title">Mis tickets cerrados</div>
            <div class="stat-value">{{ $misTicketsCerrados }}</div>
        </div>

        @if(auth()->user()->tienePermiso('TIK_TICKETS_GESTOR_VER'))
            <div class="stat-card">
                <div class="stat-title">Asignados a mí</div>
                <div class="stat-value">{{ $ticketsAsignados }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">En proceso</div>
                <div class="stat-value">{{ $ticketsEnProceso }}</div>
            </div>
        @endif

        @if(auth()->user()->tienePermiso('TIK_TICKETS_ADMIN_VER'))
            <div class="stat-card">
                <div class="stat-title">Pendientes de asignación</div>
                <div class="stat-value">{{ $pendientesAsignacion }}</div>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h1 style="font-size:20px; margin:0;">Tickets por estado</h1>
                <p class="page-subtitle">Distribución actual del sistema</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Código</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ticketsPorEstado as $fila)
                        <tr>
                            <td>
                                <span class="badge"
                                      style="background: {{ $fila->estadoTicket->color ?? '#ece9ea' }}22; color: {{ $fila->estadoTicket->color ?? '#4b4a4b' }}; border: 1px solid {{ $fila->estadoTicket->color ?? '#4b4a4b' }}33;">
                                    {{ $fila->estadoTicket->nombre ?? 'Sin estado' }}
                                </span>
                            </td>
                            <td>{{ $fila->estadoTicket->codigo ?? '-' }}</td>
                            <td>{{ $fila->total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No hay datos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="page-header" style="margin-bottom:16px;">
            <div class="page-header-text">
                <h1 style="font-size:20px; margin:0;">Tickets recientes</h1>
                <p class="page-subtitle">Últimos tickets registrados en el sistema</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Asunto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ticketsRecientes as $ticket)
                        <tr>
                            <td>{{ $ticket->id_ticket }}</td>
                            <td>{{ $ticket->fecha_ticket }}</td>
                            <td>{{ $ticket->tipoTicket->nombre ?? '-' }}</td>
                            <td>
                                <span class="badge"
                                      style="background: {{ $ticket->estadoTicket->color ?? '#ece9ea' }}22; color: {{ $ticket->estadoTicket->color ?? '#4b4a4b' }}; border: 1px solid {{ $ticket->estadoTicket->color ?? '#4b4a4b' }}33;">
                                    {{ $ticket->estadoTicket->nombre ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $ticket->asunto }}</td>
                            <td>
                                @if(Route::has('tik.tickets.show') && auth()->user()->tienePermiso('TIK_TICKETS_DETALLE'))
                                    <a href="{{ route('tik.tickets.show', $ticket->id_ticket) }}" class="btn btn-secondary">
                                        Ver
                                    </a>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay tickets recientes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection