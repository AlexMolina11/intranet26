<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="id_sistema">Sistema</label>
        <select name="id_sistema" id="id_sistema" class="form-control">
            <option value="">Seleccione</option>
            @foreach ($sistemas as $sistema)
                <option value="{{ $sistema->id_sistema }}"
                    {{ (string) old('id_sistema', $permiso->id_sistema ?? '') === (string) $sistema->id_sistema ? 'selected' : '' }}>
                    {{ $sistema->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_sistema')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo" class="form-control"
            value="{{ old('codigo', $permiso->codigo ?? '') }}">
        @error('codigo')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control"
            value="{{ old('nombre', $permiso->nombre ?? '') }}">
        @error('nombre')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control">{{ old('descripcion', $permiso->descripcion ?? '') }}</textarea>
    </div>
</div>