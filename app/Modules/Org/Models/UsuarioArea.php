<?php

namespace App\Modules\Org\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Seg\Models\Usuario;

class UsuarioArea extends Model
{
    protected $table = 'org_usuario_area';
    protected $primaryKey = 'id_usuario_area';

    protected $fillable = [
        'id_usuario',
        'id_area',
        'es_principal',
    ];

    protected $casts = [
        'es_principal' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id_area');
    }
}