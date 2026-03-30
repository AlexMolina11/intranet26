@extends('layouts.app')

@section('title', 'Estados de Ticket')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Estados de Ticket</h1>
            <p class="page-subtitle">Administración de estados del flujo</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('TIK_CATALOGOS_CREAR'))
                <a href="{{ route('tik.config.estados.create') }}" class="btn btn-primary">Nuevo estado</a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Color</th>
                        <th>Inicial</th>
                        <th>Final</th>
                        <th>Siguiente</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($estados as $estado)
                        <tr>
                            <td>{{ $estado->codigo }}</td>
                            <td>{{ $estado->nombre }}</td>
                            <td>{{ $estado->color }}</td>
                            <td>{{ $estado->es_inicial ? 'Sí' : 'No' }}</td>
                            <td>{{ $estado->es_final ? 'Sí' : 'No' }}</td>
                            <td>{{ $estado->estadoSiguiente->nombre ?? '-' }}</td>
                            <td>{{ $estado->orden }}</td>
                            <td>
                                @if($estado->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->tienePermiso('TIK_CATALOGOS_EDITAR'))
                                    <a href="{{ route('tik.config.estados.edit', $estado->id_estado_ticket) }}" class="btn btn-secondary">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No hay registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $estados->links() }}
        </div>
    </div>
@endsection