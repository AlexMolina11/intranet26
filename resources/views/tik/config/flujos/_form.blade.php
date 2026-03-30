<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="id_tipo_ticket">Tipo de ticket</label>
        <select name="id_tipo_ticket" id="id_tipo_ticket" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($tiposTicket as $tipo)
                <option value="{{ $tipo->id_tipo_ticket }}"
                    {{ (string) old('id_tipo_ticket', $flujo->id_tipo_ticket ?? '') === (string) $tipo->id_tipo_ticket ? 'selected' : '' }}>
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_estado_ticket">Estado</label>
        <select name="id_estado_ticket" id="id_estado_ticket" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($estados as $estado)
                <option value="{{ $estado->id_estado_ticket }}"
                    {{ (string) old('id_estado_ticket', $flujo->id_estado_ticket ?? '') === (string) $estado->id_estado_ticket ? 'selected' : '' }}>
                    {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="mensaje_usuario">Mensaje usuario</label>
        <textarea name="mensaje_usuario" id="mensaje_usuario" class="form-control" rows="4">{{ old('mensaje_usuario', $flujo->mensaje_usuario ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label class="form-label" for="mensaje_admin">Mensaje admin</label>
        <textarea name="mensaje_admin" id="mensaje_admin" class="form-control" rows="4">{{ old('mensaje_admin', $flujo->mensaje_admin ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label class="form-label" for="orden">Orden</label>
        <input type="number" name="orden" id="orden" class="form-control"
               value="{{ old('orden', $flujo->orden ?? 1) }}" min="1" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control" required>
            <option value="1" {{ (string) old('activo', $flujo->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $flujo->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>