<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlujoTicket extends Model
{
    use SoftDeletes;

    protected $table = 'tik_flujos_ticket';
    protected $primaryKey = 'id_flujo_ticket';

    protected $fillable = [
        'id_tipo_ticket',
        'id_estado_ticket',
        'mensaje_usuario',
        'mensaje_admin',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function estado()
    {
        return $this->belongsTo(EstadoTicket::class, 'id_estado_ticket', 'id_estado_ticket');
    }

    public function tipoTicket()
    {
        return $this->belongsTo(TipoTicket::class, 'id_tipo_ticket', 'id_tipo_ticket');
    }
    
    public function estadoTicket()
    {
        return $this->belongsTo(\App\Modules\Tik\Models\EstadoTicket::class, 'id_estado_ticket', 'id_estado_ticket');
    }
}