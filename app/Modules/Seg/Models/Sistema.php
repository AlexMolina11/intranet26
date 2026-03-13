<?php

namespace App\Modules\Seg\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Seg\Models\Rol;
use App\Modules\Seg\Models\Permiso;
use App\Modules\Seg\Models\Menu;
use App\Modules\Seg\Models\MenuItem;

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

    public function permisos()
    {
        return $this->hasMany(Permiso::class, 'id_sistema', 'id_sistema');
    }

    public function usuariosConAcceso()
    {
        return $this->belongsToMany(
            Usuario::class,
            'seg_usuario_sistema',
            'id_sistema',
            'id_usuario',
            'id_sistema',
            'id_usuario'
        )->withPivot('activo')->withTimestamps();
    }

    public function menus()
    {
        return $this->hasMany(Menu::class, 'id_sistema', 'id_sistema')
            ->orderBy('orden')
            ->orderBy('nombre');
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'id_sistema', 'id_sistema')
            ->orderBy('orden')
            ->orderBy('nombre');
    }
}