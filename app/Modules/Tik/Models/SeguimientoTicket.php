<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Seg\Models\Usuario;

class SeguimientoTicket extends Model
{
    use SoftDeletes;

    protected $table = 'tik_seguimientos_ticket';
    protected $primaryKey = 'id_seguimiento_ticket';

    protected $fillable = [
        'id_ticket',
        'id_usuario',
        'id_estado_ticket_anterior',
        'id_estado_ticket_nuevo',
        'comentario',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function estadoAnterior()
    {
        return $this->belongsTo(EstadoTicket::class, 'id_estado_ticket_anterior', 'id_estado_ticket');
    }

    public function estadoNuevo()
    {
        return $this->belongsTo(EstadoTicket::class, 'id_estado_ticket_nuevo', 'id_estado_ticket');
    }

    public function getFechaRegistroFormateadaAttribute(): string
    {
        return $this->created_at
            ? $this->created_at->format('d/m/Y h:i a')
            : 'Sin definir';
    }
}