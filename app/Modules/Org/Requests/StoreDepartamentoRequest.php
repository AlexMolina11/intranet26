<?php

namespace App\Modules\Org\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;

    protected $table = 'org_areas';
    protected $primaryKey = 'id_area';

    protected $fillable = [
        'id_departamento',
        'id_proyecto',
        'nombre',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento', 'id_departamento');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto', 'id_proyecto');
    }

    public function getNombreCompletoAttribute(): string
    {
        $departamento = $this->departamento->nombre ?? 'Sin departamento';
        $proyecto = $this->proyecto->nombre ?? 'Sin proyecto';
        $area = $this->nombre ?? 'Sin área';

        return $departamento . ' / ' . $proyecto . ' / ' . $area;
    }
}