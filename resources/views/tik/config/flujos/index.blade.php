@extends('layouts.app')

@section('title', 'Flujos de Ticket')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Flujos de Ticket</h1>
            <p class="page-subtitle">Administración del flujo por tipo y estado</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('TIK_FLUJOS_CREAR'))
                <a href="{{ route('tik.config.flujos.create') }}" class="btn btn-primary">Nuevo flujo</a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo de ticket</th>
                        <th>Estado</th>
                        <th>Mensaje usuario</th>
                        <th>Mensaje admin</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flujos as $flujo)
                        <tr>
                            <td>{{ $flujo->tipoTicket->nombre ?? '-' }}</td>
                            <td>{{ $flujo->estadoTicket->nombre ?? '-' }}</td>
                            <td>{{ $flujo->mensaje_usuario }}</td>
                            <td>{{ $flujo->mensaje_admin }}</td>
                            <td>{{ $flujo->orden }}</td>
                            <td>
                                @if($flujo->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->tienePermiso('TIK_FLUJOS_EDITAR'))
                                    <a href="{{ route('tik.config.flujos.edit', $flujo->id_flujo_ticket) }}" class="btn btn-secondary">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $flujos->links() }}
        </div>
    </div>
@endsection