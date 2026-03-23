<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Seg\Models\Usuario;
use App\Modules\Org\Models\Area;

class Ticket extends Model
{
    use SoftDeletes;

    protected $table = 'tik_tickets';
    protected $primaryKey = 'id_ticket';

    protected $fillable = [
        'codigo',
        'id_usuario_solicitante',
        'id_usuario_responsable',
        'id_area_solicitante',
        'id_area_responsable',
        'id_tipo_ticket',
        'id_tipo_ticket_rrhh',
        'id_formato_ticket',
        'id_estado_ticket',
        'id_incidencia',
        'id_servicio',
        'asunto',
        'descripcion',
        'fecha_ticket',
        'fecha_asignacion',
        'fecha_cierre',
        'activo',
    ];

    protected $casts = [
        'fecha_ticket' => 'datetime',
        'fecha_asignacion' => 'datetime',
        'fecha_cierre' => 'datetime',
        'activo' => 'boolean',
    ];

    public function solicitante()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_solicitante', 'id_usuario');
    }

    public function responsable()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario_responsable', 'id_usuario');
    }

    public function areaSolicitante()
    {
        return $this->belongsTo(Area::class, 'id_area_solicitante', 'id_area');
    }

    public function areaResponsable()
    {
        return $this->belongsTo(Area::class, 'id_area_responsable', 'id_area');
    }

    public function tipoTicket()
    {
        return $this->belongsTo(TipoTicket::class, 'id_tipo_ticket', 'id_tipo_ticket');
    }

    public function tipoTicketRrhh()
    {
        return $this->belongsTo(TipoTicketRrhh::class, 'id_tipo_ticket_rrhh', 'id_tipo_ticket_rrhh');
    }

    public function formatoTicket()
    {
        return $this->belongsTo(FormatoTicket::class, 'id_formato_ticket', 'id_formato_ticket');
    }

    public function estadoTicket()
    {
        return $this->belongsTo(EstadoTicket::class, 'id_estado_ticket', 'id_estado_ticket');
    }

    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'id_incidencia', 'id_incidencia');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioTicket::class, 'id_ticket', 'id_ticket')
            ->latest('id_comentario_ticket');
    }

    public function anexos()
    {
        return $this->hasMany(AnexoTicket::class, 'id_ticket', 'id_ticket')
            ->latest('id_anexo_ticket');
    }

    public function seguimientos()
    {
        return $this->hasMany(SeguimientoTicket::class, 'id_ticket', 'id_ticket')
            ->latest('id_seguimiento_ticket');
    }

    public function getFechaRegistroFormateadaAttribute(): string
    {
        return $this->created_at
            ? $this->created_at->format('d/m/Y h:i a')
            : 'Sin definir';
    }

    public function getFechaTicketFormateadaAttribute(): string
    {
        return $this->fecha_ticket
            ? $this->fecha_ticket->format('d/m/Y')
            : 'Sin definir';
    }

    public function getFechaCierreFormateadaAttribute(): string
    {
        return $this->fecha_cierre
            ? $this->fecha_cierre->format('d/m/Y h:i a')
            : 'Sin definir';
    }
}