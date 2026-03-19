<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoTicketRrhh extends Model
{
    use SoftDeletes;

    protected $table = 'tik_tipos_ticket_rrhh';
    protected $primaryKey = 'id_tipo_ticket_rrhh';

    protected $fillable = [
        'id_tipo_ticket',
        'codigo',
        'nombre',
        'descripcion',
        'orden',
        'activo',
    ];
}