<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recurso extends Model
{
    use SoftDeletes;

    protected $table = 'bib_recursos';
    protected $primaryKey = 'id_recurso';

    protected $fillable = [
        'codigo',
        'titulo',
        'subtitulo',
        'isbn',
        'issn',
        'anio_publicacion',
        'edicion',
        'numero_paginas',
        'resumen',
        'tabla_contenido',
        'notas',
        'id_editorial',
        'id_pais',
        'id_idioma',
        'id_nivel_bibliografico',
        'id_tipo_recurso',
        'id_tipo_adquisicion',
        'id_tipo_acceso',
        'orden',
        'activo',
    ];

    protected $casts = [
        'anio_publicacion' => 'integer',
        'numero_paginas' => 'integer',
        'orden' => 'integer',
        'activo' => 'boolean',
    ];

    public function editorial()
    {
        return $this->belongsTo(Editorial::class, 'id_editorial', 'id_editorial');
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais', 'id_pais');
    }

    public function idioma()
    {
        return $this->belongsTo(Idioma::class, 'id_idioma', 'id_idioma');
    }

    public function nivelBibliografico()
    {
        return $this->belongsTo(NivelBibliografico::class, 'id_nivel_bibliografico', 'id_nivel_bibliografico');
    }

    public function tipoRecurso()
    {
        return $this->belongsTo(TipoRecurso::class, 'id_tipo_recurso', 'id_tipo_recurso');
    }

    public function tipoAdquisicion()
    {
        return $this->belongsTo(TipoAdquisicion::class, 'id_tipo_adquisicion', 'id_tipo_adquisicion');
    }

    public function tipoAcceso()
    {
        return $this->belongsTo(TipoAcceso::class, 'id_tipo_acceso', 'id_tipo_acceso');
    }

    public function autores()
    {
        return $this->belongsToMany(
            Autor::class,
            'bib_recurso_autor',
            'id_recurso',
            'id_autor',
            'id_recurso',
            'id_autor'
        )->withPivot('orden')->withTimestamps()->orderByPivot('orden');
    }

    public function generos()
    {
        return $this->belongsToMany(
            Genero::class,
            'bib_recurso_genero',
            'id_recurso',
            'id_genero',
            'id_recurso',
            'id_genero'
        )->withTimestamps()->orderBy('nombre');
    }

    public function clasificaciones()
    {
        return $this->belongsToMany(
            Clasificacion::class,
            'bib_recurso_clasificacion',
            'id_recurso',
            'id_clasificacion',
            'id_recurso',
            'id_clasificacion'
        )->withTimestamps()->orderBy('nombre');
    }

    public function etiquetas()
    {
        return $this->belongsToMany(
            Etiqueta::class,
            'bib_recurso_etiqueta',
            'id_recurso',
            'id_etiqueta',
            'id_recurso',
            'id_etiqueta'
        )->withTimestamps()->orderBy('nombre');
    }

    public function getTituloCompletoAttribute(): string
    {
        return $this->subtitulo
            ? $this->titulo . ': ' . $this->subtitulo
            : $this->titulo;
    }
}