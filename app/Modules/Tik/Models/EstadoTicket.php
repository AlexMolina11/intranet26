<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoTicket extends Model
{
    use SoftDeletes;

    protected $table = 'tik_estados_ticket';
    protected $primaryKey = 'id_estado_ticket';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'color',
        'id_estado_siguiente',
        'es_inicial',
        'es_final',
        'orden',
        'activo',
    ];

    public function estadoSiguiente()
    {
        return $this->belongsTo(self::class, 'id_estado_siguiente', 'id_estado_ticket');
    }
}