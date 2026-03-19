<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;

    protected $table = 'tik_servicios';
    protected $primaryKey = 'id_servicio';

    protected $fillable = [
        'id_tipo_servicio',
        'codigo',
        'nombre',
        'descripcion',
        'orden',
        'activo',
    ];
}