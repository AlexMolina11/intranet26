<?php

namespace App\Modules\Tik\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormatoTicket extends Model
{
    use SoftDeletes;

    protected $table = 'tik_formatos_ticket';
    protected $primaryKey = 'id_formato_ticket';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'orden',
        'activo',
    ];
}