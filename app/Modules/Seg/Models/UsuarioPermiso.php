<?php

namespace App\Modules\Seg\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioPermiso extends Model
{
    protected $table = 'seg_usuario_permiso';
    protected $primaryKey = 'id_usuario_permiso';

    protected $fillable = [
        'id_usuario',
        'id_permiso',
        'permitido',
    ];

    protected $casts = [
        'permitido' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function permiso()
    {
        return $this->belongsTo(Permiso::class, 'id_permiso', 'id_permiso');
    }
}