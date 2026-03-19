@extends('layouts.app')

@section('title', 'Detalle de ticket')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Detalle de ticket</h1>
                <p class="page-subtitle">{{ $ticket->codigo }} — {{ $ticket->asunto }}</p>
            </div>
            <div class="page-header-actions" style="display:flex; gap:10px;">
                <a href="{{ route('tik.tickets.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="margin-top:16px;">
                {{ session('success') }}
            </div>
        @endif

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:16px; margin-top:20px;">
            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Datos generales</h3>
                <p><strong>Código:</strong> {{ $ticket->codigo }}</p>
                <p><strong>Asunto:</strong> {{ $ticket->asunto }}</p>
                <p><strong>Descripción:</strong><br>{{ $ticket->descripcion }}</p>
                <p><strong>Tipo:</strong> {{ $ticket->tipoTicket?->nombre }}</p>
                <p><strong>Tipo RRHH:</strong> {{ $ticket->tipoTicketRrhh?->nombre ?? 'N/D' }}</p>
                <p><strong>Formato:</strong> {{ $ticket->formatoTicket?->nombre }}</p>
                <p><strong>Estado:</strong> {{ $ticket->estadoTicket?->nombre }}</p>
            </div>

            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Participantes</h3>
                <p><strong>Solicitante:</strong> {{ trim(($ticket->solicitante?->nombres ?? '') . ' ' . ($ticket->solicitante?->apellidos ?? '')) }}</p>
                <p><strong>Responsable:</strong>
                    @if($ticket->responsable)
                        {{ trim(($ticket->responsable->nombres ?? '') . ' ' . ($ticket->responsable->apellidos ?? '')) }}
                    @else
                        Sin asignar
                    @endif
                </p>
                <p><strong>Área solicitante:</strong> {{ $ticket->areaSolicitante?->nombre ?? 'N/D' }}</p>
                <p><strong>Área responsable:</strong> {{ $ticket->areaResponsable?->nombre ?? 'N/D' }}</p>
            </div>

            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Fechas</h3>
                <p><strong>Registro:</strong> {{ $ticket->fecha_registro_formateada }}</p>
                <p><strong>Fecha ticket:</strong> {{ $ticket->fecha_ticket_formateada }}</p>
                <p><strong>Cierre:</strong> {{ $ticket->fecha_cierre_formateada }}</p>
            </div>
        </div>

        <div style="margin-top:20px;">
            <button type="button" class="btn btn-danger" onclick="cancelarTicket({{ $ticket->id_ticket }})">
                Cancelar ticket
            </button>
        </div>
    </div>

    <script>
        async function cancelarTicket(idTicket) {
            if (!confirm('¿Deseas cancelar este ticket?')) {
                return;
            }

            const response = await fetch(`/tik/tickets/${idTicket}/cancelar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const data = await response.json();

            alert(data.message.replace(/<[^>]+>/g, ''));
            if (data.success) {
                window.location.reload();
            }
        }
    </script>
@endsection