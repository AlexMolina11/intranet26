<div class="form-group">
    <label class="form-label" for="codigo">Código</label>
    <input type="text" name="codigo" id="codigo" class="form-control"
        value="{{ old('codigo', $sistema->codigo ?? '') }}">
    @error('codigo')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label" for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control"
        value="{{ old('nombre', $sistema->nombre ?? '') }}">
    @error('nombre')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label" for="slug">Slug</label>
    <input type="text" name="slug" id="slug" class="form-control"
        value="{{ old('slug', $sistema->slug ?? '') }}">
    @error('slug')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label" for="descripcion">Descripción</label>
    <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $sistema->descripcion ?? '') }}</textarea>
</div>

<div class="form-group">
    <label class="form-label" for="icono">Ícono</label>
    <input type="text" name="icono" id="icono" class="form-control"
        value="{{ old('icono', $sistema->icono ?? '') }}">
</div>

<div class="form-group">
    <label class="form-label" for="url_base">URL base</label>
    <input type="text" name="url_base" id="url_base" class="form-control"
        value="{{ old('url_base', $sistema->url_base ?? '') }}">
</div>

<div class="form-group">
    <label class="form-label" for="orden">Orden</label>
    <input type="number" name="orden" id="orden" class="form-control"
        value="{{ old('orden', $sistema->orden ?? 0) }}">
    @error('orden')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

@php
    $estadoSistema = (int) old('activo', isset($sistema) ? (int) $sistema->activo : 1);
@endphp

<div class="form-group">
    <label class="form-label" for="activo">Estado</label>
    <select name="activo" id="activo" class="form-control">
        <option value="1" {{ $estadoSistema === 1 ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ $estadoSistema === 0 ? 'selected' : '' }}>Inactivo</option>
    </select>
</div>