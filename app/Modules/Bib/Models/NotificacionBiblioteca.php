<?php

namespace App\Modules\Bib\Models;

use App\Modules\Seg\Models\Usuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificacionBiblioteca extends Model
{
    use SoftDeletes;

    protected $table = 'bib_notificaciones';

    protected $primaryKey = 'id_notificacion';

    protected $fillable = [
        'id_usuario',
        'id_prestamo',
        'tipo',
        'titulo',
        'mensaje',
        'fecha_notificacion',
        'leida',
        'fecha_lectura',
        'activo',
    ];

    protected $casts = [
        'fecha_notificacion' => 'date',
        'fecha_lectura' => 'datetime',
        'leida' => 'boolean',
        'activo' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'id_prestamo', 'id_prestamo');
    }
}