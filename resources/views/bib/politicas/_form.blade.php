<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="id_tipo_recurso">Tipo de recurso</label>
        <select name="id_tipo_recurso" id="id_tipo_recurso" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($tiposRecurso as $tipo)
                <option
                    value="{{ $tipo->id_tipo_recurso }}"
                    {{ (string) old('id_tipo_recurso', $politica->id_tipo_recurso ?? '') === (string) $tipo->id_tipo_recurso ? 'selected' : '' }}
                >
                    {{ $tipo->nombre }} ({{ $tipo->codigo }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="dias_prestamo">Días de préstamo</label>
        <input
            type="number"
            name="dias_prestamo"
            id="dias_prestamo"
            class="form-control"
            value="{{ old('dias_prestamo', $politica->dias_prestamo ?? 0) }}"
            min="0"
            required
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="max_renovaciones">Máximo de renovaciones</label>
        <input
            type="number"
            name="max_renovaciones"
            id="max_renovaciones"
            class="form-control"
            value="{{ old('max_renovaciones', $politica->max_renovaciones ?? 0) }}"
            min="0"
            required
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="max_prestamos_usuario">Máximo de préstamos por usuario</label>
        <input
            type="number"
            name="max_prestamos_usuario"
            id="max_prestamos_usuario"
            class="form-control"
            value="{{ old('max_prestamos_usuario', $politica->max_prestamos_usuario ?? 1) }}"
            min="1"
            required
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="multa_diaria">Multa diaria</label>
        <input
            type="number"
            step="0.01"
            name="multa_diaria"
            id="multa_diaria"
            class="form-control"
            value="{{ old('multa_diaria', $politica->multa_diaria ?? 0) }}"
            min="0"
            required
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="orden">Orden</label>
        <input
            type="number"
            name="orden"
            id="orden"
            class="form-control"
            value="{{ old('orden', $politica->orden ?? 1) }}"
            min="1"
            required
        >
    </div>

    <div class="form-group">
        <label class="form-label" for="permite_reserva">¿Permite reserva?</label>
        <select name="permite_reserva" id="permite_reserva" class="form-control">
            <option value="1" {{ (string) old('permite_reserva', $politica->permite_reserva ?? 0) === '1' ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ (string) old('permite_reserva', $politica->permite_reserva ?? 0) === '0' ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="requiere_aprobacion">¿Requiere aprobación?</label>
        <select name="requiere_aprobacion" id="requiere_aprobacion" class="form-control">
            <option value="1" {{ (string) old('requiere_aprobacion', $politica->requiere_aprobacion ?? 0) === '1' ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ (string) old('requiere_aprobacion', $politica->requiere_aprobacion ?? 0) === '0' ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="permite_prestamo_externo">¿Permite préstamo externo?</label>
        <select name="permite_prestamo_externo" id="permite_prestamo_externo" class="form-control">
            <option value="1" {{ (string) old('permite_prestamo_externo', $politica->permite_prestamo_externo ?? 1) === '1' ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ (string) old('permite_prestamo_externo', $politica->permite_prestamo_externo ?? 1) === '0' ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control">
            <option value="1" {{ (string) old('activo', $politica->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $politica->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="observaciones">Observaciones</label>
        <textarea
            name="observaciones"
            id="observaciones"
            class="form-control"
            rows="4"
        >{{ old('observaciones', $politica->observaciones ?? '') }}</textarea>
    </div>
</div>