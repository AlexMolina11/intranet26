@extends('layouts.app')

@section('title', 'Panel administrador de tickets')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Panel administrador de tickets</h1>
                <p class="page-subtitle">Gestión departamental de tickets pendientes y clasificados</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('tik.tickets.index') }}" class="btn btn-secondary">Mis tickets</a>
            </div>
        </div>

        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:20px;">
            <a href="{{ route('tik.admin.tickets.index', ['filtro' => 'pendientes']) }}"
               class="btn {{ $filtro === 'pendientes' ? 'btn-primary' : 'btn-secondary' }}">
                Pendientes de asignación
            </a>

            <a href="{{ route('tik.admin.tickets.index', ['filtro' => 'proyectos']) }}"
               class="btn {{ $filtro === 'proyectos' ? 'btn-primary' : 'btn-secondary' }}">
                Proyectos
            </a>

            <a href="{{ route('tik.admin.tickets.index', ['filtro' => 'no_aplica']) }}"
               class="btn {{ $filtro === 'no_aplica' ? 'btn-primary' : 'btn-secondary' }}">
                No aplica
            </a>
        </div>

        <div style="margin-top:24px;" class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Asunto</th>
                        <th>Solicitante</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th>Responsable</th>
                        <th>Clasificación</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->codigo }}</td>
                            <td>{{ $ticket->asunto }}</td>
                            <td>{{ trim(($ticket->solicitante?->nombres ?? '') . ' ' . ($ticket->solicitante?->apellidos ?? '')) }}</td>
                            <td>{{ $ticket->tipoTicket?->nombre }}</td>
                            <td>{{ $ticket->estadoTicket?->nombre }}</td>
                            <td>
                                @if ($ticket->responsable)
                                    {{ trim(($ticket->responsable->nombres ?? '') . ' ' . ($ticket->responsable->apellidos ?? '')) }}
                                @else
                                    Sin asignar
                                @endif
                            </td>
                            <td>
                                @if ($ticket->no_aplica)
                                    No aplica
                                @elseif ($ticket->es_proyecto)
                                    Proyecto
                                @else
                                    Normal
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('tik.admin.tickets.show', $ticket->id_ticket) }}" class="btn btn-sm btn-secondary">Gestionar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No hay tickets para este filtro.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $tickets->links() }}
        </div>
    </div>
@endsection