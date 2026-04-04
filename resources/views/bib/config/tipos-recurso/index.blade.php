@extends('layouts.app')

@section('title', 'Tipos de recurso')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Tipos de recurso</h1>
            <p class="page-subtitle">Administración del catálogo de tipos de recurso</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_CATALOGOS_CREAR'))
                <a href="{{ route('bib.config.tipos-recurso.create') }}" class="btn btn-primary">Nuevo tipo</a>
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
                        <th>Días préstamo</th>
                        <th>Renovaciones</th>
                        <th>Multa diaria</th>
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
                            <td>{{ $item->dias_prestamo_default }}</td>
                            <td>{{ $item->renovaciones_default }}</td>
                            <td>{{ number_format((float) $item->multa_diaria_default, 2) }}</td>
                            <td>{{ $item->orden }}</td>
                            <td>{{ $item->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                @if(auth()->user()->tienePermiso('BIB_CATALOGOS_EDITAR'))
                                    <a href="{{ route('bib.config.tipos-recurso.edit', $item) }}" class="btn btn-secondary">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8">No hay registros.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $items->links() }}
        </div>
    </div>
@endsection