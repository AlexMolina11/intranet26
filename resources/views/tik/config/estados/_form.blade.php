<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo" class="form-control"
               value="{{ old('codigo', $estado->codigo ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control"
               value="{{ old('nombre', $estado->nombre ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="color">Color</label>
        <input type="text" name="color" id="color" class="form-control"
               value="{{ old('color', $estado->color ?? '') }}" placeholder="#779123">
    </div>

    <div class="form-group">
        <label class="form-label" for="id_estado_siguiente">Estado siguiente</label>
        <select name="id_estado_siguiente" id="id_estado_siguiente" class="form-control">
            <option value="">Seleccione</option>
            @foreach($estadosSiguientes as $item)
                <option value="{{ $item->id_estado_ticket }}"
                    {{ (string) old('id_estado_siguiente', $estado->id_estado_siguiente ?? '') === (string) $item->id_estado_ticket ? 'selected' : '' }}>
                    {{ $item->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="es_inicial">¿Es inicial?</label>
        <select name="es_inicial" id="es_inicial" class="form-control" required>
            <option value="1" {{ (string) old('es_inicial', $estado->es_inicial ?? 0) === '1' ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ (string) old('es_inicial', $estado->es_inicial ?? 0) === '0' ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="es_final">¿Es final?</label>
        <select name="es_final" id="es_final" class="form-control" required>
            <option value="1" {{ (string) old('es_final', $estado->es_final ?? 0) === '1' ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ (string) old('es_final', $estado->es_final ?? 0) === '0' ? 'selected' : '' }}>No</option>
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="orden">Orden</label>
        <input type="number" name="orden" id="orden" class="form-control"
               value="{{ old('orden', $estado->orden ?? 1) }}" min="1" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control" required>
            <option value="1" {{ (string) old('activo', $estado->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $estado->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>