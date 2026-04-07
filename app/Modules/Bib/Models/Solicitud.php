<?php

namespace App\Modules\Bib\Models;

use App\Modules\Seg\Models\Usuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitud extends Model
{
    use SoftDeletes;

    protected $table = 'bib_solicitudes';
    protected $primaryKey = 'id_solicitud';

    protected $fillable = [
        'id_usuario',
        'id_recurso',
        'id_ejemplar',
        'id_estado_solicitud',
        'fecha_solicitud',
        'fecha_requerida',
        'fecha_atencion',
        'motivo',
        'observaciones',
        'observaciones_internas',
        'id_usuario_atiende',
        'activo',
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
        'fecha_requerida' => 'date',
        'fecha_atencion' => 'date',
        'activo' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function recurso()
    {
        return $this->belongsTo(Recurso::class, 'id_recurso', 'id_recurso');
    }

    public function ejemplar()
    {
        return $this->belongsTo(Ejemplar::class, 'id_ejemplar', 'id_ejemplar');
    }

    public function estadoSolicitud()
    {
        return $this->belongsTo(EstadoSolicitud::class, 'id_estado_solicitud', 'id_estado_solicitud');
    }

    public function usuarioAtiende()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_atiende', 'id_usuario');
    }
}