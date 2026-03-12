<?php

namespace App\Modules\Org\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use SoftDeletes;

    protected $table = 'org_departamentos';
    protected $primaryKey = 'id_departamento';

    protected $fillable = [
        'codigo',
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

    public function areas()
    {
        return $this->hasMany(Area::class, 'id_departamento', 'id_departamento');
    }
}