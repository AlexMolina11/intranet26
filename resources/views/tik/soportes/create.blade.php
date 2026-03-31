@extends('layouts.app')

@section('title', 'Nuevo soporte')

@section('content')
    @php
        $ticketId = old('id_ticket', $ticket?->id_ticket);
        $defaultTipo = old('tipo_registro', $ticket ? ($ticket->es_proyecto ? 'AVANCE' : 'TICKET') : 'EXTERNO');
        $departamentoInicial = old('id_departamento', $ticket?->areaResponsable?->id_departamento);
    @endphp

    <style>
        .support-wrap {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .support-hero {
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            background: #ffffff;
            padding: 24px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }

        .support-title {
            margin: 0;
            font-size: 28px;
            line-height: 1.2;
            color: #111827;
        }

        .support-subtitle {
            margin: 8px 0 0;
            color: #6b7280;
            font-size: 14px;
        }

        .support-grid {
            display: grid;
            grid-template-columns: minmax(320px, 1fr) minmax(420px, 1.3fr);
            gap: 20px;
        }

        .support-card {
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            background: #ffffff;
            padding: 22px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        }

        .support-card h2,
        .support-card h3 {
            margin-top: 0;
            margin-bottom: 14px;
            color: #111827;
        }

        .support-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .support-form-grid .full {
            grid-column: 1 / -1;
        }

        .support-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 18px;
        }

        .service-type-block {
            margin-bottom: 18px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            background: #fff;
        }

        .service-type-header {
            background: #f8fafc;
            padding: 12px 14px;
            font-weight: 700;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 14px;
        }

        .service-check {
            border: 1px solid #dbe3ea;
            border-radius: 12px;
            background: #f8fafc;
            padding: 12px;
            cursor: pointer;
            transition: .2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 56px;
        }

        .service-check:hover {
            border-color: #94a3b8;
            background: #f1f5f9;
        }

        .service-check.active {
            border-color: #385506;
            background: rgba(160, 197, 37, 0.12);
        }

        .service-check input {
            margin: 0;
        }

        .support-empty {
            padding: 14px 16px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            color: #475569;
        }

        .support-selected-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 16px;
        }

        .support-selected-item {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #f8fafc;
            padding: 12px 14px;
        }

        .support-selected-title {
            font-weight: 700;
            color: #111827;
            margin-bottom: 4px;
        }

        .support-selected-meta {
            color: #475569;
            font-size: 14px;
        }

        .support-info-banner {
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            color: #1e3a8a;
            border-radius: 14px;
            padding: 14px 16px;
        }

        .support-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 20px;
        }

        .support-modal-backdrop.open {
            display: flex;
        }

        .support-modal {
            width: 100%;
            max-width: 760px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.3);
            overflow: hidden;
        }

        .support-modal-header {
            padding: 18px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
        }

        .support-modal-body {
            padding: 20px;
        }

        .incidence-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .incidence-option {
            border: 1px solid #dbe3ea;
            border-radius: 12px;
            background: #f8fafc;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            transition: .2s ease;
        }

        .incidence-option:hover {
            border-color: #94a3b8;
            background: #f1f5f9;
        }

        @media (max-width: 1100px) {
            .support-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .support-form-grid,
            .service-grid,
            .incidence-grid {
                grid-template-columns: 1fr;
            }

            .support-title {
                font-size: 22px;
            }
        }
    </style>

    <div class="support-wrap">
        <div class="support-hero">
            <h1 class="support-title">Registrar soporte o avance</h1>
            <p class="support-subtitle">
                Completa la información general y luego selecciona uno o varios servicios.
                A cada servicio se le asociará una incidencia.
            </p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="margin: 0;">
                <ul style="margin: 0; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($ticket)
            <div class="support-info-banner">
                Estás registrando soporte para el ticket <strong>{{ $ticket->codigo }}</strong> — {{ $ticket->asunto }}
            </div>
        @endif

        <form method="POST" action="{{ route('tik.soportes.store') }}" id="frmSoporte">
            @csrf

            <input type="hidden" name="id_ticket" value="{{ $ticketId }}">
            <input type="hidden" name="selecciones" id="frmSoporte_hddSelecciones" value="{{ old('selecciones') }}">

            <div class="support-grid">
                <section class="support-card">
                    <h2>Información del soporte</h2>

                    <div class="support-form-grid">
                        <div>
                            <label class="form-label" for="tipo_registro">Tipo de registro</label>
                            <select name="tipo_registro" id="tipo_registro" class="form-control" required>
                                <option value="">Seleccione</option>
                                <option value="TICKET" {{ $defaultTipo === 'TICKET' ? 'selected' : '' }}>TICKET</option>
                                <option value="AVANCE" {{ $defaultTipo === 'AVANCE' ? 'selected' : '' }}>AVANCE</option>
                                <option value="EXTERNO" {{ $defaultTipo === 'EXTERNO' ? 'selected' : '' }}>EXTERNO</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label" for="id_ticket_visible">Ticket</label>
                            <input type="text"
                                   id="id_ticket_visible"
                                   class="form-control"
                                   value="{{ $ticket?->codigo ?? old('id_ticket') }}"
                                   placeholder="Opcional"
                                   {{ $ticket ? 'readonly' : '' }}>
                        </div>

                        <div>
                            <label class="form-label" for="fecha_inicio">Fecha inicio</label>
                            <input type="datetime-local"
                                   name="fecha_inicio"
                                   id="fecha_inicio"
                                   class="form-control"
                                   value="{{ old('fecha_inicio', now()->format('Y-m-d\TH:i')) }}">
                        </div>

                        <div>
                            <label class="form-label" for="fecha_fin">Fecha fin</label>
                            <input type="datetime-local"
                                   name="fecha_fin"
                                   id="fecha_fin"
                                   class="form-control"
                                   value="{{ old('fecha_fin', now()->format('Y-m-d\TH:i')) }}">
                        </div>

                        <div>
                            <label class="form-label" for="id_departamento">Departamento</label>
                            <select name="id_departamento" id="id_departamento" class="form-control" required {{ $ticket ? 'disabled' : '' }}>
                                <option value="">Seleccione</option>
                                @foreach ($departamentos as $departamento)
                                    <option value="{{ $departamento->id_departamento }}"
                                        {{ (string) old('id_departamento', $ticket?->areaResponsable?->id_departamento) === (string) $departamento->id_departamento ? 'selected' : '' }}>
                                        {{ $departamento->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($ticket && $ticket->areaResponsable?->id_departamento)
                                <input type="hidden" name="id_departamento" value="{{ $ticket->areaResponsable->id_departamento }}">
                            @endif
                        </div>

                        <div>
                            <label class="form-label" for="id_proyecto">Proyecto</label>
                            <select name="id_proyecto" id="id_proyecto" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id_proyecto }}" {{ old('id_proyecto') == $proyecto->id_proyecto ? 'selected' : '' }}>
                                        {{ $proyecto->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="form-label" for="id_usuario_solicitante">Solicitante</label>
                            <select name="id_usuario_solicitante" id="id_usuario_solicitante" class="form-control" required {{ $ticket ? 'disabled' : '' }}>
                                <option value="">Seleccione</option>
                                @foreach ($solicitantes as $solicitante)
                                    <option value="{{ $solicitante->id_usuario }}"
                                        {{ (string) old('id_usuario_solicitante', $ticket?->id_usuario_solicitante) === (string) $solicitante->id_usuario ? 'selected' : '' }}>
                                        {{ trim(($solicitante->nombres ?? '') . ' ' . ($solicitante->apellidos ?? '')) }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($ticket)
                                <input type="hidden" name="id_usuario_solicitante" value="{{ $ticket->id_usuario_solicitante }}">
                            @endif
                        </div>

                        <div class="full">
                            <label class="form-label" for="asunto">Asunto</label>
                            <input type="text"
                                   name="asunto"
                                   id="asunto"
                                   class="form-control"
                                   value="{{ old('asunto', $ticket ? 'Soporte de ' . $ticket->codigo . ' - ' . $ticket->asunto : '') }}"
                                   required>
                        </div>

                        <div class="full">
                            <label class="form-label" for="descripcion">Observación / descripción</label>
                            <textarea name="descripcion"
                                      id="descripcion"
                                      rows="6"
                                      class="form-control"
                                      required>{{ old('descripcion') }}</textarea>
                        </div>
                    </div>

                    <div class="support-selected-list" id="support-selected-list">
                        <div class="support-empty">
                            Aún no has seleccionado servicios.
                        </div>
                    </div>

                    <div class="support-actions">
                        <button type="submit" class="btn btn-primary">Guardar soporte</button>
                        <a href="{{ route('tik.soportes.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </section>

                <section class="support-card">
                    <h2>Servicios del soporte</h2>
                    <p class="text-muted" style="margin-top: 0; margin-bottom: 16px;">
                        Selecciona uno o varios servicios. Al marcar uno, deberás elegir su incidencia.
                    </p>

                    <div id="service-types-container">
                        <div class="support-empty">
                            Selecciona un departamento para cargar los servicios disponibles.
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>

    <div class="support-modal-backdrop" id="incidenceModalBackdrop">
        <div class="support-modal">
            <div class="support-modal-header">
                <div>
                    <strong>Seleccionar incidencia</strong>
                    <div class="text-muted" id="incidenceModalServiceName" style="font-size: 14px;"></div>
                </div>

                <button type="button" class="btn btn-secondary btn-sm" id="btnCloseIncidenceModal">Cerrar</button>
            </div>

            <div class="support-modal-body">
                <div class="incidence-grid" id="incidenceGrid"></div>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const departmentSelect = document.getElementById('id_departamento');
            const hiddenSelections = document.getElementById('frmSoporte_hddSelecciones');
            const supportSelectedList = document.getElementById('support-selected-list');
            const serviceTypesContainer = document.getElementById('service-types-container');

            const modalBackdrop = document.getElementById('incidenceModalBackdrop');
            const incidenceGrid = document.getElementById('incidenceGrid');
            const incidenceModalServiceName = document.getElementById('incidenceModalServiceName');
            const btnCloseIncidenceModal = document.getElementById('btnCloseIncidenceModal');

            const incidenciasUsuarioUrl = @json(route('tik.catalogos.incidencias.usuario'));
            const tiposServicioUsuarioUrl = @json(route('tik.catalogos.tipos-servicio.usuario'));
            const serviciosPorTipoBaseUrl = @json(url('/tik/catalogos/tipos-servicio'));

            const departamentoInicial = @json((string) $departamentoInicial);

            let incidencias = [];
            let tiposServicio = [];
            let currentServiceId = null;
            let currentServiceName = null;
            const selections = {};

            function getDepartmentId() {
                return departmentSelect ? String(departmentSelect.value || '') : '';
            }

            async function fetchJson(url) {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error('No fue posible cargar el catálogo.');
                }

                return await response.json();
            }

            async function cargarCatalogosBase() {
                incidencias = await fetchJson(incidenciasUsuarioUrl);
                tiposServicio = await fetchJson(tiposServicioUsuarioUrl);
            }

            function filtrarIncidenciasPorDepartamento() {
                const deptoId = getDepartmentId();

                if (!deptoId) {
                    return [];
                }

                return incidencias.filter(item => String(item.id_departamento) === deptoId);
            }

            async function renderTiposServicio() {
                const deptoId = getDepartmentId();

                if (!deptoId) {
                    serviceTypesContainer.innerHTML = `
                        <div class="support-empty">
                            Selecciona un departamento para cargar los servicios disponibles.
                        </div>
                    `;
                    return;
                }

                const tiposFiltrados = tiposServicio.filter(item => String(item.id_departamento) === deptoId);

                if (!tiposFiltrados.length) {
                    serviceTypesContainer.innerHTML = `
                        <div class="support-empty">
                            No hay tipos de servicio disponibles para el departamento seleccionado.
                        </div>
                    `;
                    return;
                }

                serviceTypesContainer.innerHTML = `<div class="support-empty">Cargando servicios...</div>`;

                const bloques = [];

                for (const tipo of tiposFiltrados) {
                    const servicios = await fetchJson(`${serviciosPorTipoBaseUrl}/${tipo.codigo}/servicios`);

                    const serviciosHtml = servicios.length
                        ? `
                            <div class="service-grid">
                                ${servicios.map(servicio => `
                                    <label class="service-check ${selections[String(servicio.id_servicio)] ? 'active' : ''}"
                                           data-service-id="${servicio.id_servicio}"
                                           data-service-name="${servicio.nombre}">
                                        <input type="checkbox"
                                               class="service-selector"
                                               value="${servicio.id_servicio}"
                                               ${selections[String(servicio.id_servicio)] ? 'checked' : ''}>
                                        <span>${servicio.nombre}</span>
                                    </label>
                                `).join('')}
                            </div>
                        `
                        : `
                            <div class="support-empty" style="margin: 14px;">
                                No hay servicios configurados para este tipo.
                            </div>
                        `;

                    bloques.push(`
                        <div class="service-type-block">
                            <div class="service-type-header">${tipo.nombre}</div>
                            ${serviciosHtml}
                        </div>
                    `);
                }

                serviceTypesContainer.innerHTML = bloques.join('');

                bindServiceChecks();
            }

            function openIncidenceModal(serviceId, serviceName) {
                const filtered = filtrarIncidenciasPorDepartamento();

                if (!filtered.length) {
                    alert('No hay incidencias disponibles para el departamento seleccionado.');
                    const checkbox = document.querySelector(`.service-selector[value="${serviceId}"]`);
                    if (checkbox) {
                        checkbox.checked = false;
                        checkbox.closest('.service-check')?.classList.remove('active');
                    }
                    return;
                }

                currentServiceId = String(serviceId);
                currentServiceName = serviceName;
                incidenceModalServiceName.textContent = serviceName;

                incidenceGrid.innerHTML = '';

                filtered.forEach(item => {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'incidence-option';
                    button.textContent = item.nombre;

                    button.addEventListener('click', () => {
                        selections[currentServiceId] = {
                            servicio_id: Number(currentServiceId),
                            servicio_nombre: currentServiceName,
                            incidencia_id: item.id_incidencia,
                            incidencia_nombre: item.nombre,
                        };

                        syncHiddenSelections();
                        renderSelections();
                        closeIncidenceModal();
                    });

                    incidenceGrid.appendChild(button);
                });

                modalBackdrop.classList.add('open');
            }

            function closeIncidenceModal() {
                modalBackdrop.classList.remove('open');
                currentServiceId = null;
                currentServiceName = null;
            }

            function syncHiddenSelections() {
                hiddenSelections.value = JSON.stringify(Object.values(selections));
            }

            function renderSelections() {
                const items = Object.values(selections);

                if (!items.length) {
                    supportSelectedList.innerHTML = `
                        <div class="support-empty">
                            Aún no has seleccionado servicios.
                        </div>
                    `;
                    return;
                }

                supportSelectedList.innerHTML = items.map(item => `
                    <div class="support-selected-item">
                        <div class="support-selected-title">${item.servicio_nombre}</div>
                        <div class="support-selected-meta">Incidencia: ${item.incidencia_nombre}</div>
                    </div>
                `).join('');
            }

            function bindServiceChecks() {
                const serviceChecks = document.querySelectorAll('.service-selector');

                serviceChecks.forEach(check => {
                    check.addEventListener('change', function () {
                        const wrapper = this.closest('.service-check');
                        const serviceId = this.value;
                        const serviceName = wrapper?.dataset.serviceName ?? 'Servicio';

                        if (this.checked) {
                            wrapper?.classList.add('active');
                            openIncidenceModal(serviceId, serviceName);
                        } else {
                            wrapper?.classList.remove('active');
                            delete selections[String(serviceId)];
                            syncHiddenSelections();
                            renderSelections();
                        }
                    });
                });
            }

            function resetSelections() {
                Object.keys(selections).forEach(key => delete selections[key]);
                syncHiddenSelections();
                renderSelections();
            }

            if (departmentSelect) {
                departmentSelect.addEventListener('change', async () => {
                    resetSelections();
                    await renderTiposServicio();
                });
            }

            btnCloseIncidenceModal?.addEventListener('click', () => {
                if (currentServiceId && !selections[currentServiceId]) {
                    const checkbox = document.querySelector(`.service-selector[value="${currentServiceId}"]`);
                    if (checkbox) {
                        checkbox.checked = false;
                        checkbox.closest('.service-check')?.classList.remove('active');
                    }
                }
                closeIncidenceModal();
            });

            modalBackdrop?.addEventListener('click', (e) => {
                if (e.target === modalBackdrop) {
                    if (currentServiceId && !selections[currentServiceId]) {
                        const checkbox = document.querySelector(`.service-selector[value="${currentServiceId}"]`);
                        if (checkbox) {
                            checkbox.checked = false;
                            checkbox.closest('.service-check')?.classList.remove('active');
                        }
                    }
                    closeIncidenceModal();
                }
            });

            (async () => {
                try {
                    await cargarCatalogosBase();

                    if (departmentSelect && departamentoInicial) {
                        departmentSelect.value = departamentoInicial;
                    }

                    await renderTiposServicio();
                    renderSelections();
                } catch (error) {
                    serviceTypesContainer.innerHTML = `
                        <div class="support-empty">
                            Ocurrió un problema al cargar los catálogos de soporte.
                        </div>
                    `;
                }
            })();
        })();
    </script>
@endsection