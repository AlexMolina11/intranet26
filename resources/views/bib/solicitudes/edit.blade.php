@extends('layouts.app')

@section('title', 'Editar solicitud')

@section('content')
    <div class="card">
        <form method="POST" action="{{ route('bib.solicitudes.update', $solicitud) }}">
            @csrf
            @method('PUT')

            @include('bib.solicitudes._form', ['solicitud' => $solicitud])

            <div class="page-header-actions" style="margin-top:16px;">
                @if(!in_array($solicitud->estadoSolicitud?->codigo, ['ATENDIDA', 'RECHAZADA'], true))
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                @endif

                <a href="{{ route('bib.solicitudes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    @if(auth()->user()->tienePermiso('BIB_SOLICITUDES_GESTIONAR'))
        <div class="card" style="margin-top:16px;">
            <h2 style="margin-top:0;">Gestión de solicitud</h2>

            <p>
                <strong>Estado actual:</strong>
                {{ $solicitud->estadoSolicitud?->nombre ?? 'Sin estado' }}
            </p>

            <div class="page-header-actions">
                @if($solicitud->estadoSolicitud?->codigo === 'PENDIENTE')
                    <form method="POST" action="{{ route('bib.solicitudes.aprobar', $solicitud) }}" style="display:inline-block;">
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-success"
                            onclick="return confirm('¿Deseas aprobar esta solicitud?');"
                        >
                            Aprobar solicitud
                        </button>
                    </form>

                    <form method="POST" action="{{ route('bib.solicitudes.rechazar', $solicitud) }}" style="display:inline-block;">
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('¿Deseas rechazar esta solicitud?');"
                        >
                            Rechazar solicitud
                        </button>
                    </form>
                @endif

                @if($solicitud->estadoSolicitud?->codigo === 'APROBADA')
                    <form method="POST" action="{{ route('bib.solicitudes.generar-prestamo', $solicitud) }}" style="display:inline-block;">
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-warning"
                            onclick="return confirm('¿Deseas generar un préstamo a partir de esta solicitud?');"
                        >
                            Generar préstamo
                        </button>
                    </form>

                    <form method="POST" action="{{ route('bib.solicitudes.rechazar', $solicitud) }}" style="display:inline-block;">
                        @csrf
                        <button
                            type="submit"
                            class="btn btn-danger"
                            onclick="return confirm('¿Deseas rechazar esta solicitud aprobada?');"
                        >
                            Rechazar solicitud
                        </button>
                    </form>
                @endif
            </div>

            @if($solicitud->estadoSolicitud?->codigo === 'APROBADA' && !$solicitud->id_ejemplar)
                <div class="alert alert-warning" style="margin-top:16px;">
                    Para generar el préstamo debes actualizar la solicitud y seleccionar un ejemplar disponible.
                </div>
            @endif

            @if($solicitud->estadoSolicitud?->codigo === 'ATENDIDA')
                <div class="alert alert-success" style="margin-top:16px;">
                    Esta solicitud ya fue atendida.
                </div>
            @endif

            @if($solicitud->estadoSolicitud?->codigo === 'RECHAZADA')
                <div class="alert alert-danger" style="margin-top:16px;">
                    Esta solicitud fue rechazada.
                </div>
            @endif
        </div>
    @endif
@endsection