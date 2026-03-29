@extends('layouts.app')

@section('title', 'Dashboard Tickets')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Dashboard Tickets</h1>
            <p class="page-subtitle">Resumen operativo del sistema de tickets</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('TIK_TICKETS_CREAR'))
                <a href="{{ route('tik.tickets.create') }}" class="btn btn-primary">
                    Nuevo ticket
                </a>
            @endif

            @if(auth()->user()->tienePermiso('TIK_SOPORTES_CREAR') && \Illuminate\Support\Facades\Route::has('tik.soportes.create'))
                <a href="{{ route('tik.soportes.create') }}" class="btn btn-secondary">
                    Nuevo soporte
                </a>
            @endif
        </div>
    </div>

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
                <div class="stat-title">Tickets asignados a mí</div>
                <div class="stat-value">{{ $ticketsAsignados }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-title">Tickets en proceso</div>
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
                <p class="page-subtitle">Distribución actual de tickets en el sistema</p>
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
                            <td>{{ $fila->estadoTicket->nombre ?? 'Sin estado' }}</td>
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
                <p class="page-subtitle">Últimos movimientos registrados</p>
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
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ticketsRecientes as $ticket)
                        <tr>
                            <td>{{ $ticket->id_ticket }}</td>
                            <td>{{ $ticket->fecha_ticket }}</td>
                            <td>{{ $ticket->tipoTicket->nombre ?? '-' }}</td>
                            <td>{{ $ticket->estadoTicket->nombre ?? '-' }}</td>
                            <td>{{ $ticket->asunto }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No hay tickets recientes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection