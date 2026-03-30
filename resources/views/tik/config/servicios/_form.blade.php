<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="id_tipo_servicio">Tipo de servicio</label>
        <select name="id_tipo_servicio" id="id_tipo_servicio" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($tiposServicio as $tipo)
                <option value="{{ $tipo->id_tipo_servicio }}"
                    {{ (string) old('id_tipo_servicio', $servicio->id_tipo_servicio ?? '') === (string) $tipo->id_tipo_servicio ? 'selected' : '' }}>
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo" class="form-control"
               value="{{ old('codigo', $servicio->codigo ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control"
               value="{{ old('nombre', $servicio->nombre ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="orden">Orden</label>
        <input type="number" name="orden" id="orden" class="form-control"
               value="{{ old('orden', $servicio->orden ?? 1) }}" min="1" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control" required>
            <option value="1" {{ (string) old('activo', $servicio->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $servicio->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>