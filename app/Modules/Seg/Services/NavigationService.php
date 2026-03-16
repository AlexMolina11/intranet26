<?php

namespace App\Modules\Seg\Services;

use App\Modules\Seg\Models\Usuario;
use Illuminate\Support\Facades\Route;

class NavigationService
{
    public function buildFor(?Usuario $usuario): array
    {
        if (!$usuario) {
            return [];
        }

        $sistemas = $usuario->sistemasAutorizados()
            ->with([
                'menusVisibles' => function ($query) {
                    $query->with([
                        'itemsVisibles' => function ($query) {
                            $query->with([
                                'hijosVisibles' => function ($subQuery) {
                                    $subQuery->orderBy('orden')->orderBy('nombre');
                                }
                            ])->orderBy('orden')->orderBy('nombre');
                        }
                    ]);
                }
            ])
            ->get();

        $navigation = [];

        foreach ($sistemas as $sistema) {
            $menus = [];

            foreach ($sistema->menusVisibles as $menu) {
                $items = [];

                foreach ($menu->itemsVisibles as $item) {
                    if (!$usuario->tienePermiso($item->permiso_requerido)) {
                        continue;
                    }

                    $hijos = [];

                    foreach ($item->hijosVisibles as $hijo) {
                        if (!$usuario->tienePermiso($hijo->permiso_requerido)) {
                            continue;
                        }

                        $hijos[] = [
                            'id' => $hijo->id_menu_item,
                            'nombre' => $hijo->nombre,
                            'icono' => $hijo->icono,
                            'url' => $this->resolveUrl($hijo->ruta, (bool) $hijo->es_externo),
                            'route_name' => $hijo->ruta,
                            'externo' => (bool) $hijo->es_externo,
                            'nueva_pestana' => (bool) $hijo->abre_nueva_pestana,
                        ];
                    }

                    if (empty($hijos) && blank($item->ruta) && !$item->es_externo) {
                        continue;
                    }

                    $items[] = [
                        'id' => $item->id_menu_item,
                        'nombre' => $item->nombre,
                        'icono' => $item->icono,
                        'url' => $this->resolveUrl($item->ruta, (bool) $item->es_externo),
                        'route_name' => $item->ruta,
                        'externo' => (bool) $item->es_externo,
                        'nueva_pestana' => (bool) $item->abre_nueva_pestana,
                        'hijos' => $hijos,
                    ];
                }

                if (!empty($items)) {
                    $menus[] = [
                        'id' => $menu->id_menu,
                        'nombre' => $menu->nombre,
                        'icono' => $menu->icono,
                        'items' => $items,
                    ];
                }
            }

            if (!empty($menus)) {
                $navigation[] = [
                    'id' => $sistema->id_sistema,
                    'nombre' => $sistema->nombre,
                    'menus' => $menus,
                ];
            }
        }

        return $navigation;
    }

    protected function resolveUrl(?string $ruta, bool $esExterno): string
    {
        if (blank($ruta)) {
            return '#';
        }

        if ($esExterno) {
            return $ruta;
        }

        return Route::has($ruta) ? route($ruta) : '#';
    }
}