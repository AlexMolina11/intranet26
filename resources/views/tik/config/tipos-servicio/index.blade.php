@extends('layouts.app')

@section('title', 'Tipos de Servicio')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Tipos de Servicio</h1>
            <p class="page-subtitle">Administración del catálogo de tipos de servicio</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('TIK_CATALOGOS_CREAR'))
                <a href="{{ route('tik.config.tipos-servicio.create') }}" class="btn btn-primary">Nuevo tipo</a>
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
                    @forelse($tiposServicio as $tipoServicio)
                        <tr>
                            <td>{{ $tipoServicio->codigo }}</td>
                            <td>{{ $tipoServicio->nombre }}</td>
                            <td>{{ $tipoServicio->areaResponsable->nombre ?? '-' }}</td>
                            <td>{{ $tipoServicio->orden }}</td>
                            <td>
                                @if($tipoServicio->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->tienePermiso('TIK_CATALOGOS_EDITAR'))
                                    <a href="{{ route('tik.config.tipos-servicio.edit', $tipoServicio->id_tipo_servicio) }}" class="btn btn-secondary">Editar</a>
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
            {{ $tiposServicio->links() }}
        </div>
    </div>
@endsection