<div class="form-grid form-grid-3">
    <div class="form-group">
        <label class="form-label" for="codigo">Código</label>
        <input
            type="text"
            name="codigo"
            id="codigo"
            class="form-control @error('codigo') is-invalid @enderror"
            value="{{ old('codigo', $recurso->codigo ?? '') }}"
            maxlength="50"
            required>
        @error('codigo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="anio_publicacion">Año de publicación</label>
        <input
            type="number"
            name="anio_publicacion"
            id="anio_publicacion"
            class="form-control @error('anio_publicacion') is-invalid @enderror"
            value="{{ old('anio_publicacion', $recurso->anio_publicacion ?? '') }}"
            min="1000"
            max="9999">
        @error('anio_publicacion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="orden">Orden</label>
        <input
            type="number"
            name="orden"
            id="orden"
            class="form-control @error('orden') is-invalid @enderror"
            value="{{ old('orden', $recurso->orden ?? 1) }}"
            min="1"
            required>
        @error('orden')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid form-grid-2">
    <div class="form-group">
        <label class="form-label" for="titulo">Título</label>
        <input
            type="text"
            name="titulo"
            id="titulo"
            class="form-control @error('titulo') is-invalid @enderror"
            value="{{ old('titulo', $recurso->titulo ?? '') }}"
            maxlength="255"
            required>
        @error('titulo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="subtitulo">Subtítulo</label>
        <input
            type="text"
            name="subtitulo"
            id="subtitulo"
            class="form-control @error('subtitulo') is-invalid @enderror"
            value="{{ old('subtitulo', $recurso->subtitulo ?? '') }}"
            maxlength="255">
        @error('subtitulo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid form-grid-3">
    <div class="form-group">
        <label class="form-label" for="isbn">ISBN</label>
        <input
            type="text"
            name="isbn"
            id="isbn"
            class="form-control @error('isbn') is-invalid @enderror"
            value="{{ old('isbn', $recurso->isbn ?? '') }}"
            maxlength="30">
        @error('isbn')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="issn">ISSN</label>
        <input
            type="text"
            name="issn"
            id="issn"
            class="form-control @error('issn') is-invalid @enderror"
            value="{{ old('issn', $recurso->issn ?? '') }}"
            maxlength="30">
        @error('issn')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="numero_paginas">Número de páginas</label>
        <input
            type="number"
            name="numero_paginas"
            id="numero_paginas"
            class="form-control @error('numero_paginas') is-invalid @enderror"
            value="{{ old('numero_paginas', $recurso->numero_paginas ?? '') }}"
            min="1">
        @error('numero_paginas')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid form-grid-3">
    <div class="form-group">
        <label class="form-label" for="edicion">Edición</label>
        <input
            type="text"
            name="edicion"
            id="edicion"
            class="form-control @error('edicion') is-invalid @enderror"
            value="{{ old('edicion', $recurso->edicion ?? '') }}"
            maxlength="100">
        @error('edicion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="id_tipo_recurso">Tipo de recurso</label>
        <select name="id_tipo_recurso" id="id_tipo_recurso" class="form-control @error('id_tipo_recurso') is-invalid @enderror" required>
            <option value="">Seleccione</option>
            @foreach($tiposRecurso as $tipo)
                <option value="{{ $tipo->id_tipo_recurso }}" @selected(old('id_tipo_recurso', $recurso->id_tipo_recurso ?? '') == $tipo->id_tipo_recurso)>
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_tipo_recurso')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="id_nivel_bibliografico">Nivel bibliográfico</label>
        <select name="id_nivel_bibliografico" id="id_nivel_bibliografico" class="form-control @error('id_nivel_bibliografico') is-invalid @enderror">
            <option value="">Seleccione</option>
            @foreach($nivelesBibliograficos as $nivel)
                <option value="{{ $nivel->id_nivel_bibliografico }}" @selected(old('id_nivel_bibliografico', $recurso->id_nivel_bibliografico ?? '') == $nivel->id_nivel_bibliografico)>
                    {{ $nivel->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_nivel_bibliografico')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid form-grid-3">
    <div class="form-group">
        <label class="form-label" for="id_editorial">Editorial</label>
        <select name="id_editorial" id="id_editorial" class="form-control @error('id_editorial') is-invalid @enderror">
            <option value="">Seleccione</option>
            @foreach($editoriales as $editorial)
                <option value="{{ $editorial->id_editorial }}" @selected(old('id_editorial', $recurso->id_editorial ?? '') == $editorial->id_editorial)>
                    {{ $editorial->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_editorial')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="id_pais">País</label>
        <select name="id_pais" id="id_pais" class="form-control @error('id_pais') is-invalid @enderror">
            <option value="">Seleccione</option>
            @foreach($paises as $pais)
                <option value="{{ $pais->id_pais }}" @selected(old('id_pais', $recurso->id_pais ?? '') == $pais->id_pais)>
                    {{ $pais->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_pais')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="id_idioma">Idioma</label>
        <select name="id_idioma" id="id_idioma" class="form-control @error('id_idioma') is-invalid @enderror">
            <option value="">Seleccione</option>
            @foreach($idiomas as $idioma)
                <option value="{{ $idioma->id_idioma }}" @selected(old('id_idioma', $recurso->id_idioma ?? '') == $idioma->id_idioma)>
                    {{ $idioma->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_idioma')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid form-grid-2">
    <div class="form-group">
        <label class="form-label" for="id_tipo_adquisicion">Tipo de adquisición</label>
        <select name="id_tipo_adquisicion" id="id_tipo_adquisicion" class="form-control @error('id_tipo_adquisicion') is-invalid @enderror">
            <option value="">Seleccione</option>
            @foreach($tiposAdquisicion as $tipo)
                <option value="{{ $tipo->id_tipo_adquisicion }}" @selected(old('id_tipo_adquisicion', $recurso->id_tipo_adquisicion ?? '') == $tipo->id_tipo_adquisicion)>
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_tipo_adquisicion')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="id_tipo_acceso">Tipo de acceso</label>
        <select name="id_tipo_acceso" id="id_tipo_acceso" class="form-control @error('id_tipo_acceso') is-invalid @enderror">
            <option value="">Seleccione</option>
            @foreach($tiposAcceso as $tipo)
                <option value="{{ $tipo->id_tipo_acceso }}" @selected(old('id_tipo_acceso', $recurso->id_tipo_acceso ?? '') == $tipo->id_tipo_acceso)>
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_tipo_acceso')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid form-grid-2">
    <div class="form-group">
        <label class="form-label" for="id_autores">Autores</label>
        <select name="id_autores[]" id="id_autores" class="form-control @error('id_autores') is-invalid @enderror" multiple size="6">
            @php
                $autoresSeleccionados = old('id_autores', isset($recurso) ? $recurso->autores->pluck('id_autor')->toArray() : []);
            @endphp
            @foreach($autores as $autor)
                <option value="{{ $autor->id_autor }}" @selected(in_array($autor->id_autor, $autoresSeleccionados))>
                    {{ $autor->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_autores')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="id_generos">Géneros</label>
        <select name="id_generos[]" id="id_generos" class="form-control @error('id_generos') is-invalid @enderror" multiple size="6">
            @php
                $generosSeleccionados = old('id_generos', isset($recurso) ? $recurso->generos->pluck('id_genero')->toArray() : []);
            @endphp
            @foreach($generos as $genero)
                <option value="{{ $genero->id_genero }}" @selected(in_array($genero->id_genero, $generosSeleccionados))>
                    {{ $genero->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_generos')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-grid form-grid-2">
    <div class="form-group">
        <label class="form-label" for="id_clasificaciones">Clasificaciones</label>
        <select name="id_clasificaciones[]" id="id_clasificaciones" class="form-control @error('id_clasificaciones') is-invalid @enderror" multiple size="6">
            @php
                $clasificacionesSeleccionadas = old('id_clasificaciones', isset($recurso) ? $recurso->clasificaciones->pluck('id_clasificacion')->toArray() : []);
            @endphp
            @foreach($clasificaciones as $clasificacion)
                <option value="{{ $clasificacion->id_clasificacion }}" @selected(in_array($clasificacion->id_clasificacion, $clasificacionesSeleccionadas))>
                    {{ $clasificacion->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_clasificaciones')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="id_etiquetas">Etiquetas</label>
        <select name="id_etiquetas[]" id="id_etiquetas" class="form-control @error('id_etiquetas') is-invalid @enderror" multiple size="6">
            @php
                $etiquetasSeleccionadas = old('id_etiquetas', isset($recurso) ? $recurso->etiquetas->pluck('id_etiqueta')->toArray() : []);
            @endphp
            @foreach($etiquetas as $etiqueta)
                <option value="{{ $etiqueta->id_etiqueta }}" @selected(in_array($etiqueta->id_etiqueta, $etiquetasSeleccionadas))>
                    {{ $etiqueta->nombre }}
                </option>
            @endforeach
        </select>
        @error('id_etiquetas')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group">
    <label class="form-label" for="resumen">Resumen</label>
    <textarea
        name="resumen"
        id="resumen"
        rows="4"
        class="form-control @error('resumen') is-invalid @enderror">{{ old('resumen', $recurso->resumen ?? '') }}</textarea>
    @error('resumen')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label" for="tabla_contenido">Tabla de contenido</label>
    <textarea
        name="tabla_contenido"
        id="tabla_contenido"
        rows="4"
        class="form-control @error('tabla_contenido') is-invalid @enderror">{{ old('tabla_contenido', $recurso->tabla_contenido ?? '') }}</textarea>
    @error('tabla_contenido')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label class="form-label" for="notas">Notas</label>
    <textarea
        name="notas"
        id="notas"
        rows="4"
        class="form-control @error('notas') is-invalid @enderror">{{ old('notas', $recurso->notas ?? '') }}</textarea>
    @error('notas')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group" style="margin-top:16px;">
    <label style="display:flex; align-items:center; gap:8px;">
        <input type="checkbox" name="activo" value="1" @checked(old('activo', $recurso->activo ?? true))>
        <span>Activo</span>
    </label>
</div>