@extends('layouts.app')

@section('title', 'Panel gestor de tickets')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin: 0;">Panel gestor de tickets</h1>
                <p class="page-subtitle">Tickets asignados al usuario responsable</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success" style="margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('general'))
            <div class="alert alert-danger" style="margin-bottom: 20px;">
                {{ $errors->first('general') }}
            </div>
        @endif

        <form method="GET" action="{{ route('tik.gestor.tickets.index') }}" style="margin-bottom: 20px;">
            <div class="form-group" style="max-width: 280px;">
                <label class="form-label" for="filtro">Filtrar tickets</label>
                <select name="filtro" id="filtro" class="form-control" onchange="this.form.submit()">
                    <option value="asignados" {{ $filtro === 'asignados' ? 'selected' : '' }}>Asignados abiertos</option>
                    <option value="proyectos" {{ $filtro === 'proyectos' ? 'selected' : '' }}>Proyectos</option>
                    <option value="cerrados" {{ $filtro === 'cerrados' ? 'selected' : '' }}>Cerrados</option>
                </select>
            </div>
        </form>

        @if ($tickets->count())
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Solicitante</th>
                            <th>Tipo</th>
                            <th>Área responsable</th>
                            <th>Estado</th>
                            <th>Proyecto</th>
                            <th>Fecha ticket</th>
                            <th style="width: 140px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->codigo }}</td>
                                <td>
                                    {{ $ticket->solicitante?->nombres }}
                                    {{ $ticket->solicitante?->apellidos }}
                                </td>
                                <td>{{ $ticket->tipoTicket?->nombre ?? 'Sin definir' }}</td>
                                <td>{{ $ticket->areaResponsable?->nombre ?? 'Sin definir' }}</td>
                                <td>
                                    <span class="badge" style="background: {{ $ticket->estadoTicket?->color ?? '#6c757d' }}; color: #fff;">
                                        {{ $ticket->estadoTicket?->nombre ?? 'Sin estado' }}
                                    </span>
                                </td>
                                <td>{{ $ticket->es_proyecto ? 'Sí' : 'No' }}</td>
                                <td>{{ $ticket->fecha_ticket_formateada }}</td>
                                <td>
                                    <a href="{{ route('tik.gestor.tickets.show', $ticket->id_ticket) }}" class="btn btn-sm btn-primary">
                                        Ver detalle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 20px;">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="empty-state">
                <p style="margin: 0;">No hay tickets para el filtro seleccionado.</p>
            </div>
        @endif
    </div>
@endsection