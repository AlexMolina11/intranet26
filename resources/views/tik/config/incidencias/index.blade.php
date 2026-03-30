@extends('layouts.app')

@section('title', 'Incidencias')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Incidencias</h1>
            <p class="page-subtitle">Administración del catálogo de incidencias</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('TIK_CATALOGOS_CREAR'))
                <a href="{{ route('tik.config.incidencias.create') }}" class="btn btn-primary">Nueva incidencia</a>
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
                    @forelse($incidencias as $incidencia)
                        <tr>
                            <td>{{ $incidencia->codigo }}</td>
                            <td>{{ $incidencia->nombre }}</td>
                            <td>{{ $incidencia->areaResponsable->nombre ?? '-' }}</td>
                            <td>{{ $incidencia->orden }}</td>
                            <td>
                                @if($incidencia->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->tienePermiso('TIK_CATALOGOS_EDITAR'))
                                    <a href="{{ route('tik.config.incidencias.edit', $incidencia->id_incidencia) }}" class="btn btn-secondary">Editar</a>
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
            {{ $incidencias->links() }}
        </div>
    </div>
@endsection