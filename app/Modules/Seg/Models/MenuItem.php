<?php

namespace App\Modules\Seg\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use SoftDeletes;

    protected $table = 'seg_menu_items';
    protected $primaryKey = 'id_menu_item';

    protected $fillable = [
        'id_sistema',
        'id_menu',
        'id_menu_item_padre',
        'nombre',
        'ruta',
        'icono',
        'orden',
        'visible',
        'es_externo',
        'abre_nueva_pestana',
        'permiso_requerido',
    ];

    protected $casts = [
        'visible' => 'boolean',
        'es_externo' => 'boolean',
        'abre_nueva_pestana' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function sistema()
    {
        return $this->belongsTo(Sistema::class, 'id_sistema', 'id_sistema');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id_menu');
    }

    public function padre()
    {
        return $this->belongsTo(MenuItem::class, 'id_menu_item_padre', 'id_menu_item');
    }

    public function hijos()
    {
        return $this->hasMany(MenuItem::class, 'id_menu_item_padre', 'id_menu_item')
            ->orderBy('orden')
            ->orderBy('nombre');
    }

    public function permiso()
    {
        return $this->belongsTo(Permiso::class, 'permiso_requerido', 'codigo');
    }

    public function esSubmenu(): bool
    {
        return !is_null($this->id_menu_item_padre);
    }

    public function hijosVisibles()
    {
        return $this->hasMany(MenuItem::class, 'id_menu_item_padre', 'id_menu_item')
            ->where('visible', true)
            ->orderBy('orden')
            ->orderBy('nombre');
    }
}