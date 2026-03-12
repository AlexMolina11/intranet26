@extends('layouts.app')

@section('title', 'Departamentos')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div>
                <h1 style="margin:0;">Departamentos</h1>
                <p style="margin:6px 0 0 0; color:#64748b;">Catálogo de departamentos organizacionales</p>
            </div>

            <a href="{{ route('org.departamentos.create') }}" class="btn btn-primary">Nuevo departamento</a>
        </div>

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
                @forelse ($departamentos as $departamento)
                    <tr>
                        <td>{{ $departamento->id_departamento }}</td>
                        <td>{{ $departamento->codigo ?: '-' }}</td>
                        <td>{{ $departamento->nombre }}</td>
                        <td>{{ $departamento->descripcion ?: '-' }}</td>
                        <td>
                            @if ($departamento->activo)
                                <span class="badge badge-success">Activo</span>
                            @else
                                <span class="badge badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('org.departamentos.edit', $departamento) }}" class="btn btn-warning">
                                Editar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay departamentos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:20px;">
            {{ $departamentos->links() }}
        </div>
    </div>
@endsection