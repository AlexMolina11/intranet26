<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seccion extends Model
{
    use SoftDeletes;

    protected $table = 'tik_secciones';
    protected $primaryKey = 'id_seccion';

    protected $fillable = [
        'codigo',
        'nombre',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}