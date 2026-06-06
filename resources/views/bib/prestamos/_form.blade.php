<div class="form-grid">
    <div class="form-group">
        <label class="form-label" for="id_usuario">Usuario</label>
        <select name="id_usuario" id="id_usuario" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}" {{ (string) old('id_usuario', $prestamo->id_usuario ?? '') === (string) $usuario->id_usuario ? 'selected' : '' }}>
                    {{ $usuario->nombre_completo }} ({{ $usuario->correo }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_recurso">Recurso</label>
        <select name="id_recurso" id="id_recurso" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($recursos as $recurso)
                <option value="{{ $recurso->id_recurso }}" {{ (string) old('id_recurso', $prestamo->id_recurso ?? '') === (string) $recurso->id_recurso ? 'selected' : '' }}>
                    {{ $recurso->titulo }}@if(!empty($recurso->codigo)) ({{ $recurso->codigo }}) @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_ejemplar">Ejemplar</label>
        <select name="id_ejemplar" id="id_ejemplar" class="form-control" required>
            <option value="">Seleccione</option>
            @foreach($ejemplares as $ejemplar)
                <option value="{{ $ejemplar->id_ejemplar }}" {{ (string) old('id_ejemplar', $prestamo->id_ejemplar ?? '') === (string) $ejemplar->id_ejemplar ? 'selected' : '' }}>
                    {{ $ejemplar->codigo_inventario }}@if($ejemplar->recurso) - {{ $ejemplar->recurso->titulo }} @endif
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="id_solicitud">Solicitud relacionada</label>
        <select name="id_solicitud" id="id_solicitud" class="form-control">
            <option value="">No aplica</option>
            @foreach($solicitudes as $solicitud)
                <option value="{{ $solicitud->id_solicitud }}" {{ (string) old('id_solicitud', $prestamo->id_solicitud ?? '') === (string) $solicitud->id_solicitud ? 'selected' : '' }}>
                    #{{ $solicitud->id_solicitud }} - {{ $solicitud->usuario?->nombre_completo }} - {{ $solicitud->recurso?->titulo }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label" for="fecha_prestamo">Fecha de préstamo</label>
        <input
            type="date"
            name="fecha_prestamo"
            id="fecha_prestamo"
            class="form-control"
            value="{{ old('fecha_prestamo', isset($prestamo?->fecha_prestamo) ? $prestamo->fecha_prestamo->format('Y-m-d') : now()->format('Y-m-d')) }}"
            required
        >
        <small class="form-text">Al guardar, el sistema calculará el vencimiento según la política del tipo de recurso.</small>
    </div>

    <div class="form-group" style="grid-column: 1 / -1;">
        <label class="form-label" for="observaciones">Observaciones</label>
        <textarea name="observaciones" id="observaciones" class="form-control" rows="4">{{ old('observaciones', $prestamo->observaciones ?? '') }}</textarea>
    </div>

    @if(isset($prestamo) && $prestamo->exists)
        <div class="form-group" style="grid-column: 1 / -1;">
            <div class="card" style="background:#f8fafc;">
                <h3 style="margin-top:0;">Información automática del préstamo</h3>

                <div class="form-grid">
                    <div>
                        <strong>Estado:</strong><br>
                        {{ $prestamo->estadoPrestamo?->nombre ?? 'Pendiente' }}
                    </div>

                    <div>
                        <strong>Vencimiento:</strong><br>
                        {{ optional($prestamo->fecha_vencimiento)->format('d/m/Y') ?? 'Pendiente' }}
                    </div>

                    <div>
                        <strong>Fecha devolución:</strong><br>
                        {{ optional($prestamo->fecha_devolucion)->format('d/m/Y') ?? 'Sin devolución' }}
                    </div>

                    <div>
                        <strong>Días autorizados:</strong><br>
                        {{ $prestamo->dias_autorizados ?? 0 }}
                    </div>

                    <div>
                        <strong>Renovaciones:</strong><br>
                        {{ $prestamo->renovaciones_usadas ?? 0 }} / {{ $prestamo->renovaciones_maximas ?? 0 }}
                    </div>

                    <div>
                        <strong>Multa diaria:</strong><br>
                        ${{ number_format((float) ($prestamo->multa_diaria ?? 0), 2) }}
                    </div>

                    <div>
                        <strong>Multa acumulada:</strong><br>
                        ${{ number_format((float) ($prestamo->multa_acumulada ?? 0), 2) }}
                    </div>

                    <div>
                        <strong>Entregado por:</strong><br>
                        {{ $prestamo->usuarioEntrega?->nombre_completo ?? 'Pendiente' }}
                    </div>

                    <div>
                        <strong>Recibido por:</strong><br>
                        {{ $prestamo->usuarioRecibe?->nombre_completo ?? 'Pendiente' }}
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>