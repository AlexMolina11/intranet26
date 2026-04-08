<?php

namespace App\Modules\Bib\Models;

use App\Modules\Seg\Models\Usuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Multa extends Model
{
    use SoftDeletes;

    protected $table = 'bib_multas';
    protected $primaryKey = 'id_multa';

    protected $fillable = [
        'id_prestamo',
        'id_usuario',
        'id_usuario_registra',
        'fecha_multa',
        'dias_atraso',
        'monto',
        'monto_pagado',
        'pagada',
        'fecha_pago',
        'motivo',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'fecha_multa' => 'date',
        'fecha_pago' => 'date',
        'dias_atraso' => 'integer',
        'monto' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
        'pagada' => 'boolean',
        'activo' => 'boolean',
    ];

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class, 'id_prestamo', 'id_prestamo');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function usuarioRegistra()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_registra', 'id_usuario');
    }
}