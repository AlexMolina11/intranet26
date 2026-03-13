<div class="form-group">
    <label class="form-label" for="id_sistema">Sistema</label>
    <select name="id_sistema" id="id_sistema" class="form-control">
        <option value="">Seleccione</option>
        @foreach ($sistemas as $sistema)
            <option value="{{ $sistema->id_sistema }}"
                {{ (string) old('id_sistema', $menu->id_sistema ?? '') === (string) $sistema->id_sistema ? 'selected' : '' }}>
                {{ $sistema->nombre }}
            </option>
        @endforeach
    </select>
    @error('id_sistema')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label" for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" class="form-control"
        value="{{ old('nombre', $menu->nombre ?? '') }}">
    @error('nombre')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label" for="icono">Icono</label>
    <input type="text" name="icono" id="icono" class="form-control"
        value="{{ old('icono', $menu->icono ?? '') }}">
</div>

<div class="form-group">
    <label class="form-label" for="orden">Orden</label>
    <input type="number" name="orden" id="orden" min="1" class="form-control"
        value="{{ old('orden', $menu->orden ?? 1) }}">
    @error('orden')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label>
        <input type="checkbox" name="visible" value="1"
            {{ old('visible', isset($menu) ? (int) $menu->visible : 1) ? 'checked' : '' }}>
        Visible
    </label>
</div>