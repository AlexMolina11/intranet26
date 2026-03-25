<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Org\Models\Area;

class TipoServicio extends Model
{
    use SoftDeletes;

    protected $table = 'tik_tipos_servicio';
    protected $primaryKey = 'id_tipo_servicio';

    protected $fillable = [
        'codigo',
        'nombre',
        'id_area_responsable',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'id_tipo_servicio', 'id_tipo_servicio')
            ->whereNull('deleted_at')
            ->orderBy('nombre');
    }

    public function areaResponsable()
    {
        return $this->belongsTo(Area::class, 'id_area_responsable', 'id_area');
    }
}