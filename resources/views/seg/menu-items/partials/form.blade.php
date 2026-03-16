<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="id_sistema">Sistema</label>
        <select name="id_sistema" id="id_sistema" class="form-control">
            <option value="">Seleccione</option>
            @foreach ($sistemas as $sistema)
                <option value="{{ $sistema->id_sistema }}"
                    {{ (string) old('id_sistema', $menuItem->id_sistema ?? '') === (string) $sistema->id_sistema ? 'selected' : '' }}>
                    {{ $sistema->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_sistema')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="id_menu">Menú principal</label>
        <select name="id_menu" id="id_menu" class="form-control">
            <option value="">Seleccione</option>
            @foreach ($menus as $menu)
                <option value="{{ $menu->id_menu }}"
                    {{ (string) old('id_menu', $menuItem->id_menu ?? '') === (string) $menu->id_menu ? 'selected' : '' }}>
                    {{ $menu->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_menu')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="id_menu_item_padre">Submenú padre</label>
        <select name="id_menu_item_padre" id="id_menu_item_padre" class="form-control">
            <option value="">Ninguno (opción principal)</option>
            @foreach ($padres as $padre)
                <option value="{{ $padre->id_menu_item }}"
                    {{ (string) old('id_menu_item_padre', $menuItem->id_menu_item_padre ?? '') === (string) $padre->id_menu_item ? 'selected' : '' }}>
                    {{ $padre->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_menu_item_padre')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control"
            value="{{ old('nombre', $menuItem->nombre ?? '') }}">
        @error('nombre')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="ruta">Ruta</label>
        <input type="text" name="ruta" id="ruta" class="form-control"
            value="{{ old('ruta', $menuItem->ruta ?? '') }}">
        @error('ruta')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="icono">Icono</label>
        <input type="text" name="icono" id="icono" class="form-control"
            value="{{ old('icono', $menuItem->icono ?? '') }}">
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="orden">Orden</label>
        <input type="number" name="orden" id="orden" min="1" class="form-control"
            value="{{ old('orden', $menuItem->orden ?? 1) }}">
        @error('orden')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="permiso_requerido">Permiso requerido</label>
        <select name="permiso_requerido" id="permiso_requerido" class="form-control">
            <option value="">Sin permiso requerido</option>
            @foreach ($permisos as $permiso)
                <option value="{{ $permiso->codigo }}"
                    {{ (string) old('permiso_requerido', $menuItem->permiso_requerido ?? '') === (string) $permiso->codigo ? 'selected' : '' }}>
                    {{ $permiso->codigo }} - {{ $permiso->nombre }}
                </option>
            @endforeach
        </select>
        @error('permiso_requerido')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label>
            <input type="checkbox" name="visible" value="1"
                {{ old('visible', isset($menuItem) ? (int) $menuItem->visible : 1) ? 'checked' : '' }}>
            Visible
        </label>
    </div>

    <div class="form-group">
        <label>
            <input type="checkbox" name="es_externo" value="1"
                {{ old('es_externo', isset($menuItem) ? (int) $menuItem->es_externo : 0) ? 'checked' : '' }}>
            Enlace externo
        </label>
    </div>
</div>

<div class="form-group">
    <label>
        <input type="checkbox" name="abre_nueva_pestana" value="1"
            {{ old('abre_nueva_pestana', isset($menuItem) ? (int) $menuItem->abre_nueva_pestana : 0) ? 'checked' : '' }}>
        Abrir en nueva pestaña
    </label>
</div>