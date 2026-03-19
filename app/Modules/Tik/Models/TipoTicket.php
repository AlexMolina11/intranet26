<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoTicket extends Model
{
    use SoftDeletes;

    protected $table = 'tik_tipos_ticket';
    protected $primaryKey = 'id_tipo_ticket';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'id_area_responsable',
        'orden',
        'activo',
    ];

    public function flujos()
    {
        return $this->hasMany(FlujoTicket::class, 'id_tipo_ticket', 'id_tipo_ticket');
    }
}