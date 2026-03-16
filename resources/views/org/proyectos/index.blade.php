@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Proyectos</h1>
                <p class="page-subtitle">Administración de proyectos</p>
            </div>

            <div class="page-header-actions">
                <a href="{{ route('org.proyectos.create') }}" class="btn btn-primary">Nuevo proyecto</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($proyectos as $proyecto)
                        <tr>
                            <td>{{ $proyecto->id_proyecto }}</td>
                            <td>{{ $proyecto->codigo ?: '-' }}</td>
                            <td>{{ $proyecto->nombre }}</td>
                            <td>{{ $proyecto->descripcion ?: '-' }}</td>
                            <td>
                                @if ($proyecto->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('org.proyectos.edit', $proyecto) }}" class="btn btn-warning">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No hay proyectos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $proyectos->links() }}
        </div>
    </div>
@endsection