<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Seg\Models\Usuario;

class AnexoTicket extends Model
{
    use SoftDeletes;

    protected $table = 'tik_anexos_ticket';
    protected $primaryKey = 'id_anexo_ticket';

    protected $fillable = [
        'id_ticket',
        'id_usuario',
        'nombre_original',
        'nombre_archivo',
        'ruta_archivo',
        'mime_type',
        'peso_bytes',
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

    public function getPesoFormateadoAttribute(): string
    {
        if (!$this->peso_bytes) {
            return 'N/D';
        }

        if ($this->peso_bytes >= 1024 * 1024) {
            return number_format($this->peso_bytes / (1024 * 1024), 2) . ' MB';
        }

        if ($this->peso_bytes >= 1024) {
            return number_format($this->peso_bytes / 1024, 2) . ' KB';
        }

        return $this->peso_bytes . ' bytes';
    }
}