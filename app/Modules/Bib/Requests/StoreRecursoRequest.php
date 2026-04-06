<?php

namespace App\Modules\Bib\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRecursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'codigo' => $this->codigo ? strtoupper(trim($this->codigo)) : null,
            'titulo' => $this->titulo ? trim($this->titulo) : null,
            'subtitulo' => $this->subtitulo ? trim($this->subtitulo) : null,
            'isbn' => $this->isbn ? trim($this->isbn) : null,
            'issn' => $this->issn ? trim($this->issn) : null,
            'edicion' => $this->edicion ? trim($this->edicion) : null,
            'resumen' => $this->resumen ? trim($this->resumen) : null,
            'tabla_contenido' => $this->tabla_contenido ? trim($this->tabla_contenido) : null,
            'notas' => $this->notas ? trim($this->notas) : null,
            'orden' => $this->orden ?? 1,
            'activo' => $this->boolean('activo'),
            'id_autores' => array_values(array_filter((array) $this->input('id_autores', []))),
            'id_generos' => array_values(array_filter((array) $this->input('id_generos', []))),
            'id_clasificaciones' => array_values(array_filter((array) $this->input('id_clasificaciones', []))),
            'id_etiquetas' => array_values(array_filter((array) $this->input('id_etiquetas', []))),
        ]);
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'string', 'max:50', Rule::unique('bib_recursos', 'codigo')],
            'titulo' => ['required', 'string', 'max:255'],
            'subtitulo' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:30'],
            'issn' => ['nullable', 'string', 'max:30'],
            'anio_publicacion' => ['nullable', 'integer', 'min:1000', 'max:9999'],
            'edicion' => ['nullable', 'string', 'max:100'],
            'numero_paginas' => ['nullable', 'integer', 'min:1'],
            'resumen' => ['nullable', 'string'],
            'tabla_contenido' => ['nullable', 'string'],
            'notas' => ['nullable', 'string'],

            'id_editorial' => ['nullable', 'integer', Rule::exists('bib_editoriales', 'id_editorial')->whereNull('deleted_at')],
            'id_pais' => ['nullable', 'integer', Rule::exists('bib_paises', 'id_pais')->whereNull('deleted_at')],
            'id_idioma' => ['nullable', 'integer', Rule::exists('bib_idiomas', 'id_idioma')->whereNull('deleted_at')],
            'id_nivel_bibliografico' => ['nullable', 'integer', Rule::exists('bib_niveles_bibliograficos', 'id_nivel_bibliografico')->whereNull('deleted_at')],
            'id_tipo_recurso' => ['required', 'integer', Rule::exists('bib_tipos_recurso', 'id_tipo_recurso')->whereNull('deleted_at')],
            'id_tipo_adquisicion' => ['nullable', 'integer', Rule::exists('bib_tipos_adquisicion', 'id_tipo_adquisicion')->whereNull('deleted_at')],
            'id_tipo_acceso' => ['nullable', 'integer', Rule::exists('bib_tipos_acceso', 'id_tipo_acceso')->whereNull('deleted_at')],

            'orden' => ['required', 'integer', 'min:1'],
            'activo' => ['nullable', 'boolean'],

            'id_autores' => ['nullable', 'array'],
            'id_autores.*' => ['integer', Rule::exists('bib_autores', 'id_autor')->whereNull('deleted_at')],

            'id_generos' => ['nullable', 'array'],
            'id_generos.*' => ['integer', Rule::exists('bib_generos', 'id_genero')->whereNull('deleted_at')],

            'id_clasificaciones' => ['nullable', 'array'],
            'id_clasificaciones.*' => ['integer', Rule::exists('bib_clasificaciones', 'id_clasificacion')->whereNull('deleted_at')],

            'id_etiquetas' => ['nullable', 'array'],
            'id_etiquetas.*' => ['integer', Rule::exists('bib_etiquetas', 'id_etiqueta')->whereNull('deleted_at')],
        ];
    }
}