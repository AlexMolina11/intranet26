<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ejemplar extends Model
{
    use SoftDeletes;

    protected $table = 'bib_ejemplares';
    protected $primaryKey = 'id_ejemplar';

    protected $fillable = [
        'id_recurso',
        'codigo_inventario',
        'codigo_barras',
        'id_estado_ejemplar',
        'id_disponibilidad',
        'ubicacion',
        'condicion',
        'fecha_adquisicion',
        'costo',
        'activo',
    ];

    protected $casts = [
        'fecha_adquisicion' => 'date',
        'costo' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function recurso()
    {
        return $this->belongsTo(Recurso::class, 'id_recurso', 'id_recurso');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoEjemplar::class, 'id_estado_ejemplar', 'id_estado_ejemplar');
    }

    public function disponibilidad()
    {
        return $this->belongsTo(Disponibilidad::class, 'id_disponibilidad', 'id_disponibilidad');
    }

    public function solicitudes()
    {
        return $this->hasMany(Solicitud::class, 'id_ejemplar', 'id_ejemplar');
    }
}