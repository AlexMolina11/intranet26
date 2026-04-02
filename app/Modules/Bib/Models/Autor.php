<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autor extends Model
{
    use SoftDeletes;

    protected $table = 'bib_autores';
    protected $primaryKey = 'id_autor';

    protected $fillable = [
        'nombre',
        'apellido',
        'nombre_completo',
        'seudonimo',
        'fecha_nacimiento',
        'fecha_fallecimiento',
        'biografia',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_fallecimiento' => 'date',
        'activo' => 'boolean',
    ];
}