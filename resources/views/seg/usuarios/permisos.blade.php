@extends('layouts.app')

@section('title', 'Permisos directos del usuario')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Permisos directos del usuario</h1>
                <p class="page-subtitle">Usuario: <strong>{{ $usuario->nombres }} {{ $usuario->apellidos }}</strong></p>
            </div>
        </div>

        <form method="POST" action="{{ route('seg.usuarios.permisos.update', $usuario) }}">
            @csrf
            @method('PUT')

            @forelse ($permisos as $nombreSistema => $grupoPermisos)
                <div class="card-section">
                    <h3 style="margin-top:0; color:#385506;">{{ $nombreSistema }}</h3>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Permiso</th>
                                    <th>Nombre</th>
                                    <th>Asignación directa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grupoPermisos as $permiso)
                                    @php
                                        $valor = array_key_exists($permiso->id_permiso, $directos)
                                            ? (string) ((int) $directos[$permiso->id_permiso])
                                            : '';
                                    @endphp
                                    <tr>
                                        <td>{{ $permiso->codigo }}</td>
                                        <td>{{ $permiso->nombre }}</td>
                                        <td>
                                            <select name="permisos[{{ $permiso->id_permiso }}]" class="form-control">
                                                <option value="">Sin regla directa</option>
                                                <option value="1" {{ $valor === '1' ? 'selected' : '' }}>Permitir</option>
                                                <option value="0" {{ $valor === '0' ? 'selected' : '' }}>Denegar</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <p>No hay permisos disponibles para este usuario.</p>
            @endforelse

            <div class="stack-mobile" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection