@extends('layouts.app')

@section('title', 'Tipos de Ticket')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Tipos de Ticket</h1>
            <p class="page-subtitle">Administración del catálogo de tipos de ticket</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('TIK_CATALOGOS_CREAR'))
                <a href="{{ route('tik.config.tipos-ticket.create') }}" class="btn btn-primary">
                    Nuevo tipo
                </a>
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
                        <th>Área responsable</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tipos as $tipo)
                        <tr>
                            <td>{{ $tipo->codigo }}</td>
                            <td>{{ $tipo->nombre }}</td>
                            <td>{{ $tipo->areaResponsable->nombre ?? '-' }}</td>
                            <td>{{ $tipo->orden }}</td>
                            <td>
                                @if($tipo->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->tienePermiso('TIK_CATALOGOS_EDITAR'))
                                    <a href="{{ route('tik.config.tipos-ticket.edit', $tipo->id_tipo_ticket) }}" class="btn btn-secondary">
                                        Editar
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay registros.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $tipos->links() }}
        </div>
    </div>
@endsection