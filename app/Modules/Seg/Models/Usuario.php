<?php

namespace App\Modules\Seg\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Authenticatable
{
    use Notifiable, SoftDeletes;

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
}