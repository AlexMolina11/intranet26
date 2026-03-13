<?php

namespace App\Modules\Seg\Models;

use Illuminate\Database\Eloquent\Model;

class UsuarioSistema extends Model
{
    protected $table = 'seg_usuario_sistema';
    protected $primaryKey = 'id_usuario_sistema';

    protected $fillable = [
        'id_usuario',
        'id_sistema',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function sistema()
    {
        return $this->belongsTo(Sistema::class, 'id_sistema', 'id_sistema');
    }
}