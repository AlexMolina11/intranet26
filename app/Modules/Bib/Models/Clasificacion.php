<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Bib\Models\Recurso;

class Clasificacion extends Model
{
    use SoftDeletes;

    protected $table = 'bib_clasificaciones';
    protected $primaryKey = 'id_clasificacion';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'orden',
        'activo',
    ];

    protected $casts = [
        'orden' => 'integer',
        'activo' => 'boolean',
    ];

    public function recursos()
    {
        return $this->belongsToMany(
            Recurso::class,
            'bib_recurso_clasificacion',
            'id_clasificacion',
            'id_recurso',
            'id_clasificacion',
            'id_recurso'
        )->withTimestamps();
    }
}