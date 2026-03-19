<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incidencia extends Model
{
    use SoftDeletes;

    protected $table = 'tik_incidencias';
    protected $primaryKey = 'id_incidencia';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'id_area_responsable',
        'orden',
        'activo',
    ];
}