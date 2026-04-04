<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control"
               value="{{ old('nombre', $item->nombre ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="sigla">Sigla</label>
        <input type="text" name="sigla" id="sigla" class="form-control"
               value="{{ old('sigla', $item->sigla ?? '') }}">
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="sitio_web">Sitio web</label>
        <input type="text" name="sitio_web" id="sitio_web" class="form-control"
               value="{{ old('sitio_web', $item->sitio_web ?? '') }}">
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ old('descripcion', $item->descripcion ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control">
            <option value="1" {{ (string) old('activo', $item->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $item->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>