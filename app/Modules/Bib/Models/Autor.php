<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Bib\Models\Recurso;

class Autor extends Model
{
    use SoftDeletes;

    protected $table = 'bib_autores';
    protected $primaryKey = 'id_autor';

    protected $fillable = [
        'nombre',
        'apellido',
        'nombre_completo',
        'seudonimo',
        'fecha_nacimiento',
        'fecha_fallecimiento',
        'biografia',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_fallecimiento' => 'date',
        'activo' => 'boolean',
    ];

    public function recursos()
    {
        return $this->belongsToMany(
            Recurso::class,
            'bib_recurso_autor',
            'id_autor',
            'id_recurso',
            'id_autor',
            'id_recurso'
        )->withPivot('orden')->withTimestamps();
    }
}