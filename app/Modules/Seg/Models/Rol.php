<?php

namespace App\Modules\Seg\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use SoftDeletes;

    protected $table = 'seg_roles';
    protected $primaryKey = 'id_rol';

    protected $fillable = [
        'id_sistema',
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

    public function sistema()
    {
        return $this->belongsTo(Sistema::class, 'id_sistema', 'id_sistema');
    }
}