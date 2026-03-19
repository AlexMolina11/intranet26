@extends('layouts.app')

@section('title', 'Solicitud de ticket')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Solicitud de ticket</h1>
                <p class="page-subtitle">Registrar nueva solicitud</p>
            </div>
            <div class="page-header-actions">
                <a href="{{ route('tik.tickets.index') }}" class="btn btn-secondary">Volver</a>
            </div>
        </div>

        @if ($errors->has('general'))
            <div class="alert alert-danger" style="margin-top:16px;">
                {{ $errors->first('general') }}
            </div>
        @endif

        <form method="POST" action="{{ route('tik.tickets.store') }}" style="margin-top:20px;">
            @csrf

            <div class="form-group">
                <label class="form-label" for="frmTicket_slcTipo">Tipo de ticket</label>
                <select name="frmTicket_slcTipo" id="frmTicket_slcTipo" class="form-control" required>
                    <option value="">Seleccione</option>
                    @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id_tipo_ticket }}" {{ old('frmTicket_slcTipo') == $tipo->id_tipo_ticket ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('frmTicket_slcTipo')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group" id="bloqueRrhh" style="display:none; margin-top:16px;">
                <label class="form-label" for="frmTicket_slcTipoSolicitud">Tipo de solicitud RRHH</label>
                <select name="frmTicket_slcTipoSolicitud" id="frmTicket_slcTipoSolicitud" class="form-control">
                    <option value="">Seleccione</option>
                    @foreach ($tiposRrhh as $subtipo)
                        <option
                            value="{{ $subtipo->id_tipo_ticket_rrhh }}"
                            data-tipo="{{ $subtipo->id_tipo_ticket }}"
                            {{ old('frmTicket_slcTipoSolicitud') == $subtipo->id_tipo_ticket_rrhh ? 'selected' : '' }}
                        >
                            {{ $subtipo->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('frmTicket_slcTipoSolicitud')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group" style="margin-top:16px;">
                <label class="form-label" for="frmTicket_txaAsunto">Asunto</label>
                <input type="text" name="frmTicket_txaAsunto" id="frmTicket_txaAsunto" class="form-control" value="{{ old('frmTicket_txaAsunto') }}" maxlength="180" required>
                @error('frmTicket_txaAsunto')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group" style="margin-top:16px;">
                <label class="form-label" for="frmTicket_txaDescripcion">Descripción</label>
                <textarea name="frmTicket_txaDescripcion" id="frmTicket_txaDescripcion" rows="6" class="form-control" required>{{ old('frmTicket_txaDescripcion') }}</textarea>
                @error('frmTicket_txaDescripcion')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div id="bloqueComunicaciones" style="display:none;">
                <div class="form-group" style="margin-top:16px;">
                    <label class="form-label" for="frmTicket_FechaEntrega">Fecha requerida</label>
                    <input type="date" name="frmTicket_FechaEntrega" id="frmTicket_FechaEntrega" class="form-control" value="{{ old('frmTicket_FechaEntrega') }}">
                    @error('frmTicket_FechaEntrega')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group" style="margin-top:16px;">
                    <label class="form-label" for="frmTicket_slcFormato">Formato</label>
                    <select name="frmTicket_slcFormato" id="frmTicket_slcFormato" class="form-control">
                        <option value="">Seleccione</option>
                        @foreach ($formatos as $formato)
                            <option value="{{ $formato->id_formato_ticket }}" {{ old('frmTicket_slcFormato') == $formato->id_formato_ticket ? 'selected' : '' }}>
                                {{ $formato->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('frmTicket_slcFormato')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:20px;">
                <button type="submit" class="btn btn-primary">Registrar ticket</button>
                <a href="{{ route('tik.tickets.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tipoSelect = document.getElementById('frmTicket_slcTipo');
            const rrhhBlock = document.getElementById('bloqueRrhh');
            const rrhhSelect = document.getElementById('frmTicket_slcTipoSolicitud');
            const comunicacionesBlock = document.getElementById('bloqueComunicaciones');
            const formatoSelect = document.getElementById('frmTicket_slcFormato');
            const fechaEntregaInput = document.getElementById('frmTicket_FechaEntrega');

            const tipoTalentoHumanoId = @json($tipoTalentoHumanoId);
            const tipoComunicacionesId = @json($tipoComunicacionesId);

            function actualizarFormulario() {
                const selected = tipoSelect.value;

                Array.from(rrhhSelect.options).forEach(option => {
                    if (!option.value) {
                        option.hidden = false;
                        return;
                    }

                    option.hidden = option.dataset.tipo !== selected;
                });

                if (String(selected) === String(tipoTalentoHumanoId)) {
                    rrhhBlock.style.display = 'block';
                } else {
                    rrhhBlock.style.display = 'none';
                    rrhhSelect.value = '';
                }

                if (String(selected) === String(tipoComunicacionesId)) {
                    comunicacionesBlock.style.display = 'block';
                } else {
                    comunicacionesBlock.style.display = 'none';
                    formatoSelect.value = '';
                    fechaEntregaInput.value = '';
                }
            }

            tipoSelect.addEventListener('change', actualizarFormulario);
            actualizarFormulario();
        });
    </script>
@endsection