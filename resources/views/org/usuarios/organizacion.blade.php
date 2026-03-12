@extends('layouts.app')

@section('title', 'Asignación organizacional')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:20px;">
            <div>
                <h1 style="margin:0;">Asignación organizacional</h1>
                <p style="margin:6px 0 0 0; color:#64748b;">
                    Usuario: <strong>{{ $usuario->nombre_completo }}</strong>
                </p>
                <p style="margin:6px 0 0 0; color:#64748b;">
                    Correo: {{ $usuario->correo }}
                </p>
            </div>

            <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Volver</a>
        </div>

        <form method="POST" action="{{ route('org.usuarios.organizacion.update', $usuario) }}">
            @csrf
            @method('PUT')

            <div style="border:1px solid #e5e7eb; border-radius:8px; padding:16px; margin-bottom:24px;">
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
                        @foreach ($proyectos as $proyecto)
                            <option value="{{ $proyecto->id_proyecto }}"
                                {{ (string) old('principal_id_proyecto', $principal['id_proyecto'] ?? '') === (string) $proyecto->id_proyecto ? 'selected' : '' }}>
                                {{ $proyecto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="principal_id_area">Área</label>
                    <select name="principal_id_area" id="principal_id_area" class="form-control">
                        <option value="">-- Seleccione área --</option>
                    </select>
                    @error('principal_id_area')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div style="border:1px solid #e5e7eb; border-radius:8px; padding:16px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                    <h3 style="margin:0;">Áreas secundarias</h3>
                    <button type="button" class="btn btn-secondary" id="btnAgregarSecundaria">Agregar secundaria</button>
                </div>

                @error('secundarias')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div id="contenedorSecundarias"></div>
            </div>

            <div style="margin-top:20px; display:flex; gap:8px;">
                <button type="submit" class="btn btn-primary">Guardar asignación</button>
                <a href="{{ route('seg.usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <template id="template-secundaria">
        <div class="secundaria-item" style="border:1px solid #e5e7eb; border-radius:8px; padding:16px; margin-bottom:16px;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
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
                <label class="form-label">Área</label>
                <select class="form-control secundaria-area"></select>
            </div>
        </div>
    </template>

    <script>
        const departamentos = @json($departamentos->map(fn($d) => ['id' => $d->id_departamento, 'nombre' => $d->nombre])->values());
        const proyectos = @json($proyectos->map(fn($p) => ['id' => $p->id_proyecto, 'nombre' => $p->nombre])->values());

        const principalInicial = {
            id_departamento: @json(old('principal_id_departamento', $principal['id_departamento'] ?? '')),
            id_proyecto: @json(old('principal_id_proyecto', $principal['id_proyecto'] ?? '')),
            id_area: @json(old('principal_id_area', $principal['id_area'] ?? ''))
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

        async function cargarAreas(selectArea, idDepartamento, idProyecto, selectedArea = '') {
            llenarSelect(selectArea, [], '', '-- Seleccione área --');

            if (!idDepartamento || !idProyecto) {
                return;
            }

            const url = `{{ route('org.areas.por-filtro') }}?id_departamento=${idDepartamento}&id_proyecto=${idProyecto}`;
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const areas = await response.json();
            llenarSelect(selectArea, areas, selectedArea, '-- Seleccione área --', 'id_area', 'nombre');
        }

        async function inicializarPrincipal() {
            const dep = document.getElementById('principal_id_departamento');
            const proy = document.getElementById('principal_id_proyecto');
            const area = document.getElementById('principal_id_area');

            await cargarAreas(area, dep.value, proy.value, principalInicial.id_area);

            dep.addEventListener('change', async function () {
                await cargarAreas(area, dep.value, proy.value, '');
            });

            proy.addEventListener('change', async function () {
                await cargarAreas(area, dep.value, proy.value, '');
            });
        }

        async function agregarSecundaria(valores = {}) {
            const index = document.querySelectorAll('.secundaria-item').length;
            const template = document.getElementById('template-secundaria');
            const clon = template.content.cloneNode(true);

            const item = clon.querySelector('.secundaria-item');
            const selectDepartamento = clon.querySelector('.secundaria-departamento');
            const selectProyecto = clon.querySelector('.secundaria-proyecto');
            const selectArea = clon.querySelector('.secundaria-area');
            const btnEliminar = clon.querySelector('.btn-eliminar-secundaria');

            selectDepartamento.name = `secundarias[${index}][id_departamento]`;
            selectProyecto.name = `secundarias[${index}][id_proyecto]`;
            selectArea.name = `secundarias[${index}][id_area]`;

            llenarSelect(selectDepartamento, departamentos, valores.id_departamento || '', '-- Seleccione departamento --');
            llenarSelect(selectProyecto, proyectos, valores.id_proyecto || '', '-- Seleccione proyecto --');
            await cargarAreas(selectArea, valores.id_departamento || '', valores.id_proyecto || '', valores.id_area || '');

            selectDepartamento.addEventListener('change', async function () {
                await cargarAreas(selectArea, selectDepartamento.value, selectProyecto.value, '');
            });

            selectProyecto.addEventListener('change', async function () {
                await cargarAreas(selectArea, selectDepartamento.value, selectProyecto.value, '');
            });

            btnEliminar.addEventListener('click', function () {
                item.remove();
                reindexarSecundarias();
            });

            document.getElementById('contenedorSecundarias').appendChild(clon);
        }

        function reindexarSecundarias() {
            const items = document.querySelectorAll('.secundaria-item');

            items.forEach((item, index) => {
                const selects = item.querySelectorAll('select');
                selects[0].name = `secundarias[${index}][id_departamento]`;
                selects[1].name = `secundarias[${index}][id_proyecto]`;
                selects[2].name = `secundarias[${index}][id_area]`;
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