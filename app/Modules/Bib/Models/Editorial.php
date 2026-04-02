<?php

namespace App\Modules\Bib\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}