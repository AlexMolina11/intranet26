<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoAcceso extends Model
{
    use SoftDeletes;

    protected $table = 'bib_tipos_acceso';
    protected $primaryKey = 'id_tipo_acceso';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'permite_prestamo',
        'requiere_autorizacion',
        'orden',
        'activo',
    ];

    protected $casts = [
        'permite_prestamo' => 'boolean',
        'requiere_autorizacion' => 'boolean',
        'orden' => 'integer',
        'activo' => 'boolean',
    ];
}