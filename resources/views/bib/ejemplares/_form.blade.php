<div class="form-grid form-grid-3">
    <div class="form-group">
        <label class="form-label" for="id_recurso">Recurso</label>
        <select name="id_recurso" id="id_recurso" class="form-control @error('id_recurso') is-invalid @enderror" required>
            <option value="">Seleccione</option>
            @foreach($recursos as $recursoItem)
                <option value="{{ $recursoItem->id_recurso }}" @selected(old('id_recurso', $ejemplar->id_recurso ?? '') == $recursoItem->id_recurso)>
                    {{ $recursoItem->titulo_completo ?? $recursoItem->titulo }}
                </option>
            @endforeach
        </select>
        @error('id_recurso')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="codigo_inventario">Código de inventario</label>
        <input
            type="text"
            name="codigo_inventario"
            id="codigo_inventario"
            class="form-control @error('codigo_inventario') is-invalid @enderror"
            value="{{ old('codigo_inventario', $ejemplar->codigo_inventario ?? '') }}"
            maxlength="100"
            required>
        @error('codigo_inventario')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="codigo_barras">Código de barras</label>
        <input
            type="text"
            name="codigo_barras"
            id="codigo_barras"
            class="form-control @error('codigo_barras') is-invalid @enderror"
            value="{{ old('codigo_barras', $ejemplar->codigo_barras ?? '') }}"
            maxlength="100">
        @error('codigo_barras')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid form-grid-2">
    <div class="form-group">
        <label class="form-label" for="id_estado_ejemplar">Estado del ejemplar</label>
        <select name="id_estado_ejemplar" id="id_estado_ejemplar" class="form-control @error('id_estado_ejemplar') is-invalid @enderror" required>
            <option value="">Seleccione</option>
            @foreach($estados as $estado)
                <option value="{{ $estado->id_estado_ejemplar }}" @selected(old('id_estado_ejemplar', $ejemplar->id_estado_ejemplar ?? '') == $estado->id_estado_ejemplar)>
                    {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_estado_ejemplar')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="id_disponibilidad">Disponibilidad</label>
        <select name="id_disponibilidad" id="id_disponibilidad" class="form-control @error('id_disponibilidad') is-invalid @enderror" required>
            <option value="">Seleccione</option>
            @foreach($disponibilidades as $disponibilidad)
                <option value="{{ $disponibilidad->id_disponibilidad }}" @selected(old('id_disponibilidad', $ejemplar->id_disponibilidad ?? '') == $disponibilidad->id_disponibilidad)>
                    {{ $disponibilidad->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_disponibilidad')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid form-grid-2">
    <div class="form-group">
        <label class="form-label" for="ubicacion">Ubicación</label>
        <input
            type="text"
            name="ubicacion"
            id="ubicacion"
            class="form-control @error('ubicacion') is-invalid @enderror"
            value="{{ old('ubicacion', $ejemplar->ubicacion ?? '') }}"
            maxlength="255">
        @error('ubicacion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="condicion">Condición</label>
        <input
            type="text"
            name="condicion"
            id="condicion"
            class="form-control @error('condicion') is-invalid @enderror"
            value="{{ old('condicion', $ejemplar->condicion ?? '') }}"
            maxlength="255">
        @error('condicion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid form-grid-2">
    <div class="form-group">
        <label class="form-label" for="fecha_adquisicion">Fecha de adquisición</label>
        <input
            type="date"
            name="fecha_adquisicion"
            id="fecha_adquisicion"
            class="form-control @error('fecha_adquisicion') is-invalid @enderror"
            value="{{ old('fecha_adquisicion', isset($ejemplar->fecha_adquisicion) ? $ejemplar->fecha_adquisicion->format('Y-m-d') : '') }}">
        @error('fecha_adquisicion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="costo">Costo</label>
        <input
            type="number"
            step="0.01"
            min="0"
            name="costo"
            id="costo"
            class="form-control @error('costo') is-invalid @enderror"
            value="{{ old('costo', $ejemplar->costo ?? '') }}">
        @error('costo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group" style="margin-top:16px;">
    <label style="display:flex; align-items:center; gap:8px;">
        <input type="checkbox" name="activo" value="1" @checked(old('activo', $ejemplar->activo ?? true))>
        <span>Activo</span>
    </label>
</div>