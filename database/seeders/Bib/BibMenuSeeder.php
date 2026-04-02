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
                'nombre' => 'Operación',
                'icono' => 'fa-solid fa-book',
                'orden' => 2,
                'visible' => 1,
            ],
            [
                'nombre' => 'Configuración',
                'icono' => 'fa-solid fa-gear',
                'orden' => 3,
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