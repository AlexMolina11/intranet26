<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketRrhh extends Model
{
    use SoftDeletes;

    protected $table = 'tik_ticket_rrhh';
    protected $primaryKey = 'id_ticket_rrhh';

    protected $fillable = [
        'id_ticket',
        'id_tipo_ticket_rrhh',
        'detalle',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }

    public function tipoTicketRrhh()
    {
        return $this->belongsTo(TipoTicketRrhh::class, 'id_tipo_ticket_rrhh', 'id_tipo_ticket_rrhh');
    }
}