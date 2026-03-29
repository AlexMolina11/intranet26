<?php

namespace App\Modules\Seg\Services;

use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Models\Usuario;

class NavigationService
{
    public function buildFor(Usuario $usuario, ?string $activeSystemCode = null): array
    {
        $query = $usuario->sistemasAutorizados()
            ->with([
                'menus' => function ($menuQuery) {
                    $menuQuery->where('visible', true)
                        ->orderBy('orden')
                        ->with([
                            'items' => function ($itemQuery) {
                                $itemQuery->where('visible', true)
                                    ->whereNull('id_menu_item_padre')
                                    ->orderBy('orden')
                                    ->with([
                                        'children' => function ($childQuery) {
                                            $childQuery->where('visible', true)
                                                ->orderBy('orden');
                                        },
                                    ]);
                            },
                        ]);
                },
            ])
            ->orderBy('orden');

        if ($activeSystemCode) {
            $query->where('codigo', $activeSystemCode);
        }

        $sistemas = $query->get();

        return $sistemas
            ->map(function (Sistema $sistema) use ($usuario) {
                $menus = $sistema->menus
                    ->map(function ($menu) use ($usuario) {
                        $items = $menu->items
                            ->map(function ($item) use ($usuario) {
                                $children = collect($item->children ?? [])
                                    ->filter(function ($child) use ($usuario) {
                                        return $this->canSeeItem($usuario, $child->permiso_requerido);
                                    })
                                    ->map(function ($child) {
                                        $child->resolved_url = $this->resolveUrl($child);
                                        return $child;
                                    })
                                    ->values();

                                $canSeeParent = $this->canSeeItem($usuario, $item->permiso_requerido);

                                if (!$canSeeParent && $children->isEmpty()) {
                                    return null;
                                }

                                $item->children = $children;
                                $item->resolved_url = $this->resolveUrl($item);

                                return $item;
                            })
                            ->filter()
                            ->values();

                        if ($items->isEmpty()) {
                            return null;
                        }

                        $menu->items = $items;

                        return $menu;
                    })
                    ->filter()
                    ->values();

                if ($menus->isEmpty()) {
                    return null;
                }

                return [
                    'id_sistema' => $sistema->id_sistema,
                    'codigo' => $sistema->codigo,
                    'nombre' => $sistema->nombre,
                    'slug' => $sistema->slug,
                    'icono' => $sistema->icono,
                    'menus' => $menus,
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    protected function canSeeItem(Usuario $usuario, ?string $permisoRequerido): bool
    {
        if (!$permisoRequerido) {
            return true;
        }

        return $usuario->tienePermiso($permisoRequerido);
    }

    protected function resolveUrl($item): ?string
    {
        if (!$item->ruta) {
            return null;
        }

        if ($item->es_externo) {
            return $item->ruta;
        }

        return route_exists($item->ruta) ? route($item->ruta) : null;
    }
}

if (!function_exists('route_exists')) {
    function route_exists(string $name): bool
    {
        return app('router')->has($name);
    }
}