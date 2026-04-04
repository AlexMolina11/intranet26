@extends('layouts.app')

@section('title', 'Autores')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Autores</h1>
            <p class="page-subtitle">Administración del catálogo de autores</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_CATALOGOS_CREAR'))
                <a href="{{ route('bib.config.autores.create') }}" class="btn btn-primary">Nuevo autor</a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre completo</th>
                        <th>Seudónimo</th>
                        <th>Fecha nacimiento</th>
                        <th>Fecha fallecimiento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->nombre_completo }}</td>
                            <td>{{ $item->seudonimo ?: '-' }}</td>
                            <td>{{ $item->fecha_nacimiento ? $item->fecha_nacimiento->format('d/m/Y') : '-' }}</td>
                            <td>{{ $item->fecha_fallecimiento ? $item->fecha_fallecimiento->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($item->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->tienePermiso('BIB_CATALOGOS_EDITAR'))
                                    <a href="{{ route('bib.config.autores.edit', $item) }}" class="btn btn-secondary">Editar</a>
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