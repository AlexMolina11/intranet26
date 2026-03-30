@extends('layouts.app')

@section('title', 'Servicios')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Servicios</h1>
            <p class="page-subtitle">Administración del catálogo de servicios</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('TIK_CATALOGOS_CREAR'))
                <a href="{{ route('tik.config.servicios.create') }}" class="btn btn-primary">Nuevo servicio</a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo de servicio</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->tipoServicio->nombre ?? '-' }}</td>
                            <td>{{ $servicio->codigo }}</td>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->orden }}</td>
                            <td>
                                @if($servicio->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->tienePermiso('TIK_CATALOGOS_EDITAR'))
                                    <a href="{{ route('tik.config.servicios.edit', $servicio->id_servicio) }}" class="btn btn-secondary">Editar</a>
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
            {{ $servicios->links() }}
        </div>
    </div>
@endsection