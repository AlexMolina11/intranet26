<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $autor->nombre ?? '') }}" required>
    </div>

    <div class="form-group">
        <label class="form-label" for="apellido">Apellido</label>
        <input type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido', $autor->apellido ?? '') }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="seudonimo">Seudónimo</label>
        <input type="text" name="seudonimo" id="seudonimo" class="form-control" value="{{ old('seudonimo', $autor->seudonimo ?? '') }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_nacimiento">Fecha de nacimiento</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', isset($autor->fecha_nacimiento) ? $autor->fecha_nacimiento->format('Y-m-d') : '') }}">
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_fallecimiento">Fecha de fallecimiento</label>
        <input type="date" name="fecha_fallecimiento" id="fecha_fallecimiento" class="form-control" value="{{ old('fecha_fallecimiento', isset($autor->fecha_fallecimiento) ? $autor->fecha_fallecimiento->format('Y-m-d') : '') }}">
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="biografia">Biografía</label>
        <textarea name="biografia" id="biografia" class="form-control" rows="4">{{ old('biografia', $autor->biografia ?? '') }}</textarea>
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control">
            <option value="1" {{ (string) old('activo', $autor->activo ?? 1) === '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ (string) old('activo', $autor->activo ?? 1) === '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>