<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NivelBibliografico extends Model
{
    use SoftDeletes;

    protected $table = 'bib_niveles_bibliograficos';
    protected $primaryKey = 'id_nivel_bibliografico';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'orden',
        'activo',
    ];

    protected $casts = [
        'orden' => 'integer',
        'activo' => 'boolean',
    ];
}