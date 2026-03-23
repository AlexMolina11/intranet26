@extends('layouts.app')

@section('title', 'Detalle del ticket asignado')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Detalle del ticket asignado</h1>
                <p class="page-subtitle">{{ $ticket->codigo }} — {{ $ticket->asunto }}</p>
            </div>

            <div class="page-header-actions" style="display:flex; gap:10px;">
                <a href="{{ route('tik.gestor.tickets.index') }}" class="btn btn-secondary">Volver al panel</a>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:16px; margin-top:20px;">
            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Datos del ticket</h3>
                <p><strong>Código:</strong> {{ $ticket->codigo }}</p>
                <p><strong>Asunto:</strong> {{ $ticket->asunto }}</p>
                <p><strong>Descripción:</strong><br>{{ $ticket->descripcion }}</p>
                <p><strong>Tipo:</strong> {{ $ticket->tipoTicket?->nombre }}</p>
                <p><strong>Estado:</strong> {{ $ticket->estadoTicket?->nombre }}</p>
                <p><strong>Clasificación:</strong>
                    @if ($ticket->no_aplica)
                        No aplica
                    @elseif ($ticket->es_proyecto)
                        Proyecto
                    @else
                        Normal
                    @endif
                </p>
            </div>

            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Participantes</h3>
                <p><strong>Solicitante:</strong> {{ trim(($ticket->solicitante?->nombres ?? '') . ' ' . ($ticket->solicitante?->apellidos ?? '')) }}</p>
                <p><strong>Responsable:</strong> {{ trim(($ticket->responsable?->nombres ?? '') . ' ' . ($ticket->responsable?->apellidos ?? '')) }}</p>
                <p><strong>Asignado por:</strong>
                    @if ($ticket->asignador)
                        {{ trim(($ticket->asignador->nombres ?? '') . ' ' . ($ticket->asignador->apellidos ?? '')) }}
                    @else
                        N/D
                    @endif
                </p>
                <p><strong>Área responsable:</strong> {{ $ticket->areaResponsable?->nombre ?? 'N/D' }}</p>
            </div>
        </div>

        <div style="margin-top:24px;">
            <div class="card" style="padding:16px;">
                <h2 style="margin-top:0;">Historial</h2>

                @forelse ($ticket->seguimientos as $seguimiento)
                    <div class="card" style="padding:14px; margin-top:12px;">
                        <p style="margin:0 0 8px 0;">
                            <strong>Usuario:</strong>
                            {{ trim(($seguimiento->usuario?->nombres ?? '') . ' ' . ($seguimiento->usuario?->apellidos ?? '')) }}
                        </p>
                        <p style="margin:0 0 8px 0;">
                            <strong>Estado anterior:</strong> {{ $seguimiento->estadoAnterior?->nombre ?? 'Sin definir' }}
                        </p>
                        <p style="margin:0 0 8px 0;">
                            <strong>Estado nuevo:</strong> {{ $seguimiento->estadoNuevo?->nombre ?? 'Sin definir' }}
                        </p>
                        <p style="margin:0;">
                            <strong>Comentario:</strong> {{ $seguimiento->comentario ?? 'Sin comentario' }}
                        </p>
                    </div>
                @empty
                    <p>No hay seguimientos registrados.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection