<?php

namespace App\Modules\Seg\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'seg_menus';
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'id_sistema',
        'nombre',
        'icono',
        'orden',
        'visible',
    ];

    protected $casts = [
        'visible' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function sistema()
    {
        return $this->belongsTo(Sistema::class, 'id_sistema', 'id_sistema');
    }

    public function items()
    {
        return $this->hasMany(MenuItem::class, 'id_menu', 'id_menu')
            ->whereNull('id_menu_item_padre')
            ->orderBy('orden')
            ->orderBy('nombre');
    }

    public function todosLosItems()
    {
        return $this->hasMany(MenuItem::class, 'id_menu', 'id_menu')
            ->orderBy('orden')
            ->orderBy('nombre');
    }

    public function itemsVisibles()
    {
        return $this->hasMany(MenuItem::class, 'id_menu', 'id_menu')
            ->whereNull('id_menu_item_padre')
            ->where('visible', true)
            ->orderBy('orden')
            ->orderBy('nombre');
    }
}