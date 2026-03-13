<?php

namespace App\Modules\Seg\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permiso extends Model
{
    use SoftDeletes;

    protected $table = 'seg_permisos';
    protected $primaryKey = 'id_permiso';

    protected $fillable = [
        'id_sistema',
        'codigo',
        'nombre',
        'descripcion',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function sistema()
    {
        return $this->belongsTo(Sistema::class, 'id_sistema', 'id_sistema');
    }

    public function roles()
    {
        return $this->belongsToMany(
            Rol::class,
            'seg_rol_permiso',
            'id_permiso',
            'id_rol',
            'id_permiso',
            'id_rol'
        )->withTimestamps();
    }

    public function usuariosDirectos()
    {
        return $this->belongsToMany(
            Usuario::class,
            'seg_usuario_permiso',
            'id_permiso',
            'id_usuario',
            'id_permiso',
            'id_usuario'
        )->withPivot('permitido')->withTimestamps();
    }
}