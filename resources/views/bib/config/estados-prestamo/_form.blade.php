<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $estadoPrestamo->codigo ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $estadoPrestamo->nombre ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="orden">Orden</label>
        <input type="number" name="orden" id="orden" class="form-control" value="{{ old('orden', $estadoPrestamo->orden ?? 1) }}" min="1" required>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion', $estadoPrestamo->descripcion ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label><input type="checkbox" name="es_inicial" value="1" {{ old('es_inicial', $estadoPrestamo->es_inicial ?? false) ? 'checked' : '' }}> Es inicial</label>
    </div>

    <div class="form-group">
        <label><input type="checkbox" name="es_final" value="1" {{ old('es_final', $estadoPrestamo->es_final ?? false) ? 'checked' : '' }}> Es final</label>
    </div>

    <div class="form-group">
        <label><input type="checkbox" name="genera_multa" value="1" {{ old('genera_multa', $estadoPrestamo->genera_multa ?? false) ? 'checked' : '' }}> Genera multa</label>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control">
            <option value="1" {{ (string) old('activo', $estadoPrestamo->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $estadoPrestamo->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>