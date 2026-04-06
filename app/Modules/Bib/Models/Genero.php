<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Bib\Models\Recurso;

class Genero extends Model
{
    use SoftDeletes;

    protected $table = 'bib_generos';
    protected $primaryKey = 'id_genero';

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
            'bib_recurso_genero',
            'id_genero',
            'id_recurso',
            'id_genero',
            'id_recurso'
        )->withTimestamps();
    }
}