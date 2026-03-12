<div class="form-group">
    <label class="form-label" for="id_departamento">Departamento</label>
    <select name="id_departamento" id="id_departamento" class="form-control" required>
        <option value="">-- Seleccione un departamento --</option>
        @foreach ($departamentos as $departamento)
            <option value="{{ $departamento->id_departamento }}"
                {{ (string) old('id_departamento', $area->id_departamento ?? '') === (string) $departamento->id_departamento ? 'selected' : '' }}>
                {{ $departamento->nombre }}
            </option>
        @endforeach
    </select>
    @error('id_departamento')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label" for="id_proyecto">Proyecto</label>
    <select name="id_proyecto" id="id_proyecto" class="form-control" required>
        <option value="">-- Seleccione un proyecto --</option>
        @foreach ($proyectos as $proyecto)
            <option value="{{ $proyecto->id_proyecto }}"
                {{ (string) old('id_proyecto', $area->id_proyecto ?? '') === (string) $proyecto->id_proyecto ? 'selected' : '' }}>
                {{ $proyecto->nombre }}
            </option>
        @endforeach
    </select>
    @error('id_proyecto')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label" for="nombre">Nombre del área</label>
    <input
        type="text"
        name="nombre"
        id="nombre"
        class="form-control"
        value="{{ old('nombre', $area->nombre ?? '') }}"
        required
    >
    @error('nombre')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label" for="descripcion">Descripción</label>
    <textarea
        name="descripcion"
        id="descripcion"
        class="form-control"
        rows="3"
    >{{ old('descripcion', $area->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>
        <input
            type="checkbox"
            name="activo"
            value="1"
            {{ old('activo', $area->activo ?? true) ? 'checked' : '' }}
        >
        Activo
    </label>
</div>