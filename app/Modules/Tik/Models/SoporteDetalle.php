<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoporteDetalle extends Model
{
    use SoftDeletes;

    protected $table = 'tik_soporte_detalles';
    protected $primaryKey = 'id_soporte_detalle';

    protected $fillable = [
        'id_soporte',
        'id_servicio',
        'id_incidencia',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function soporte()
    {
        return $this->belongsTo(Soporte::class, 'id_soporte', 'id_soporte');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'id_incidencia', 'id_incidencia');
    }
}