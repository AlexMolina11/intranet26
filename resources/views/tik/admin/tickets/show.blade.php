@extends('layouts.app')

@section('title', 'Gestión administrativa del ticket')

@section('content')
    @php
        $colorEstado = $ticket->estadoTicket?->color ?? '#6c757d';
    @endphp

    <style>
        .ticket-show-wrap {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .ticket-hero {
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            background: #ffffff;
            padding: 24px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .ticket-hero-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 18px;
        }

        .ticket-code {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .ticket-title {
            margin: 0;
            font-size: 28px;
            line-height: 1.2;
            color: #111827;
        }

        .ticket-subtitle {
            margin: 8px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .ticket-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border-radius: 999px;
            color: #ffffff;
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
        }

        .ticket-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .ticket-summary-item {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 14px 16px;
        }

        .ticket-summary-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .ticket-summary-value {
            font-size: 15px;
            color: #111827;
            font-weight: 600;
            line-height: 1.4;
        }

        .ticket-main-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.6fr) minmax(320px, 1fr);
            gap: 20px;
        }

        .ticket-card {
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            background: #ffffff;
            padding: 22px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        }

        .ticket-card h2,
        .ticket-card h3 {
            margin-top: 0;
            margin-bottom: 14px;
            color: #111827;
        }

        .ticket-description {
            font-size: 16px;
            line-height: 1.8;
            color: #1f2937;
            white-space: pre-line;
        }

        .ticket-meta-list {
            display: grid;
            gap: 12px;
        }

        .ticket-meta-item {
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 10px;
        }

        .ticket-meta-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .ticket-meta-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .04em;
            margin-bottom: 4px;
        }

        .ticket-meta-value {
            font-size: 15px;
            color: #111827;
            line-height: 1.5;
        }

        .ticket-actions {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .ticket-form-stack {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .ticket-timeline {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .ticket-timeline-item {
            border-left: 4px solid #e5e7eb;
            padding-left: 14px;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .ticket-timeline-date {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .ticket-timeline-title {
            font-size: 15px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .ticket-timeline-text {
            font-size: 14px;
            color: #374151;
            line-height: 1.6;
        }

        .ticket-empty {
            padding: 14px 16px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            color: #475569;
        }

        .ticket-top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .ticket-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .ticket-soft-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            background: #eef2ff;
            color: #3730a3;
            font-size: 12px;
            font-weight: 600;
        }

        .ticket-attachment-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .ticket-attachment-item {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px;
            background: #f8fafc;
        }

        @media (max-width: 1100px) {
            .ticket-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .ticket-main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .ticket-hero {
                padding: 18px;
            }

            .ticket-card {
                padding: 18px;
            }

            .ticket-hero-top {
                flex-direction: column;
                align-items: stretch;
            }

            .ticket-title {
                font-size: 22px;
            }

            .ticket-summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="ticket-show-wrap">
        <div class="ticket-top-actions">
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('tik.admin.tickets.index') }}" class="btn btn-secondary">Volver al panel</a>
                <a href="{{ route('tik.tickets.show', $ticket->id_ticket) }}" class="btn btn-secondary">Ver detalle general</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="margin: 0;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" style="margin: 0;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="ticket-hero">
            <div class="ticket-hero-top">
                <div style="flex: 1;">
                    <div class="ticket-code">Ticket {{ $ticket->codigo }}</div>
                    <h1 class="ticket-title">{{ $ticket->asunto }}</h1>
                    <p class="ticket-subtitle">
                        Desde aquí puedes asignar responsable, cambiar la clasificación administrativa y revisar el historial operativo del ticket.
                    </p>

                    <div class="ticket-badges">
                        <span class="ticket-soft-badge">
                            Tipo: {{ $ticket->tipoTicket?->nombre ?? 'Sin definir' }}
                        </span>

                        @if ($ticket->tipoTicketRrhh)
                            <span class="ticket-soft-badge">
                                Subtipo RRHH: {{ $ticket->tipoTicketRrhh->nombre }}
                            </span>
                        @endif

                        @if ($ticket->es_proyecto)
                            <span class="ticket-soft-badge">Proyecto</span>
                        @endif

                        @if ($ticket->no_aplica)
                            <span class="ticket-soft-badge" style="background: #fef2f2; color: #991b1b;">
                                No aplica
                            </span>
                        @endif
                    </div>
                </div>

                <div>
                    <span class="ticket-status" style="background: {{ $colorEstado }};">
                        {{ $ticket->estadoTicket?->nombre ?? 'Sin estado' }}
                    </span>
                </div>
            </div>

            <div class="ticket-summary-grid">
                <div class="ticket-summary-item">
                    <div class="ticket-summary-label">Solicitante</div>
                    <div class="ticket-summary-value">
                        {{ trim(($ticket->solicitante?->nombres ?? '') . ' ' . ($ticket->solicitante?->apellidos ?? '')) ?: 'Sin definir' }}
                    </div>
                </div>

                <div class="ticket-summary-item">
                    <div class="ticket-summary-label">Responsable actual</div>
                    <div class="ticket-summary-value">
                        @if ($ticket->responsable)
                            {{ trim(($ticket->responsable->nombres ?? '') . ' ' . ($ticket->responsable->apellidos ?? '')) }}
                        @else
                            Sin asignar
                        @endif
                    </div>
                </div>

                <div class="ticket-summary-item">
                    <div class="ticket-summary-label">Área responsable</div>
                    <div class="ticket-summary-value">
                        {{ $ticket->areaResponsable?->nombre ?? 'N/D' }}
                    </div>
                </div>

                <div class="ticket-summary-item">
                    <div class="ticket-summary-label">Asignado por</div>
                    <div class="ticket-summary-value">
                        @if ($ticket->asignador)
                            {{ trim(($ticket->asignador->nombres ?? '') . ' ' . ($ticket->asignador->apellidos ?? '')) }}
                        @else
                            N/D
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="ticket-main-grid">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <section class="ticket-card">
                    <h2>Descripción de la solicitud</h2>
                    <div class="ticket-description">
                        {{ $ticket->descripcion ?: 'Sin descripción.' }}
                    </div>
                </section>

                <section class="ticket-card">
                    <h3>Historial administrativo</h3>

                    @if ($ticket->seguimientos->count())
                        <div class="ticket-timeline">
                            @foreach ($ticket->seguimientos as $seguimiento)
                                <div class="ticket-timeline-item">
                                    <div class="ticket-timeline-date">
                                        {{ $seguimiento->created_at?->format('d/m/Y h:i a') ?? 'Sin definir' }}
                                    </div>

                                    <div class="ticket-timeline-title">
                                        {{ $seguimiento->estadoAnterior?->nombre ?? 'Sin definir' }}
                                        →
                                        {{ $seguimiento->estadoNuevo?->nombre ?? 'Sin definir' }}
                                    </div>

                                    <div class="ticket-timeline-text">
                                        <strong>
                                            {{ trim(($seguimiento->usuario?->nombres ?? '') . ' ' . ($seguimiento->usuario?->apellidos ?? '')) ?: 'Usuario no identificado' }}
                                        </strong>
                                        @if ($seguimiento->comentario)
                                            — {{ $seguimiento->comentario }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="ticket-empty">
                            No hay seguimientos registrados.
                        </div>
                    @endif
                </section>

                <section class="ticket-card">
                    <h3>Comentarios del solicitante</h3>

                    @if ($ticket->comentarios->count())
                        <div class="ticket-timeline">
                            @foreach ($ticket->comentarios as $comentario)
                                <div class="ticket-timeline-item">
                                    <div class="ticket-timeline-date">
                                        {{ $comentario->fecha_registro_formateada }}
                                    </div>

                                    <div class="ticket-timeline-title">
                                        {{ trim(($comentario->usuario?->nombres ?? '') . ' ' . ($comentario->usuario?->apellidos ?? '')) ?: ($comentario->usuario?->nombre_usuario ?? 'N/D') }}
                                    </div>

                                    <div class="ticket-timeline-text">
                                        {{ $comentario->comentario }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="ticket-empty">
                            No hay comentarios registrados.
                        </div>
                    @endif
                </section>

                <section class="ticket-card">
                    <h3>Archivos adjuntos</h3>

                    @if ($ticket->anexos->count())
                        <div class="ticket-attachment-list">
                            @foreach ($ticket->anexos as $anexo)
                                <div class="ticket-attachment-item">
                                    <div class="ticket-meta-list">
                                        <div class="ticket-meta-item">
                                            <div class="ticket-meta-label">Archivo</div>
                                            <div class="ticket-meta-value">{{ $anexo->nombre_original }}</div>
                                        </div>

                                        <div class="ticket-meta-item">
                                            <div class="ticket-meta-label">Subido por</div>
                                            <div class="ticket-meta-value">
                                                {{ trim(($anexo->usuario?->nombres ?? '') . ' ' . ($anexo->usuario?->apellidos ?? '')) ?: ($anexo->usuario?->nombre_usuario ?? 'N/D') }}
                                            </div>
                                        </div>

                                        <div class="ticket-meta-item">
                                            <div class="ticket-meta-label">Tipo</div>
                                            <div class="ticket-meta-value">{{ $anexo->mime_type ?? 'N/D' }}</div>
                                        </div>

                                        <div class="ticket-meta-item">
                                            <div class="ticket-meta-label">Tamaño</div>
                                            <div class="ticket-meta-value">{{ $anexo->peso_formateado }}</div>
                                        </div>

                                        <div class="ticket-meta-item">
                                            <div class="ticket-meta-label">Fecha</div>
                                            <div class="ticket-meta-value">{{ $anexo->fecha_registro_formateada }}</div>
                                        </div>
                                    </div>

                                    <div style="margin-top: 12px;">
                                        <a href="{{ route('tik.tickets.attachments.download', [$ticket->id_ticket, $anexo->id_anexo_ticket]) }}" class="btn btn-secondary btn-sm">
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="ticket-empty">
                            No hay anexos registrados.
                        </div>
                    @endif
                </section>
            </div>

            <div style="display: flex; flex-direction: column; gap: 20px;">
                <section class="ticket-card">
                    <h3>Asignar responsable</h3>

                    <form method="POST" action="{{ route('tik.admin.tickets.assign', $ticket->id_ticket) }}" class="ticket-form-stack">
                        @csrf

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="id_usuario_responsable">Responsable</label>
                            <select name="id_usuario_responsable" id="id_usuario_responsable" class="form-control" required>
                                <option value="">Seleccione</option>
                                @foreach ($responsables as $responsable)
                                    <option value="{{ $responsable->id_usuario }}">
                                        {{ trim(($responsable->nombres ?? '') . ' ' . ($responsable->apellidos ?? '')) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Asignar ticket</button>
                    </form>
                </section>

                <section class="ticket-card">
                    <h3>Clasificación administrativa</h3>

                    <form method="POST" action="{{ route('tik.admin.tickets.classify', $ticket->id_ticket) }}" class="ticket-form-stack">
                        @csrf

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="clasificacion">Clasificación</label>
                            <select name="clasificacion" id="clasificacion" class="form-control" required>
                                <option value="">Seleccione</option>
                                <option value="NORMAL">Normal</option>
                                <option value="PROYECTO">Proyecto</option>
                                <option value="NO_APLICA">No aplica</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar clasificación</button>
                    </form>
                </section>

                <section class="ticket-card">
                    <h3>Resumen rápido</h3>

                    <div class="ticket-meta-list">
                        <div class="ticket-meta-item">
                            <div class="ticket-meta-label">Estado</div>
                            <div class="ticket-meta-value">{{ $ticket->estadoTicket?->nombre ?? 'Sin definir' }}</div>
                        </div>

                        <div class="ticket-meta-item">
                            <div class="ticket-meta-label">Código</div>
                            <div class="ticket-meta-value">{{ $ticket->codigo }}</div>
                        </div>

                        <div class="ticket-meta-item">
                            <div class="ticket-meta-label">Fecha ticket</div>
                            <div class="ticket-meta-value">{{ $ticket->fecha_ticket_formateada }}</div>
                        </div>

                        <div class="ticket-meta-item">
                            <div class="ticket-meta-label">Fecha de cierre</div>
                            <div class="ticket-meta-value">{{ $ticket->fecha_cierre_formateada }}</div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection