<?php

namespace App\Modules\Seg\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sistema extends Model
{
    use SoftDeletes;

    protected $table = 'seg_sistemas';
    protected $primaryKey = 'id_sistema';

    protected $fillable = [
        'codigo',
        'nombre',
        'slug',
        'descripcion',
        'icono',
        'url_base',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->hasMany(Rol::class, 'id_sistema', 'id_sistema');
    }

    public function rolesActivos()
    {
        return $this->hasMany(Rol::class, 'id_sistema', 'id_sistema')
            ->where('activo', true);
    }
}