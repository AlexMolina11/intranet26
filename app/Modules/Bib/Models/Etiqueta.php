<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etiqueta extends Model
{
    use SoftDeletes;

    protected $table = 'bib_etiquetas';
    protected $primaryKey = 'id_etiqueta';

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function recursos()
    {
        return $this->belongsToMany(
            Recurso::class,
            'bib_recurso_etiqueta',
            'id_etiqueta',
            'id_recurso',
            'id_etiqueta',
            'id_recurso'
        )->withTimestamps();
    }
}