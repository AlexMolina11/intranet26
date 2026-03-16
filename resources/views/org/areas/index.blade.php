@extends('layouts.app')

@section('title', 'Áreas')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Áreas</h1>
                <p class="page-subtitle">Administración de áreas organizacionales</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('org.areas.create') }}" class="btn btn-primary">Nueva área</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Departamento</th>
                        <th>Proyecto</th>
                        <th>Área</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($areas as $area)
                        <tr>
                            <td>{{ $area->id_area }}</td>
                            <td>{{ $area->departamento->nombre ?? '-' }}</td>
                            <td>{{ $area->proyecto->nombre ?? '-' }}</td>
                            <td>{{ $area->nombre }}</td>
                            <td>{{ $area->descripcion ?: '-' }}</td>
                            <td>
                                @if ($area->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('org.areas.edit', $area) }}" class="btn btn-warning">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay áreas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $areas->links() }}
        </div>
    </div>
@endsection