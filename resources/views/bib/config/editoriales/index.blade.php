@extends('layouts.app')

@section('title', 'Editoriales')

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1 style="margin:0;">Editoriales</h1>
            <p class="page-subtitle">Administración del catálogo de editoriales</p>
        </div>

        <div class="page-header-actions">
            @if(auth()->user()->tienePermiso('BIB_CATALOGOS_CREAR'))
                <a href="{{ route('bib.config.editoriales.create') }}" class="btn btn-primary">Nueva editorial</a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Sigla</th>
                        <th>Sitio web</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $item->nombre }}</td>
                            <td>{{ $item->sigla ?: '-' }}</td>
                            <td>{{ $item->sitio_web ?: '-' }}</td>
                            <td>{{ $item->activo ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                @if(auth()->user()->tienePermiso('BIB_CATALOGOS_EDITAR'))
                                    <a href="{{ route('bib.config.editoriales.edit', $item) }}" class="btn btn-secondary">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No hay registros.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $items->links() }}
        </div>
    </div>
@endsection