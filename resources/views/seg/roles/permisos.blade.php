@extends('layouts.app')

@section('title', 'Permisos del rol')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Asignar permisos a rol</h1>
                <p class="page-subtitle">
                    Sistema: <strong>{{ $sistema->nombre }}</strong><br>
                    Rol: <strong>{{ $rol->nombre }}</strong></strong></p>
            </div>
        </div>

        <form method="POST" action="{{ route('seg.sistemas.roles.permisos.update', [$sistema, $rol]) }}">
            @csrf
            @method('PUT')

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Asignar</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permisos as $permiso)
                            <tr>
                                <td>
                                    <input type="checkbox" name="permisos[]" value="{{ $permiso->id_permiso }}"
                                        {{ in_array($permiso->id_permiso, $seleccionados) ? 'checked' : '' }}>
                                </td>
                                <td>{{ $permiso->codigo }}</td>
                                <td>{{ $permiso->nombre }}</td>
                                <td>{{ $permiso->descripcion ?: 'Sin descripción' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No hay permisos registrados en este sistema.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="stack-mobile" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('seg.sistemas.roles.index', $sistema) }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection