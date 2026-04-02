<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoPrestamo extends Model
{
    use SoftDeletes;

    protected $table = 'bib_estados_prestamo';
    protected $primaryKey = 'id_estado_prestamo';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'es_inicial',
        'es_final',
        'genera_multa',
        'orden',
        'activo',
    ];

    protected $casts = [
        'es_inicial' => 'boolean',
        'es_final' => 'boolean',
        'genera_multa' => 'boolean',
        'orden' => 'integer',
        'activo' => 'boolean',
    ];
}