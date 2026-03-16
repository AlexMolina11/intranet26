@extends('layouts.app')

@section('title', 'Asignación organizacional')

@section('content')
    <div class="card">
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="margin:0;">Asignación organizacional</h1>
                <p class="page-subtitle">
                    Usuario: <strong>{{ $usuario->nombre_completo }}</strong>
                </p>
                <p class="page-subtitle">
                    Correo: {{ $usuario->correo }}
                </p>
            </div>

            <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Volver</a>
        </div>

        <form method="POST" action="{{ route('org.usuarios.organizacion.update', $usuario) }}">
            @csrf
            @method('PUT')

            <div class="card-section">
                <h3 style="margin-top:0;">Área principal</h3>

                <div class="form-group">
                    <label class="form-label" for="principal_id_departamento">Departamento</label>
                    <select name="principal_id_departamento" id="principal_id_departamento" class="form-control">
                        <option value="">-- Seleccione departamento --</option>
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento }}"
                                {{ (string) old('principal_id_departamento', $principal['id_departamento'] ?? '') === (string) $departamento->id_departamento ? 'selected' : '' }}>
                                {{ $departamento->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="principal_id_proyecto">Proyecto</label>
                    <select name="principal_id_proyecto" id="principal_id_proyecto" class="form-control">
                        <option value="">-- Seleccione proyecto --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Área resuelta automáticamente</label>
                    <input type="text" id="principal_nombre_area" class="form-control" value="" readonly>
                    <input type="hidden" name="principal_id_area" id="principal_id_area" value="{{ old('principal_id_area', $principal['id_area'] ?? '') }}">
                    @error('principal_id_area')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="card-section">
                <div class="page-header" style="margin-bottom:16px;">
                    <h3 style="margin:0;">Áreas secundarias</h3>
                    <button type="button" class="btn btn-secondary" id="btnAgregarSecundaria">Agregar secundaria</button>
                </div>

                @error('secundarias')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div id="contenedorSecundarias"></div>
            </div>

            <div class="stack-mobile" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">Guardar asignación</button>
                <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <template id="template-secundaria">
        <div class="secundaria-item card-section">
            <div class="page-header" style="margin-bottom:12px;">
                <strong>Área secundaria</strong>
                <button type="button" class="btn btn-danger btn-eliminar-secundaria">Quitar</button>
            </div>

            <div class="form-group">
                <label class="form-label">Departamento</label>
                <select class="form-control secundaria-departamento"></select>
            </div>

            <div class="form-group">
                <label class="form-label">Proyecto</label>
                <select class="form-control secundaria-proyecto"></select>
            </div>

            <div class="form-group">
                <label class="form-label">Área resuelta automáticamente</label>
                <input type="text" class="form-control secundaria-nombre-area" readonly>
                <input type="hidden" class="secundaria-id-area">
            </div>
        </div>
    </template>

    <script>
        const departamentosBase = @json($departamentos->map(fn($d) => ['id' => $d->id_departamento, 'nombre' => $d->nombre])->values());
        const proyectosBase = @json($proyectos->map(fn($p) => ['id' => $p->id_proyecto, 'nombre' => $p->nombre])->values());

        const principalInicial = {
            id_departamento: @json(old('principal_id_departamento', $principal['id_departamento'] ?? '')),
            id_proyecto: @json(old('principal_id_proyecto', $principal['id_proyecto'] ?? '')),
            id_area: @json(old('principal_id_area', $principal['id_area'] ?? '')),
            nombre_area: @json($principal['nombre_area'] ?? '')
        };

        const secundariasIniciales = @json(old('secundarias', $secundarias));

        function llenarSelect(select, items, selectedValue = '', placeholder = '-- Seleccione --', valueKey = 'id', textKey = 'nombre') {
            select.innerHTML = '';
            const optionDefault = document.createElement('option');
            optionDefault.value = '';
            optionDefault.textContent = placeholder;
            select.appendChild(optionDefault);

            items.forEach(item => {
                const option = document.createElement('option');
                option.value = item[valueKey];
                option.textContent = item[textKey];
                if (String(selectedValue) === String(item[valueKey])) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
        }

        async function fetchJson(url) {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            return await response.json();
        }

        async function cargarProyectosPorDepartamento(selectProyecto, idDepartamento, selectedProyecto = '') {
            llenarSelect(selectProyecto, [], '', '-- Seleccione proyecto --');

            if (!idDepartamento) {
                return;
            }

            const url = `{{ route('org.proyectos.por-departamento') }}?id_departamento=${idDepartamento}`;
            const proyectos = await fetchJson(url);

            llenarSelect(selectProyecto, proyectos, selectedProyecto, '-- Seleccione proyecto --', 'id_proyecto', 'nombre');
        }

        async function resolverArea(idDepartamento, idProyecto) {
            if (!idDepartamento || !idProyecto) {
                return null;
            }

            const url = `{{ route('org.areas.resolver') }}?id_departamento=${idDepartamento}&id_proyecto=${idProyecto}`;
            return await fetchJson(url);
        }

        async function inicializarPrincipal() {
            const dep = document.getElementById('principal_id_departamento');
            const proy = document.getElementById('principal_id_proyecto');
            const hiddenArea = document.getElementById('principal_id_area');
            const nombreArea = document.getElementById('principal_nombre_area');

            if (principalInicial.id_departamento) {
                await cargarProyectosPorDepartamento(proy, principalInicial.id_departamento, principalInicial.id_proyecto);
            }

            async function actualizarPrincipal() {
                const area = await resolverArea(dep.value, proy.value);

                if (area && area.id_area) {
                    hiddenArea.value = area.id_area;
                    nombreArea.value = area.nombre;
                } else {
                    hiddenArea.value = '';
                    nombreArea.value = '';
                }
            }

            dep.addEventListener('change', async function () {
                await cargarProyectosPorDepartamento(proy, dep.value, '');
                await actualizarPrincipal();
            });

            proy.addEventListener('change', async function () {
                await actualizarPrincipal();
            });

            await actualizarPrincipal();

            if (!nombreArea.value && principalInicial.nombre_area) {
                nombreArea.value = principalInicial.nombre_area;
            }
        }

        async function agregarSecundaria(valores = {}) {
            const index = document.querySelectorAll('.secundaria-item').length;
            const template = document.getElementById('template-secundaria');
            const clon = template.content.cloneNode(true);

            const item = clon.querySelector('.secundaria-item');
            const selectDepartamento = clon.querySelector('.secundaria-departamento');
            const selectProyecto = clon.querySelector('.secundaria-proyecto');
            const inputNombreArea = clon.querySelector('.secundaria-nombre-area');
            const inputIdArea = clon.querySelector('.secundaria-id-area');
            const btnEliminar = clon.querySelector('.btn-eliminar-secundaria');

            selectDepartamento.name = `secundarias[${index}][id_departamento]`;
            selectProyecto.name = `secundarias[${index}][id_proyecto]`;
            inputIdArea.name = `secundarias[${index}][id_area]`;

            llenarSelect(selectDepartamento, departamentosBase, valores.id_departamento || '', '-- Seleccione departamento --');

            if (valores.id_departamento) {
                await cargarProyectosPorDepartamento(selectProyecto, valores.id_departamento, valores.id_proyecto || '');
            } else {
                llenarSelect(selectProyecto, [], '', '-- Seleccione proyecto --');
            }

            async function actualizarAreaSecundaria() {
                const area = await resolverArea(selectDepartamento.value, selectProyecto.value);

                if (area && area.id_area) {
                    inputIdArea.value = area.id_area;
                    inputNombreArea.value = area.nombre;
                } else {
                    inputIdArea.value = '';
                    inputNombreArea.value = '';
                }
            }

            selectDepartamento.addEventListener('change', async function () {
                await cargarProyectosPorDepartamento(selectProyecto, selectDepartamento.value, '');
                await actualizarAreaSecundaria();
            });

            selectProyecto.addEventListener('change', async function () {
                await actualizarAreaSecundaria();
            });

            btnEliminar.addEventListener('click', function () {
                item.remove();
                reindexarSecundarias();
            });

            document.getElementById('contenedorSecundarias').appendChild(clon);

            await actualizarAreaSecundaria();

            if (!inputNombreArea.value && valores.nombre_area) {
                inputNombreArea.value = valores.nombre_area;
            }
        }

        function reindexarSecundarias() {
            const items = document.querySelectorAll('.secundaria-item');

            items.forEach((item, index) => {
                const selectDepartamento = item.querySelector('.secundaria-departamento');
                const selectProyecto = item.querySelector('.secundaria-proyecto');
                const inputIdArea = item.querySelector('.secundaria-id-area');

                selectDepartamento.name = `secundarias[${index}][id_departamento]`;
                selectProyecto.name = `secundarias[${index}][id_proyecto]`;
                inputIdArea.name = `secundarias[${index}][id_area]`;
            });
        }

        document.getElementById('btnAgregarSecundaria').addEventListener('click', function () {
            agregarSecundaria();
        });

        inicializarPrincipal();

        if (secundariasIniciales.length) {
            secundariasIniciales.forEach(sec => agregarSecundaria(sec));
        }
    </script>
@endsection