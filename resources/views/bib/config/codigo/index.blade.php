@extends('layouts.app')

@section('title', $pluralTitle)

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">{{ $pluralTitle }}</h1>
            <p class="page-subtitle">Administración del catálogo {{ strtolower($pluralTitle) }}</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_CATALOGOS_CREAR'))
                <a href="{{ route($routePrefix . '.create') }}" class="btn btn-primary">Nuevo registro</a>
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
                        <th>Descripción</th>
                        <th>Orden</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->codigo }}</td>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->descripcion ?: '-' }}</td>
                            <td>{{ $item->orden }}</td>
                            <td>
                                @if($item->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->tienePermiso('BIB_CATALOGOS_EDITAR'))
                                    <a href="{{ route($routePrefix . '.edit', $item) }}" class="btn btn-secondary">Editar</a>
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
            {{ $items->links() }}
        </div>
    </div>
@endsection