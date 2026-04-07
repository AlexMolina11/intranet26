<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="id_usuario">Usuario</label>
        <select name="id_usuario" id="id_usuario" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($usuarios as $usuario)
                <option
                    value="{{ $usuario->id_usuario }}"
                    {{ (string) old('id_usuario', $solicitud->id_usuario ?? '') === (string) $usuario->id_usuario ? 'selected' : '' }}
                >
                    {{ $usuario->nombre }} ({{ $usuario->correo }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_recurso">Recurso</label>
        <select name="id_recurso" id="id_recurso" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($recursos as $recurso)
                <option
                    value="{{ $recurso->id_recurso }}"
                    {{ (string) old('id_recurso', $solicitud->id_recurso ?? '') === (string) $recurso->id_recurso ? 'selected' : '' }}
                >
                    {{ $recurso->titulo }}
                    @if(!empty($recurso->codigo))
                        ({{ $recurso->codigo }})
                    @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_ejemplar">Ejemplar</label>
        <select name="id_ejemplar" id="id_ejemplar" class="form-control">
            <option value="">No especificado</option>
            @foreach($ejemplares as $ejemplar)
                <option
                    value="{{ $ejemplar->id_ejemplar }}"
                    {{ (string) old('id_ejemplar', $solicitud->id_ejemplar ?? '') === (string) $ejemplar->id_ejemplar ? 'selected' : '' }}
                >
                    {{ $ejemplar->codigo_inventario }}
                    @if($ejemplar->recurso)
                        - {{ $ejemplar->recurso->titulo }}
                    @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_estado_solicitud">Estado de solicitud</label>
        <select name="id_estado_solicitud" id="id_estado_solicitud" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($estadosSolicitud as $estado)
                <option
                    value="{{ $estado->id_estado_solicitud }}"
                    {{ (string) old('id_estado_solicitud', $solicitud->id_estado_solicitud ?? '') === (string) $estado->id_estado_solicitud ? 'selected' : '' }}
                >
                    {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_solicitud">Fecha de solicitud</label>
        <input
            type="date"
            name="fecha_solicitud"
            id="fecha_solicitud"
            class="form-control"
            value="{{ old('fecha_solicitud', isset($solicitud?->fecha_solicitud) ? $solicitud->fecha_solicitud->format('Y-m-d') : now()->format('Y-m-d')) }}"
            required
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_requerida">Fecha requerida</label>
        <input
            type="date"
            name="fecha_requerida"
            id="fecha_requerida"
            class="form-control"
            value="{{ old('fecha_requerida', isset($solicitud?->fecha_requerida) ? $solicitud->fecha_requerida->format('Y-m-d') : '') }}"
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_atencion">Fecha de atención</label>
        <input
            type="date"
            name="fecha_atencion"
            id="fecha_atencion"
            class="form-control"
            value="{{ old('fecha_atencion', isset($solicitud?->fecha_atencion) ? $solicitud->fecha_atencion->format('Y-m-d') : '') }}"
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="id_usuario_atiende">Atendida por</label>
        <select name="id_usuario_atiende" id="id_usuario_atiende" class="form-control">
            <option value="">No asignado</option>
            @foreach($usuarios as $usuario)
                <option
                    value="{{ $usuario->id_usuario }}"
                    {{ (string) old('id_usuario_atiende', $solicitud->id_usuario_atiende ?? '') === (string) $usuario->id_usuario ? 'selected' : '' }}
                >
                    {{ $usuario->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado del registro</label>
        <select name="activo" id="activo" class="form-control">
            <option value="1" {{ (string) old('activo', $solicitud->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $solicitud->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="motivo">Motivo</label>
        <textarea
            name="motivo"
            id="motivo"
            class="form-control"
            rows="3"
        >{{ old('motivo', $solicitud->motivo ?? '') }}</textarea>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="observaciones">Observaciones</label>
        <textarea
            name="observaciones"
            id="observaciones"
            class="form-control"
            rows="3"
        >{{ old('observaciones', $solicitud->observaciones ?? '') }}</textarea>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="observaciones_internas">Observaciones internas</label>
        <textarea
            name="observaciones_internas"
            id="observaciones_internas"
            class="form-control"
            rows="3"
        >{{ old('observaciones_internas', $solicitud->observaciones_internas ?? '') }}</textarea>
    </div>
</div>