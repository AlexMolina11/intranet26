<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $tipoAcceso->codigo ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $tipoAcceso->nombre ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="orden">Orden</label>
        <input type="number" name="orden" id="orden" class="form-control" value="{{ old('orden', $tipoAcceso->orden ?? 1) }}" min="1" required>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion', $tipoAcceso->descripcion ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="permite_prestamo" value="1" {{ old('permite_prestamo', $tipoAcceso->permite_prestamo ?? false) ? 'checked' : '' }}>
            Permite préstamo
        </label>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="requiere_autorizacion" value="1" {{ old('requiere_autorizacion', $tipoAcceso->requiere_autorizacion ?? false) ? 'checked' : '' }}>
            Requiere autorización
        </label>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control">
            <option value="1" {{ (string) old('activo', $tipoAcceso->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $tipoAcceso->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>