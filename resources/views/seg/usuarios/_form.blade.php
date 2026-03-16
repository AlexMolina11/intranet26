<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="nombres">Nombres</label>
        <input
            type="text"
            name="nombres"
            id="nombres"
            class="form-control"
            value="{{ old('nombres', $usuario->nombres ?? '') }}"
            required
        >
        @error('nombres')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="apellidos">Apellidos</label>
        <input
            type="text"
            name="apellidos"
            id="apellidos"
            class="form-control"
            value="{{ old('apellidos', $usuario->apellidos ?? '') }}"
            required
        >
        @error('apellidos')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="correo">Correo</label>
        <input
            type="email"
            name="correo"
            id="correo"
            class="form-control"
            value="{{ old('correo', $usuario->correo ?? '') }}"
            required
        >
        @error('correo')
            <div class="text-danger">{{ $message }}</div>
        @enderror

        <small style="display:block; margin-top:6px; color:#656264;">
            El nombre de usuario se genera automáticamente con el texto antes del símbolo @ del correo.
        </small>
    </div>

    @isset($usuario)
        <div class="form-group">
            <label class="form-label">Nombre de usuario actual</label>
            <input
                type="text"
                class="form-control"
                value="{{ $usuario->nombre_usuario }}"
                disabled
            >
            <small style="display:block; margin-top:6px; color:#656264;">
                Este valor se actualiza automáticamente según el prefijo del correo.
            </small>
        </div>
    @endisset
</div>

<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="clave">
            Contraseña
            @isset($usuario)
                <small>(dejar en blanco para conservar la actual)</small>
            @endisset
        </label>
        <input
            type="password"
            name="clave"
            id="clave"
            class="form-control"
            {{ isset($usuario) ? '' : 'required' }}
        >
        @error('clave')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="clave_confirmation">Confirmar contraseña</label>
        <input
            type="password"
            name="clave_confirmation"
            id="clave_confirmation"
            class="form-control"
            {{ isset($usuario) ? '' : 'required' }}
        >
    </div>
</div>

<div class="form-group">
    <label>
        <input
            type="checkbox"
            name="activo"
            value="1"
            {{ old('activo', $usuario->activo ?? true) ? 'checked' : '' }}
        >
        Usuario activo
    </label>
</div>