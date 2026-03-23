<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Seg\Models\Usuario;

class EncuestaSoporte extends Model
{
    use SoftDeletes;

    protected $table = 'tik_encuestas_soporte';
    protected $primaryKey = 'id_encuesta_soporte';

    protected $fillable = [
        'id_ticket',
        'id_usuario',
        'calificacion',
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

    public function getFechaRegistroFormateadaAttribute(): string
    {
        return $this->created_at
            ? $this->created_at->format('d/m/Y h:i a')
            : 'Sin definir';
    }
}