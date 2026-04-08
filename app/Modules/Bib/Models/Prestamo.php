<?php

namespace App\Modules\Bib\Models;

use App\Modules\Seg\Models\Usuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestamo extends Model
{
    use SoftDeletes;

    protected $table = 'bib_prestamos';
    protected $primaryKey = 'id_prestamo';

    protected $fillable = [
        'id_usuario',
        'id_recurso',
        'id_ejemplar',
        'id_estado_prestamo',
        'id_solicitud',
        'id_usuario_entrega',
        'id_usuario_recibe',
        'fecha_prestamo',
        'fecha_vencimiento',
        'fecha_devolucion',
        'dias_autorizados',
        'renovaciones_usadas',
        'renovaciones_maximas',
        'multa_diaria',
        'multa_acumulada',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_vencimiento' => 'date',
        'fecha_devolucion' => 'date',
        'dias_autorizados' => 'integer',
        'renovaciones_usadas' => 'integer',
        'renovaciones_maximas' => 'integer',
        'multa_diaria' => 'decimal:2',
        'multa_acumulada' => 'decimal:2',
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

    public function estadoPrestamo()
    {
        return $this->belongsTo(EstadoPrestamo::class, 'id_estado_prestamo', 'id_estado_prestamo');
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud', 'id_solicitud');
    }

    public function usuarioEntrega()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_entrega', 'id_usuario');
    }

    public function usuarioRecibe()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_recibe', 'id_usuario');
    }
}