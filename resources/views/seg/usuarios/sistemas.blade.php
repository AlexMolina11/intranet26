@extends('layouts.app')

@section('title', 'Acceso a sistemas')

@section('content')
    <div class="card">
        <h1>Acceso a sistemas</h1>
        <p style="color:#64748b;">
            Usuario: <strong>{{ $usuario->nombres }} {{ $usuario->apellidos }}</strong>
        </p>

        <form method="POST" action="{{ route('seg.usuarios.sistemas.update', $usuario) }}">
            @csrf
            @method('PUT')

            <table class="table">
                <thead>
                    <tr>
                        <th>Asignar</th>
                        <th>Sistema</th>
                        <th>Estado de acceso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sistemas as $sistema)
                        @php
                            $tieneAsignacion = array_key_exists($sistema->id_sistema, $asignados);
                            $activoAsignado = $tieneAsignacion ? (int) $asignados[$sistema->id_sistema] : 1;
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox"
                                    name="sistemas[{{ $loop->index }}][id_sistema]"
                                    value="{{ $sistema->id_sistema }}"
                                    {{ $tieneAsignacion ? 'checked' : '' }}>
                            </td>
                            <td>{{ $sistema->nombre }}</td>
                            <td>
                                <select name="sistemas[{{ $loop->index }}][activo]" class="form-control">
                                    <option value="1" {{ $activoAsignado === 1 ? 'selected' : '' }}>Activo</option>
                                    <option value="0" {{ $activoAsignado === 0 ? 'selected' : '' }}>Inactivo</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection