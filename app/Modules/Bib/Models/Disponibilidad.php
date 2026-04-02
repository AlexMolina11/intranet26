<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disponibilidad extends Model
{
    use SoftDeletes;

    protected $table = 'bib_disponibilidades';
    protected $primaryKey = 'id_disponibilidad';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'permite_reserva',
        'permite_prestamo',
        'orden',
        'activo',
    ];

    protected $casts = [
        'permite_reserva' => 'boolean',
        'permite_prestamo' => 'boolean',
        'orden' => 'integer',
        'activo' => 'boolean',
    ];
}