<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="codigo">Código</label>
        <input
            type="text"
            name="codigo"
            id="codigo"
            class="form-control"
            value="{{ old('codigo', $departamento->codigo ?? '') }}"
        >
        @error('codigo')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input
            type="text"
            name="nombre"
            id="nombre"
            class="form-control"
            value="{{ old('nombre', $departamento->nombre ?? '') }}"
            required
        >
        @error('nombre')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group">
    <label class="form-label" for="descripcion">Descripción</label>
    <textarea
        name="descripcion"
        id="descripcion"
        class="form-control"
        rows="3"
    >{{ old('descripcion', $departamento->descripcion ?? '') }}</textarea>
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
            {{ old('activo', $departamento->activo ?? true) ? 'checked' : '' }}
        >
        Activo
    </label>
</div>