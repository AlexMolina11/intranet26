@extends('layouts.app')

@section('title', 'Asignación organizacional')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:20px;">
            <div>
                <h1 style="margin:0;">Asignación organizacional</h1>
                <p style="margin:6px 0 0 0; color:#64748b;">
                    Usuario: <strong>{{ $usuario->nombre_completo }}</strong>
                </p>
                <p style="margin:6px 0 0 0; color:#64748b;">
                    Correo: {{ $usuario->correo }}
                </p>
            </div>

            <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Volver</a>
        </div>

        <form method="POST" action="{{ route('org.usuarios.organizacion.update', $usuario) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="id_area_principal">Área principal</label>
                <select name="id_area_principal" id="id_area_principal" class="form-control">
                    <option value="">-- Seleccione un área principal --</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->id_area }}"
                            {{ (string) old('id_area_principal', $idAreaPrincipal) === (string) $area->id_area ? 'selected' : '' }}>
                            {{ $area->nombre_organizacional }}
                        </option>
                    @endforeach
                </select>

                @error('id_area_principal')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <small>
                    Esta será la ubicación organizacional principal del usuario.
                </small>
            </div>

            <div class="form-group">
                <label class="form-label" for="areas_secundarias">Áreas secundarias</label>
                <select name="areas_secundarias[]" id="areas_secundarias" class="form-control" multiple size="10">
                    @foreach ($areas as $area)
                        <option value="{{ $area->id_area }}"
                            {{ in_array($area->id_area, old('areas_secundarias', $idsAreasSecundarias)) ? 'selected' : '' }}>
                            {{ $area->nombre_organizacional }}
                        </option>
                    @endforeach
                </select>

                @error('areas_secundarias')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                @error('areas_secundarias.*')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

                <small>
                    Puede elegir varias áreas secundarias usando Ctrl + clic.
                </small>
            </div>

            <div style="margin-top:24px;">
                <h3 style="margin-bottom:12px;">Resumen actual</h3>

                <div style="padding:14px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px;">
                    <div style="margin-bottom:12px;">
                        <strong>Área principal actual:</strong><br>
                        @if ($usuario->areaPrincipalAsignada && $usuario->areaPrincipalAsignada->area)
                            {{ $usuario->areaPrincipalAsignada->area->nombre_organizacional }}
                        @else
                            Sin área principal asignada
                        @endif
                    </div>

                    <div>
                        <strong>Áreas secundarias actuales:</strong><br>
                        @if ($usuario->areasSecundariasAsignadas->count())
                            @foreach ($usuario->areasSecundariasAsignadas as $asignacion)
                                @if ($asignacion->area)
                                    <div>- {{ $asignacion->area->nombre_organizacional }}</div>
                                @endif
                            @endforeach
                        @else
                            Sin áreas secundarias asignadas
                        @endif
                    </div>
                </div>
            </div>

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Guardar asignación</button>
                <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection