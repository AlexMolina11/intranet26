@extends('layouts.app')

@section('title', 'Gestión administrativa del ticket')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Gestión administrativa del ticket</h1>
                <p class="page-subtitle">{{ $ticket->codigo }} — {{ $ticket->asunto }}</p>
            </div>

            <div class="page-header-actions" style="display:flex; gap:10px;">
                <a href="{{ route('tik.admin.tickets.index') }}" class="btn btn-secondary">Volver al panel</a>
                <a href="{{ route('tik.tickets.show', $ticket->id_ticket) }}" class="btn btn-secondary">Ver detalle general</a>
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
                <h3 style="margin-top:0;">Información del ticket</h3>
                <p><strong>Código:</strong> {{ $ticket->codigo }}</p>
                <p><strong>Asunto:</strong> {{ $ticket->asunto }}</p>
                <p><strong>Tipo:</strong> {{ $ticket->tipoTicket?->nombre }}</p>
                <p><strong>Estado:</strong> {{ $ticket->estadoTicket?->nombre }}</p>
                <p><strong>Área responsable:</strong> {{ $ticket->areaResponsable?->nombre ?? 'N/D' }}</p>
                <p><strong>Solicitante:</strong> {{ trim(($ticket->solicitante?->nombres ?? '') . ' ' . ($ticket->solicitante?->apellidos ?? '')) }}</p>
                <p><strong>Responsable actual:</strong>
                    @if ($ticket->responsable)
                        {{ trim(($ticket->responsable->nombres ?? '') . ' ' . ($ticket->responsable->apellidos ?? '')) }}
                    @else
                        Sin asignar
                    @endif
                </p>
                <p><strong>Asignado por:</strong>
                    @if ($ticket->asignador)
                        {{ trim(($ticket->asignador->nombres ?? '') . ' ' . ($ticket->asignador->apellidos ?? '')) }}
                    @else
                        N/D
                    @endif
                </p>
            </div>

            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Asignar responsable</h3>

                <form method="POST" action="{{ route('tik.admin.tickets.assign', $ticket->id_ticket) }}">
                    @csrf

                    <div class="form-group">
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

                    <div style="margin-top:12px;">
                        <button type="submit" class="btn btn-primary">Asignar ticket</button>
                    </div>
                </form>
            </div>

            <div class="card" style="padding:16px;">
                <h3 style="margin-top:0;">Clasificación administrativa</h3>

                <form method="POST" action="{{ route('tik.admin.tickets.classify', $ticket->id_ticket) }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="clasificacion">Clasificación</label>
                        <select name="clasificacion" id="clasificacion" class="form-control" required>
                            <option value="">Seleccione</option>
                            <option value="NORMAL">Normal</option>
                            <option value="PROYECTO">Proyecto</option>
                            <option value="NO_APLICA">No aplica</option>
                        </select>
                    </div>

                    <div style="margin-top:12px;">
                        <button type="submit" class="btn btn-primary">Guardar clasificación</button>
                    </div>
                </form>
            </div>
        </div>

        <div style="margin-top:24px;">
            <div class="card" style="padding:16px;">
                <h2 style="margin-top:0;">Historial administrativo</h2>

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