<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Bib\Models\Recurso;

class Editorial extends Model
{
    use SoftDeletes;

    protected $table = 'bib_editoriales';
    protected $primaryKey = 'id_editorial';

    protected $fillable = [
        'nombre',
        'sigla',
        'sitio_web',
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