<?php

namespace App\Modules\Seg\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Org\Models\UsuarioArea;
use App\Modules\Seg\Support\HasPermissions;
use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Models\Rol;
use App\Modules\Seg\Models\Permiso;

class Usuario extends Authenticatable
{
    use Notifiable, SoftDeletes, HasPermissions;

    protected $table = 'seg_usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'nombre_usuario',
        'clave',
        'activo',
        'ultimo_acceso',
        'remember_token',
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'ultimo_acceso' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->clave;
    }

    public function getRouteKeyName(): string
    {
        return 'id_usuario';
    }

    public function getNombreCompletoAttribute(): string
    {
        return trim($this->nombres . ' ' . $this->apellidos);
    }

    public function usuarioAreas()
    {
        return $this->hasMany(UsuarioArea::class, 'id_usuario', 'id_usuario');
    }

    public function areaPrincipalAsignada()
    {
        return $this->hasOne(UsuarioArea::class, 'id_usuario', 'id_usuario')
            ->where('es_principal', true);
    }

    public function areasSecundariasAsignadas()
    {
        return $this->hasMany(UsuarioArea::class, 'id_usuario', 'id_usuario')
            ->where('es_principal', false);
    }

    public function sistemas()
    {
        return $this->belongsToMany(
            Sistema::class,
            'seg_usuario_sistema',
            'id_usuario',
            'id_sistema',
            'id_usuario',
            'id_sistema'
        )->withPivot('activo')->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(
            Rol::class,
            'seg_usuario_rol',
            'id_usuario',
            'id_rol',
            'id_usuario',
            'id_rol'
        )->withTimestamps();
    }

    public function permisosDirectos()
    {
        return $this->belongsToMany(
            Permiso::class,
            'seg_usuario_permiso',
            'id_usuario',
            'id_permiso',
            'id_usuario',
            'id_permiso'
        )->withPivot('permitido')->withTimestamps();
    }
}