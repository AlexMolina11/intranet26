<?php

namespace Database\Seeders\Bib;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BibMenuSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $sistema = DB::table('seg_sistemas')
            ->where('codigo', 'BIB')
            ->first();

        if (!$sistema) {
            return;
        }

        $menus = [
            [
                'nombre' => 'Inicio',
                'icono' => 'fa-solid fa-house',
                'orden' => 1,
                'visible' => 1,
            ],
            [
                'nombre' => 'Atención al usuario',
                'icono' => 'fa-solid fa-user-check',
                'orden' => 2,
                'visible' => 1,
            ],
            [
                'nombre' => 'Gestión bibliográfica',
                'icono' => 'fa-solid fa-book-open-reader',
                'orden' => 3,
                'visible' => 1,
            ],
            [
                'nombre' => 'Operación',
                'icono' => 'fa-solid fa-table-cells-large',
                'orden' => 4,
                'visible' => 1,
            ],
            [
                'nombre' => 'Reportes',
                'icono' => 'fa-solid fa-chart-column',
                'orden' => 5,
                'visible' => 1,
            ],
            [
                'nombre' => 'Configuración',
                'icono' => 'fa-solid fa-gear',
                'orden' => 6,
                'visible' => 1,
            ],
        ];

        foreach ($menus as $menu) {
            DB::table('seg_menus')->updateOrInsert(
                [
                    'id_sistema' => $sistema->id_sistema,
                    'nombre' => $menu['nombre'],
                ],
                [
                    'icono' => $menu['icono'],
                    'orden' => $menu['orden'],
                    'visible' => $menu['visible'],
                    'created_at' => $now,
                    'updated_at' => $now,
                    'deleted_at' => null,
                ]
            );
        }
    }
}