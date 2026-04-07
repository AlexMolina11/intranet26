<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PoliticaPrestamo extends Model
{
    use SoftDeletes;

    protected $table = 'bib_politicas_prestamo';
    protected $primaryKey = 'id_politica_prestamo';

    protected $fillable = [
        'id_tipo_recurso',
        'dias_prestamo',
        'max_renovaciones',
        'max_prestamos_usuario',
        'multa_diaria',
        'permite_reserva',
        'requiere_aprobacion',
        'permite_prestamo_externo',
        'observaciones',
        'orden',
        'activo',
    ];

    protected $casts = [
        'dias_prestamo' => 'integer',
        'max_renovaciones' => 'integer',
        'max_prestamos_usuario' => 'integer',
        'multa_diaria' => 'decimal:2',
        'permite_reserva' => 'boolean',
        'requiere_aprobacion' => 'boolean',
        'permite_prestamo_externo' => 'boolean',
        'orden' => 'integer',
        'activo' => 'boolean',
    ];

    public function tipoRecurso()
    {
        return $this->belongsTo(TipoRecurso::class, 'id_tipo_recurso', 'id_tipo_recurso');
    }
}