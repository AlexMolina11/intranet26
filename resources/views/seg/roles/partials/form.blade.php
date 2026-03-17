@php
    $estadoRol = (int) old('activo', isset($rol) ? (int) $rol->activo : 1);
@endphp

<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input
            type="text"
            name="nombre"
            id="nombre"
            class="form-control"
            value="{{ old('nombre', $rol->nombre ?? '') }}"
            required
        >
        @error('nombre')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="activo">Estado</label>
        <select name="activo" id="activo" class="form-control">
            <option value="1" {{ $estadoRol === 1 ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ $estadoRol === 0 ? 'selected' : '' }}>Inactivo</option>
        </select>
        @error('activo')
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
    >{{ old('descripcion', $rol->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>