<?php

namespace Database\Seeders\Seg;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'INTRANET')
            ->first();

        if (!$sistema) {
            return;
        }

        $menus = DB::table('seg_menus')
            ->where('id_sistema', $sistema->id_sistema)
            ->whereIn('nombre', ['Seguridad', 'Organización'])
            ->pluck('id_menu', 'nombre');

        $menuSeguridad = $menus['Seguridad'] ?? null;
        $menuOrganizacion = $menus['Organización'] ?? null;

        if (!$menuSeguridad || !$menuOrganizacion) {
            return;
        }

        DB::table('seg_menu_items')->updateOrInsert(
            [
                'id_menu' => $menuSeguridad,
                'nombre' => 'Usuarios',
            ],
            [
                'id_sistema' => $sistema->id_sistema,
                'id_menu_item_padre' => null,
                'ruta' => 'seg.usuarios.index',
                'icono' => 'fa-solid fa-users',
                'orden' => 1,
                'visible' => 1,
                'es_externo' => 0,
                'abre_nueva_pestana' => 0,
                'permiso_requerido' => 'USUARIOS_VER',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );

        DB::table('seg_menu_items')->updateOrInsert(
            [
                'id_menu' => $menuSeguridad,
                'nombre' => 'Sistemas',
            ],
            [
                'id_sistema' => $sistema->id_sistema,
                'id_menu_item_padre' => null,
                'ruta' => 'seg.sistemas.index',
                'icono' => 'fa-solid fa-server',
                'orden' => 2,
                'visible' => 1,
                'es_externo' => 0,
                'abre_nueva_pestana' => 0,
                'permiso_requerido' => 'SISTEMAS_VER',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );


        DB::table('seg_menu_items')->updateOrInsert(
            [
                'id_menu' => $menuSeguridad,
                'nombre' => 'Permisos',
            ],
            [
                'id_sistema' => $sistema->id_sistema,
                'id_menu_item_padre' => null,
                'ruta' => 'seg.permisos.index',
                'icono' => 'fa-solid fa-lock',
                'orden' => 4,
                'visible' => 1,
                'es_externo' => 0,
                'abre_nueva_pestana' => 0,
                'permiso_requerido' => 'PERMISOS_VER',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );

        DB::table('seg_menu_items')->updateOrInsert(
            [
                'id_menu' => $menuSeguridad,
                'nombre' => 'Menús',
            ],
            [
                'id_sistema' => $sistema->id_sistema,
                'id_menu_item_padre' => null,
                'ruta' => 'seg.menus.index',
                'icono' => 'fa-solid fa-list',
                'orden' => 5,
                'visible' => 1,
                'es_externo' => 0,
                'abre_nueva_pestana' => 0,
                'permiso_requerido' => 'MENUS_VER',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );

        $menuMenus = DB::table('seg_menu_items')
            ->where('id_menu', $menuSeguridad)
            ->where('nombre', 'Menús')
            ->first();

        if ($menuMenus) {
            DB::table('seg_menu_items')->updateOrInsert(
                [
                    'id_menu' => $menuSeguridad,
                    'nombre' => 'Items de menú',
                ],
                [
                    'id_sistema' => $sistema->id_sistema,
                    'id_menu_item_padre' => $menuMenus->id_menu_item,
                    'ruta' => 'seg.menu-items.index',
                    'icono' => 'fa-solid fa-list',
                    'orden' => 1,
                    'visible' => 1,
                    'es_externo' => 0,
                    'abre_nueva_pestana' => 0,
                    'permiso_requerido' => 'MENU_ITEMS_VER',
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }

        DB::table('seg_menu_items')->updateOrInsert(
            [
                'id_menu' => $menuOrganizacion,
                'nombre' => 'Departamentos',
            ],
            [
                'id_sistema' => $sistema->id_sistema,
                'id_menu_item_padre' => null,
                'ruta' => 'org.departamentos.index',
                'icono' => 'fa-solid fa-building',
                'orden' => 1,
                'visible' => 1,
                'es_externo' => 0,
                'abre_nueva_pestana' => 0,
                'permiso_requerido' => 'ORG_DEPARTAMENTOS_VER',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );

        DB::table('seg_menu_items')->updateOrInsert(
            [
                'id_menu' => $menuOrganizacion,
                'nombre' => 'Proyectos',
            ],
            [
                'id_sistema' => $sistema->id_sistema,
                'id_menu_item_padre' => null,
                'ruta' => 'org.proyectos.index',
                'icono' => 'fa-solid fa-folder',
                'orden' => 2,
                'visible' => 1,
                'es_externo' => 0,
                'abre_nueva_pestana' => 0,
                'permiso_requerido' => 'ORG_PROYECTOS_VER',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );

        DB::table('seg_menu_items')->updateOrInsert(
            [
                'id_menu' => $menuOrganizacion,
                'nombre' => 'Áreas',
            ],
            [
                'id_sistema' => $sistema->id_sistema,
                'id_menu_item_padre' => null,
                'ruta' => 'org.areas.index',
                'icono' => 'fa-solid fa-diagram-project',
                'orden' => 3,
                'visible' => 1,
                'es_externo' => 0,
                'abre_nueva_pestana' => 0,
                'permiso_requerido' => 'ORG_AREAS_VER',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at' => null,
            ]
        );
    }
}