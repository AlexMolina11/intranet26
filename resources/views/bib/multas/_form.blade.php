<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="id_prestamo">Préstamo</label>
        <select name="id_prestamo" id="id_prestamo" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($prestamos as $prestamo)
                <option
                    value="{{ $prestamo->id_prestamo }}"
                    {{ (string) old('id_prestamo', $multa->id_prestamo ?? '') === (string) $prestamo->id_prestamo ? 'selected' : '' }}
                >
                    #{{ $prestamo->id_prestamo }} - {{ $prestamo->usuario?->nombre_completo }} - {{ $prestamo->recurso?->titulo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_usuario">Usuario</label>
        <select name="id_usuario" id="id_usuario" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($usuarios as $usuario)
                <option
                    value="{{ $usuario->id_usuario }}"
                    {{ (string) old('id_usuario', $multa->id_usuario ?? '') === (string) $usuario->id_usuario ? 'selected' : '' }}
                >
                    {{ $usuario->nombre_completo }} ({{ $usuario->correo }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_multa">Fecha de multa</label>
        <input
            type="date"
            name="fecha_multa"
            id="fecha_multa"
            class="form-control"
            value="{{ old('fecha_multa', isset($multa?->fecha_multa) ? $multa->fecha_multa->format('Y-m-d') : now()->format('Y-m-d')) }}"
            required
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="dias_atraso">Días de atraso</label>
        <input
            type="number"
            name="dias_atraso"
            id="dias_atraso"
            class="form-control"
            value="{{ old('dias_atraso', $multa->dias_atraso ?? 0) }}"
            min="0"
            required
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="monto">Monto</label>
        <input
            type="number"
            step="0.01"
            name="monto"
            id="monto"
            class="form-control"
            value="{{ old('monto', $multa->monto ?? 0) }}"
            min="0"
            required
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="monto_pagado">Monto pagado</label>
        <input
            type="number"
            step="0.01"
            name="monto_pagado"
            id="monto_pagado"
            class="form-control"
            value="{{ old('monto_pagado', $multa->monto_pagado ?? 0) }}"
            min="0"
            required
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="pagada">¿Pagada?</label>
        <select name="pagada" id="pagada" class="form-control">
            <option value="1" {{ (string) old('pagada', $multa->pagada ?? 0) === '1' ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ (string) old('pagada', $multa->pagada ?? 0) === '0' ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_pago">Fecha de pago</label>
        <input
            type="date"
            name="fecha_pago"
            id="fecha_pago"
            class="form-control"
            value="{{ old('fecha_pago', isset($multa?->fecha_pago) ? $multa->fecha_pago->format('Y-m-d') : '') }}"
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado del registro</label>
        <select name="activo" id="activo" class="form-control">
            <option value="1" {{ (string) old('activo', $multa->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $multa->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="motivo">Motivo</label>
        <textarea name="motivo" id="motivo" class="form-control" rows="3">{{ old('motivo', $multa->motivo ?? '') }}</textarea>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="observaciones">Observaciones</label>
        <textarea name="observaciones" id="observaciones" class="form-control" rows="3">{{ old('observaciones', $multa->observaciones ?? '') }}</textarea>
    </div>
</div>