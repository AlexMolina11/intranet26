<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoEjemplar extends Model
{
    use SoftDeletes;

    protected $table = 'bib_estados_ejemplar';
    protected $primaryKey = 'id_estado_ejemplar';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'es_prestable',
        'afecta_inventario',
        'orden',
        'activo',
    ];

    protected $casts = [
        'es_prestable' => 'boolean',
        'afecta_inventario' => 'boolean',
        'orden' => 'integer',
        'activo' => 'boolean',
    ];
}