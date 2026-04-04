@extends('layouts.app')

@section('title', 'Disponibilidades')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Disponibilidades</h1>
            <p class="page-subtitle">Administración del catálogo de disponibilidades</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_CATALOGOS_CREAR'))
                <a href="{{ route('bib.config.disponibilidades.create') }}" class="btn btn-primary">Nueva disponibilidad</a>
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
                        <th>Permite reserva</th>
                        <th>Permite préstamo</th>
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
                            <td>{{ $item->permite_reserva ? 'Sí' : 'No' }}</td>
                            <td>{{ $item->permite_prestamo ? 'Sí' : 'No' }}</td>
                            <td>{{ $item->orden }}</td>
                            <td>{{ $item->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                @if(auth()->user()->tienePermiso('BIB_CATALOGOS_EDITAR'))
                                    <a href="{{ route('bib.config.disponibilidades.edit', $item) }}" class="btn btn-secondary">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No hay registros.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $items->links() }}
        </div>
    </div>
@endsection