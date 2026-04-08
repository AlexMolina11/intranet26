<?php

namespace App\Modules\Bib\Models;

use App\Modules\Seg\Models\Usuario;
use Illuminate\Database\Eloquent\Model;

class HistorialPrestamo extends Model
{
    protected $table = 'bib_historial_prestamos';
    protected $primaryKey = 'id_historial_prestamo';

    protected $fillable = [
        'id_prestamo',
        'id_estado_prestamo',
        'id_usuario_accion',
        'tipo_movimiento',
        'fecha_movimiento',
        'fecha_prestamo',
        'fecha_vencimiento',
        'fecha_devolucion',
        'dias_autorizados',
        'renovaciones_usadas',
        'renovaciones_maximas',
        'multa_diaria',
        'multa_acumulada',
        'observaciones',
    ];

    protected $casts = [
        'fecha_movimiento' => 'date',
        'fecha_prestamo' => 'date',
        'fecha_vencimiento' => 'date',
        'fecha_devolucion' => 'date',
        'dias_autorizados' => 'integer',
        'renovaciones_usadas' => 'integer',
        'renovaciones_maximas' => 'integer',
        'multa_diaria' => 'decimal:2',
        'multa_acumulada' => 'decimal:2',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'id_prestamo', 'id_prestamo');
    }

    public function estadoPrestamo()
    {
        return $this->belongsTo(EstadoPrestamo::class, 'id_estado_prestamo', 'id_estado_prestamo');
    }

    public function usuarioAccion()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_accion', 'id_usuario');
    }
}