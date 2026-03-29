<?php

namespace Database\Seeders\Tik;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TikMenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'TIK')
            ->first();

        if (!$sistema) {
            return;
        }

        $menus = DB::table('seg_menus')
            ->where('id_sistema', $sistema->id_sistema)
            ->whereIn('nombre', ['Inicio', 'Operación'])
            ->pluck('id_menu', 'nombre');

        $menuInicio = $menus['Inicio'] ?? null;
        $menuOperacion = $menus['Operación'] ?? null;

        if (!$menuInicio || !$menuOperacion) {
            return;
        }

        $items = [
            [
                'id_menu' => $menuInicio,
                'nombre' => 'Dashboard Tickets',
                'ruta' => 'tik.dashboard',
                'icono' => 'fa-solid fa-chart-line',
                'orden' => 1,
                'permiso_requerido' => 'TIK_VER',
            ],
            [
                'id_menu' => $menuInicio,
                'nombre' => 'Mis Tickets',
                'ruta' => 'tik.tickets.index',
                'icono' => 'fa-solid fa-inbox',
                'orden' => 2,
                'permiso_requerido' => 'TIK_TICKETS_VER',
            ],
            [
                'id_menu' => $menuInicio,
                'nombre' => 'Crear Ticket',
                'ruta' => 'tik.tickets.create',
                'icono' => 'fa-solid fa-plus',
                'orden' => 3,
                'permiso_requerido' => 'TIK_TICKETS_CREAR',
            ],
            [
                'id_menu' => $menuOperacion,
                'nombre' => 'Bandeja Administrativa',
                'ruta' => 'tik.admin.tickets.index',
                'icono' => 'fa-solid fa-clipboard-list',
                'orden' => 1,
                'permiso_requerido' => 'TIK_PANEL_ADMIN_VER',
            ],
            [
                'id_menu' => $menuOperacion,
                'nombre' => 'Bandeja de Gestión',
                'ruta' => 'tik.gestor.tickets.index',
                'icono' => 'fa-solid fa-screwdriver-wrench',
                'orden' => 2,
                'permiso_requerido' => 'TIK_PANEL_GESTOR_VER',
            ],
            [
                'id_menu' => $menuOperacion,
                'nombre' => 'Soportes',
                'ruta' => 'tik.soportes.index',
                'icono' => 'fa-solid fa-folder-open',
                'orden' => 3,
                'permiso_requerido' => 'TIK_SOPORTES_VER',
            ],
            [
                'id_menu' => $menuOperacion,
                'nombre' => 'Crear Soporte',
                'ruta' => 'tik.soportes.create',
                'icono' => 'fa-solid fa-file-circle-plus',
                'orden' => 4,
                'permiso_requerido' => 'TIK_SOPORTES_CREAR',
            ],
        ];

        foreach ($items as $item) {
            DB::table('seg_menu_items')->updateOrInsert(
                [
                    'id_menu' => $item['id_menu'],
                    'nombre' => $item['nombre'],
                ],
                [
                    'id_sistema' => $sistema->id_sistema,
                    'id_menu_item_padre' => null,
                    'ruta' => $item['ruta'],
                    'icono' => $item['icono'],
                    'orden' => $item['orden'],
                    'visible' => 1,
                    'es_externo' => 0,
                    'abre_nueva_pestana' => 0,
                    'permiso_requerido' => $item['permiso_requerido'],
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}