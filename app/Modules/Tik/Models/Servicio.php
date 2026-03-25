<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Org\Models\Area;

class Servicio extends Model
{
    use SoftDeletes;

    protected $table = 'tik_servicios';
    protected $primaryKey = 'id_servicio';

    protected $fillable = [
        'id_tipo_servicio',
        'codigo',
        'nombre',
        'id_area_responsable',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function tipoServicio()
    {
        return $this->belongsTo(TipoServicio::class, 'id_tipo_servicio', 'id_tipo_servicio');
    }

    public function areaResponsable()
    {
        return $this->belongsTo(Area::class, 'id_area_responsable', 'id_area');
    }

    public function detallesSoporte()
    {
        return $this->hasMany(SoporteDetalle::class, 'id_servicio', 'id_servicio');
    }
}