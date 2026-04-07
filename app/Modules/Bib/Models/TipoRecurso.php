<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoRecurso extends Model
{
    use SoftDeletes;

    protected $table = 'bib_tipos_recurso';
    protected $primaryKey = 'id_tipo_recurso';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'dias_prestamo_default',
        'renovaciones_default',
        'multa_diaria_default',
        'orden',
        'activo',
    ];

    protected $casts = [
        'dias_prestamo_default' => 'integer',
        'renovaciones_default' => 'integer',
        'multa_diaria_default' => 'decimal:2',
        'orden' => 'integer',
        'activo' => 'boolean',
    ];

    public function politicaPrestamo()
    {
        return $this->hasOne(PoliticaPrestamo::class, 'id_tipo_recurso', 'id_tipo_recurso');
    }
}