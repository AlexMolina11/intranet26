<?php

namespace App\Modules\Seg\Services;

use App\Modules\Seg\Models\Sistema;
use App\Modules\Seg\Models\Usuario;
use Illuminate\Support\Facades\Route;

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
                $menus = collect($sistema->menus)
                    ->map(function ($menu) use ($usuario) {
                        $items = collect($menu->items)
                            ->map(function ($item) use ($usuario) {
                                $hijos = collect($item->children ?? [])
                                    ->filter(fn ($child) => $this->canSeeItem($usuario, $child->permiso_requerido))
                                    ->map(fn ($child) => $this->mapItem($child))
                                    ->filter(fn ($child) => !empty($child['url']))
                                    ->values()
                                    ->all();

                                $canSeeParent = $this->canSeeItem($usuario, $item->permiso_requerido);

                                if (!$canSeeParent && empty($hijos)) {
                                    return null;
                                }

                                $mapped = $this->mapItem($item);
                                $mapped['hijos'] = $hijos;

                                if (empty($mapped['url']) && empty($mapped['hijos'])) {
                                    return null;
                                }

                                return $mapped;
                            })
                            ->filter()
                            ->values()
                            ->all();

                        if (empty($items)) {
                            return null;
                        }

                        return [
                            'id_menu' => $menu->id_menu,
                            'nombre' => $menu->nombre,
                            'icono' => $menu->icono,
                            'items' => $items,
                        ];
                    })
                    ->filter()
                    ->values()
                    ->all();

                if (empty($menus)) {
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

    protected function mapItem($item): array
    {
        return [
            'id_menu_item' => $item->id_menu_item,
            'nombre' => $item->nombre,
            'icono' => $item->icono,
            'route_name' => $item->es_externo ? null : $item->ruta,
            'url' => $this->resolveUrl($item),
            'externo' => (bool) $item->es_externo,
            'nueva_pestana' => (bool) $item->abre_nueva_pestana,
            'hijos' => [],
        ];
    }

    protected function resolveUrl($item): ?string
    {
        if (!$item->ruta) {
            return null;
        }

        if ($item->es_externo) {
            return $item->ruta;
        }

        if (!Route::has($item->ruta)) {
            return null;
        }

        return route($item->ruta);
    }
}