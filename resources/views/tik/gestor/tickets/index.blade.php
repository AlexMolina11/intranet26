@extends('layouts.app')

@section('title', 'Panel gestor de tickets')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Panel gestor de tickets</h1>
                <p class="page-subtitle">Tickets asignados al usuario gestor</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('tik.tickets.index') }}" class="btn btn-secondary">Mis tickets</a>
            </div>
        </div>

        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:20px;">
            <a href="{{ route('tik.gestor.tickets.index', ['filtro' => 'asignados']) }}"
               class="btn {{ $filtro === 'asignados' ? 'btn-primary' : 'btn-secondary' }}">
                Activos
            </a>

            <a href="{{ route('tik.gestor.tickets.index', ['filtro' => 'proyectos']) }}"
               class="btn {{ $filtro === 'proyectos' ? 'btn-primary' : 'btn-secondary' }}">
                Proyectos
            </a>

            <a href="{{ route('tik.gestor.tickets.index', ['filtro' => 'cerrados']) }}"
               class="btn {{ $filtro === 'cerrados' ? 'btn-primary' : 'btn-secondary' }}">
                Cerrados
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
                                @if ($ticket->no_aplica)
                                    No aplica
                                @elseif ($ticket->es_proyecto)
                                    Proyecto
                                @else
                                    Normal
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('tik.gestor.tickets.show', $ticket->id_ticket) }}" class="btn btn-sm btn-secondary">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay tickets en este panel.</td>
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