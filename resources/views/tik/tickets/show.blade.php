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

        @if ($errors->any())
            <div class="alert alert-danger" style="margin-top:16px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
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
                <p><strong>Formato:</strong> {{ $ticket->formatoTicket?->nombre ?? 'N/D' }}</p>
                <p><strong>Estado:</strong> {{ $ticket->estadoTicket?->nombre }}</p>
            </div>

            @if ($ticket->tipoTicket?->codigo === 'TALENTO_HUMANO' && $ticket->detalleRrhh)
                <div class="card" style="padding:16px; margin-top:20px;">
                    <h3 style="margin-top:0;">Detalle RRHH</h3>
                    <p><strong>Tipo de solicitud RRHH:</strong> {{ $ticket->detalleRrhh->tipoTicketRrhh?->nombre ?? 'N/D' }}</p>
                    <p><strong>Detalle:</strong><br>{{ $ticket->detalleRrhh->detalle ?? 'Sin detalle adicional' }}</p>
                </div>
            @endif

            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Participantes</h3>
                <p><strong>Solicitante:</strong> {{ trim(($ticket->solicitante?->nombres ?? '') . ' ' . ($ticket->solicitante?->apellidos ?? '')) }}</p>
                <p>
                    <strong>Responsable:</strong>
                    @if ($ticket->responsable)
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

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(320px, 1fr)); gap:16px; margin-top:20px;">
            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Agregar comentario</h3>

                <form method="POST" action="{{ route('tik.tickets.comments.store', $ticket->id_ticket) }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="frmComentarioTicket_txaComentario">Comentario</label>
                        <textarea
                            name="frmComentarioTicket_txaComentario"
                            id="frmComentarioTicket_txaComentario"
                            rows="4"
                            class="form-control"
                            required>{{ old('frmComentarioTicket_txaComentario') }}</textarea>
                    </div>

                    <div style="margin-top:12px;">
                        <button type="submit" class="btn btn-primary">Guardar comentario</button>
                    </div>
                </form>
            </div>

            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Adjuntar archivo</h3>

                <form method="POST" action="{{ route('tik.tickets.attachments.store', $ticket->id_ticket) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="frmAnexoTicket_fileArchivo">Archivo</label>
                        <input
                            type="file"
                            name="frmAnexoTicket_fileArchivo"
                            id="frmAnexoTicket_fileArchivo"
                            class="form-control"
                            required>
                        <small class="text-muted">Formatos permitidos: pdf, jpg, jpeg, png, doc, docx, xls, xlsx. Máximo 5 MB.</small>
                    </div>

                    <div style="margin-top:12px;">
                        <button type="submit" class="btn btn-primary">Subir archivo</button>
                    </div>
                </form>
            </div>

            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Registrar seguimiento</h3>

                @if ($ticket->esta_cerrado)
                    <div class="alert alert-warning" style="margin-top:12px;">
                        El ticket ya está cerrado. No se permiten más seguimientos.
                    </div>
                @else
                    <form method="POST" action="{{ route('tik.tickets.tracking.store', $ticket->id_ticket) }}">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" for="frmSeguimientoTicket_slcEstado">Nuevo estado</label>
                            <select name="frmSeguimientoTicket_slcEstado" id="frmSeguimientoTicket_slcEstado" class="form-control" required>
                                <option value="">Seleccione</option>
                                @foreach ($estadosDisponibles as $estado)
                                    <option value="{{ $estado->id_estado_ticket }}" {{ old('frmSeguimientoTicket_slcEstado') == $estado->id_estado_ticket ? 'selected' : '' }}>
                                        {{ $estado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" style="margin-top:12px;">
                            <label class="form-label" for="frmSeguimientoTicket_txaComentario">Comentario</label>
                            <textarea
                                name="frmSeguimientoTicket_txaComentario"
                                id="frmSeguimientoTicket_txaComentario"
                                rows="4"
                                class="form-control">{{ old('frmSeguimientoTicket_txaComentario') }}</textarea>
                        </div>

                        <div style="margin-top:12px;">
                            <button type="submit" class="btn btn-primary">Guardar seguimiento</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <div style="margin-top:20px;">
            @if (!$ticket->esta_cerrado)
                <button type="button" class="btn btn-danger" onclick="cancelarTicket({{ $ticket->id_ticket }})">
                    Cancelar ticket
                </button>
            @endif
        </div>

        <div style="margin-top:24px;">
            <div class="card" style="padding:16px;">
                <h2 style="margin-top:0;">Historial del ticket</h2>

                <div style="margin-top:20px;">
                    <h3>Comentarios</h3>

                    @forelse ($ticket->comentarios as $comentario)
                        <div class="card" style="padding:14px; margin-top:12px;">
                            <p style="margin:0 0 8px 0;">
                                <strong>Usuario:</strong>
                                {{ trim(($comentario->usuario?->nombres ?? '') . ' ' . ($comentario->usuario?->apellidos ?? '')) ?: ($comentario->usuario?->nombre_usuario ?? 'N/D') }}
                            </p>
                            <p style="margin:0 0 8px 0;"><strong>Fecha:</strong> {{ $comentario->fecha_registro_formateada }}</p>
                            <p style="margin:0;">{{ $comentario->comentario }}</p>
                        </div>
                    @empty
                        <p>No hay comentarios registrados.</p>
                    @endforelse
                </div>

                <div style="margin-top:24px;">
                    <h3>Anexos</h3>

                    @forelse ($ticket->anexos as $anexo)
                        <div class="card" style="padding:14px; margin-top:12px;">
                            <p style="margin:0 0 8px 0;"><strong>Archivo:</strong> {{ $anexo->nombre_original }}</p>
                            <p style="margin:0 0 8px 0;"><strong>Tipo:</strong> {{ $anexo->mime_type ?? 'N/D' }}</p>
                            <p style="margin:0 0 8px 0;"><strong>Tamaño:</strong> {{ $anexo->peso_formateado }}</p>
                            <p style="margin:0 0 8px 0;"><strong>Fecha:</strong> {{ $anexo->fecha_registro_formateada }}</p>
                            <a href="{{ route('tik.tickets.attachments.download', [$ticket->id_ticket, $anexo->id_anexo_ticket]) }}" class="btn btn-secondary btn-sm">
                                Descargar
                            </a>
                        </div>
                    @empty
                        <p>No hay anexos registrados.</p>
                    @endforelse
                </div>

                <div style="margin-top:24px;">
                    <h3>Seguimientos</h3>

                    @forelse ($ticket->seguimientos as $seguimiento)
                        <div class="card" style="padding:14px; margin-top:12px;">
                            <p style="margin:0 0 8px 0;">
                                <strong>Usuario:</strong>
                                {{ trim(($seguimiento->usuario?->nombres ?? '') . ' ' . ($seguimiento->usuario?->apellidos ?? '')) ?: ($seguimiento->usuario?->nombre_usuario ?? 'N/D') }}
                            </p>
                            <p style="margin:0 0 8px 0;"><strong>Fecha:</strong> {{ $seguimiento->fecha_registro_formateada }}</p>
                            <p style="margin:0 0 8px 0;">
                                <strong>Estado anterior:</strong>
                                {{ $seguimiento->estadoAnterior?->nombre ?? 'Sin definir' }}
                            </p>
                            <p style="margin:0 0 8px 0;">
                                <strong>Estado nuevo:</strong>
                                {{ $seguimiento->estadoNuevo?->nombre ?? 'Sin definir' }}
                            </p>
                            <p style="margin:0;">
                                <strong>Comentario:</strong>
                                {{ $seguimiento->comentario ?? 'Sin comentario' }}
                            </p>
                        </div>
                    @empty
                        <p>No hay seguimientos registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div style="margin-top:24px;">
            <div class="card" style="padding:16px;">
                <h2 style="margin-top:0;">Evaluación del ticket</h2>

                @if ($ticket->encuesta)
                    <p><strong>Calificación:</strong> {{ $ticket->encuesta->calificacion }}/5</p>
                    <p><strong>Comentario:</strong> {{ $ticket->encuesta->comentario ?? 'Sin comentario' }}</p>
                    <p><strong>Fecha:</strong> {{ $ticket->encuesta->fecha_registro_formateada }}</p>
                @elseif ($ticket->puede_evaluarse && auth()->id() === $ticket->id_usuario_solicitante)
                    <form method="POST" action="{{ route('tik.tickets.survey.store', $ticket->id_ticket) }}">
                        @csrf

                        <div class="form-group">
                            <label class="form-label" for="frmEncuestaTicket_numCalificacion">Calificación</label>
                            <select name="frmEncuestaTicket_numCalificacion" id="frmEncuestaTicket_numCalificacion" class="form-control" required>
                                <option value="">Seleccione</option>
                                <option value="1" {{ old('frmEncuestaTicket_numCalificacion') == 1 ? 'selected' : '' }}>1 - Muy mala</option>
                                <option value="2" {{ old('frmEncuestaTicket_numCalificacion') == 2 ? 'selected' : '' }}>2 - Mala</option>
                                <option value="3" {{ old('frmEncuestaTicket_numCalificacion') == 3 ? 'selected' : '' }}>3 - Regular</option>
                                <option value="4" {{ old('frmEncuestaTicket_numCalificacion') == 4 ? 'selected' : '' }}>4 - Buena</option>
                                <option value="5" {{ old('frmEncuestaTicket_numCalificacion') == 5 ? 'selected' : '' }}>5 - Excelente</option>
                            </select>
                        </div>

                        <div class="form-group" style="margin-top:12px;">
                            <label class="form-label" for="frmEncuestaTicket_txaComentario">Comentario</label>
                            <textarea
                                name="frmEncuestaTicket_txaComentario"
                                id="frmEncuestaTicket_txaComentario"
                                rows="4"
                                class="form-control">{{ old('frmEncuestaTicket_txaComentario') }}</textarea>
                        </div>

                        <div style="margin-top:12px;">
                            <button type="submit" class="btn btn-primary">Guardar evaluación</button>
                        </div>
                    </form>
                @elseif (!$ticket->esta_cerrado)
                    <div class="alert alert-warning" style="margin-top:12px;">
                        La evaluación estará disponible cuando el ticket esté cerrado.
                    </div>
                @else
                    <div class="alert alert-warning" style="margin-top:12px;">
                        La evaluación solo puede ser registrada por el solicitante del ticket.
                    </div>
                @endif
            </div>
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