<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo" class="form-control"
               value="{{ old('codigo', $tipoServicio->codigo ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control"
               value="{{ old('nombre', $tipoServicio->nombre ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_area_responsable">Área responsable</label>
        <select name="id_area_responsable" id="id_area_responsable" class="form-control">
            <option value="">Seleccione</option>
            @foreach($areas as $area)
                <option value="{{ $area->id_area }}"
                    {{ (string) old('id_area_responsable', $tipoServicio->id_area_responsable ?? '') === (string) $area->id_area ? 'selected' : '' }}>
                    {{ $area->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="orden">Orden</label>
        <input type="number" name="orden" id="orden" class="form-control"
               value="{{ old('orden', $tipoServicio->orden ?? 1) }}" min="1" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control" required>
            <option value="1" {{ (string) old('activo', $tipoServicio->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $tipoServicio->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>