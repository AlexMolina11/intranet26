<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $tipoRecurso->codigo ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $tipoRecurso->nombre ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="dias_prestamo_default">Días préstamo default</label>
        <input type="number" name="dias_prestamo_default" id="dias_prestamo_default" class="form-control" value="{{ old('dias_prestamo_default', $tipoRecurso->dias_prestamo_default ?? 0) }}" min="0" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="renovaciones_default">Renovaciones default</label>
        <input type="number" name="renovaciones_default" id="renovaciones_default" class="form-control" value="{{ old('renovaciones_default', $tipoRecurso->renovaciones_default ?? 0) }}" min="0" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="multa_diaria_default">Multa diaria default</label>
        <input type="number" step="0.01" name="multa_diaria_default" id="multa_diaria_default" class="form-control" value="{{ old('multa_diaria_default', $tipoRecurso->multa_diaria_default ?? 0) }}" min="0" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="orden">Orden</label>
        <input type="number" name="orden" id="orden" class="form-control" value="{{ old('orden', $tipoRecurso->orden ?? 1) }}" min="1" required>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion', $tipoRecurso->descripcion ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control">
            <option value="1" {{ (string) old('activo', $tipoRecurso->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $tipoRecurso->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>