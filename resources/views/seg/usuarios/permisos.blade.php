@extends('layouts.app')

@section('title', 'Permisos directos del usuario')

@section('content')
    <div class="card">
        <h1>Permisos directos del usuario</h1>
        <p style="color:#64748b;">
            Usuario: <strong>{{ $usuario->nombres }} {{ $usuario->apellidos }}</strong>
        </p>

        <form method="POST" action="{{ route('seg.usuarios.permisos.update', $usuario) }}">
            @csrf
            @method('PUT')

            @forelse ($permisos as $nombreSistema => $grupoPermisos)
                <div style="margin-bottom:24px;">
                    <h3>{{ $nombreSistema }}</h3>

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
            @empty
                <p>No hay permisos disponibles para este usuario.</p>
            @endforelse

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection