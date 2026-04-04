@extends('layouts.app')

@section('title', 'Estados de préstamo')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Estados de préstamo</h1>
            <p class="page-subtitle">Administración del catálogo de estados de préstamo</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_CATALOGOS_CREAR'))
                <a href="{{ route('bib.config.estados-prestamo.create') }}" class="btn btn-primary">Nuevo estado</a>
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
                        <th>Es inicial</th>
                        <th>Es final</th>
                        <th>Genera multa</th>
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
                            <td>{{ $item->es_inicial ? 'Sí' : 'No' }}</td>
                            <td>{{ $item->es_final ? 'Sí' : 'No' }}</td>
                            <td>{{ $item->genera_multa ? 'Sí' : 'No' }}</td>
                            <td>{{ $item->orden }}</td>
                            <td>{{ $item->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                @if(auth()->user()->tienePermiso('BIB_CATALOGOS_EDITAR'))
                                    <a href="{{ route('bib.config.estados-prestamo.edit', $item) }}" class="btn btn-secondary">Editar</a>
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