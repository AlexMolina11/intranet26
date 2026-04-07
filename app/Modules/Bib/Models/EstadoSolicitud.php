<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoSolicitud extends Model
{
    use SoftDeletes;

    protected $table = 'bib_estados_solicitud';
    protected $primaryKey = 'id_estado_solicitud';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'es_inicial',
        'es_final',
        'permite_aprobacion',
        'permite_rechazo',
        'orden',
        'activo',
    ];

    protected $casts = [
        'es_inicial' => 'boolean',
        'es_final' => 'boolean',
        'permite_aprobacion' => 'boolean',
        'permite_rechazo' => 'boolean',
        'orden' => 'integer',
        'activo' => 'boolean',
    ];

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_estado_solicitud', 'id_estado_solicitud');
    }
}