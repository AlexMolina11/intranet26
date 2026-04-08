<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="id_usuario">Usuario</label>
        <select name="id_usuario" id="id_usuario" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}" {{ (string) old('id_usuario', $prestamo->id_usuario ?? '') === (string) $usuario->id_usuario ? 'selected' : '' }}>
                    {{ $usuario->nombre_completo }} ({{ $usuario->correo }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_recurso">Recurso</label>
        <select name="id_recurso" id="id_recurso" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($recursos as $recurso)
                <option value="{{ $recurso->id_recurso }}" {{ (string) old('id_recurso', $prestamo->id_recurso ?? '') === (string) $recurso->id_recurso ? 'selected' : '' }}>
                    {{ $recurso->titulo }}@if(!empty($recurso->codigo)) ({{ $recurso->codigo }}) @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_ejemplar">Ejemplar</label>
        <select name="id_ejemplar" id="id_ejemplar" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($ejemplares as $ejemplar)
                <option value="{{ $ejemplar->id_ejemplar }}" {{ (string) old('id_ejemplar', $prestamo->id_ejemplar ?? '') === (string) $ejemplar->id_ejemplar ? 'selected' : '' }}>
                    {{ $ejemplar->codigo_inventario }}@if($ejemplar->recurso) - {{ $ejemplar->recurso->titulo }} @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_estado_prestamo">Estado del préstamo</label>
        <select name="id_estado_prestamo" id="id_estado_prestamo" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($estadosPrestamo as $estado)
                <option value="{{ $estado->id_estado_prestamo }}" {{ (string) old('id_estado_prestamo', $prestamo->id_estado_prestamo ?? '') === (string) $estado->id_estado_prestamo ? 'selected' : '' }}>
                    {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_solicitud">Solicitud relacionada</label>
        <select name="id_solicitud" id="id_solicitud" class="form-control">
            <option value="">No aplica</option>
            @foreach($solicitudes as $solicitud)
                <option value="{{ $solicitud->id_solicitud }}" {{ (string) old('id_solicitud', $prestamo->id_solicitud ?? '') === (string) $solicitud->id_solicitud ? 'selected' : '' }}>
                    #{{ $solicitud->id_solicitud }} - {{ $solicitud->usuario?->nombre_completo }} - {{ $solicitud->recurso?->titulo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_prestamo">Fecha de préstamo</label>
        <input type="date" name="fecha_prestamo" id="fecha_prestamo" class="form-control"
            value="{{ old('fecha_prestamo', isset($prestamo?->fecha_prestamo) ? $prestamo->fecha_prestamo->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_vencimiento">Fecha de vencimiento</label>
        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control"
            value="{{ old('fecha_vencimiento', isset($prestamo?->fecha_vencimiento) ? $prestamo->fecha_vencimiento->format('Y-m-d') : now()->addDays(7)->format('Y-m-d')) }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_devolucion">Fecha de devolución</label>
        <input type="date" name="fecha_devolucion" id="fecha_devolucion" class="form-control"
            value="{{ old('fecha_devolucion', isset($prestamo?->fecha_devolucion) ? $prestamo->fecha_devolucion->format('Y-m-d') : '') }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="id_usuario_entrega">Usuario que entrega</label>
        <select name="id_usuario_entrega" id="id_usuario_entrega" class="form-control">
            <option value="">No asignado</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}" {{ (string) old('id_usuario_entrega', $prestamo->id_usuario_entrega ?? '') === (string) $usuario->id_usuario ? 'selected' : '' }}>
                    {{ $usuario->nombre_completo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_usuario_recibe">Usuario que recibe devolución</label>
        <select name="id_usuario_recibe" id="id_usuario_recibe" class="form-control">
            <option value="">No asignado</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}" {{ (string) old('id_usuario_recibe', $prestamo->id_usuario_recibe ?? '') === (string) $usuario->id_usuario ? 'selected' : '' }}>
                    {{ $usuario->nombre_completo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="dias_autorizados">Días autorizados</label>
        <input type="number" name="dias_autorizados" id="dias_autorizados" class="form-control"
            value="{{ old('dias_autorizados', $prestamo->dias_autorizados ?? 0) }}" min="0" required
            {{ ($soloLecturaPolitica ?? false) ? 'readonly' : '' }}>
    </div>

    <div class="form-group">
        <label class="form-label" for="renovaciones_usadas">Renovaciones usadas</label>
        <input type="number" name="renovaciones_usadas" id="renovaciones_usadas" class="form-control"
            value="{{ old('renovaciones_usadas', $prestamo->renovaciones_usadas ?? 0) }}" min="0" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="renovaciones_maximas">Renovaciones máximas</label>
        <input type="number" name="renovaciones_maximas" id="renovaciones_maximas" class="form-control"
            value="{{ old('renovaciones_maximas', $prestamo->renovaciones_maximas ?? 0) }}" min="0" required
            {{ ($soloLecturaPolitica ?? false) ? 'readonly' : '' }}>
    </div>

    <div class="form-group">
        <label class="form-label" for="multa_diaria">Multa diaria</label>
        <input type="number" step="0.01" name="multa_diaria" id="multa_diaria" class="form-control"
            value="{{ old('multa_diaria', $prestamo->multa_diaria ?? 0) }}" min="0" required
            {{ ($soloLecturaPolitica ?? false) ? 'readonly' : '' }}>
    </div>

    <div class="form-group">
        <label class="form-label" for="multa_acumulada">Multa acumulada</label>
        <input type="number" step="0.01" name="multa_acumulada" id="multa_acumulada" class="form-control"
            value="{{ old('multa_acumulada', $prestamo->multa_acumulada ?? 0) }}" min="0" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado del registro</label>
        <select name="activo" id="activo" class="form-control">
            <option value="1" {{ (string) old('activo', $prestamo->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $prestamo->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="observaciones">Observaciones</label>
        <textarea name="observaciones" id="observaciones" class="form-control" rows="4">{{ old('observaciones', $prestamo->observaciones ?? '') }}</textarea>
    </div>
</div>